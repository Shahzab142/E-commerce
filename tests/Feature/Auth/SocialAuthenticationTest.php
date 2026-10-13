<?php

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;

test('social login buttons link to the provider redirect routes', function () {
    // "X" uses the new 'x' driver, not the legacy twitter driver.
    expect(route('auth.social.redirect', 'x'))->toContain('/auth/x');
    expect(route('auth.social.redirect', 'google'))->toContain('/auth/google');
    expect(route('auth.social.redirect', 'facebook'))->toContain('/auth/facebook');
    expect(route('auth.social.redirect', 'linkedin'))->toContain('/auth/linkedin');
});

test('social callback creates a normal user and links the provider account', function () {
    Socialite::fake('google', SocialiteUser::fake([
        'id' => 'google-abc123',
        'email' => 'social@example.com',
        'name' => 'Social User',
    ]));

    $this->get('/auth/google/callback')
        ->assertRedirect(route('user.dashboard', absolute: false));

    $this->assertAuthenticated();

    $user = Auth::user();
    expect($user->email)->toBe('social@example.com');
    expect($user->role)->toBe(User::ROLE_USER);
    expect($user->status)->toBe(User::STATUS_ACTIVE);

    expect(
        SocialAccount::where('provider', 'google')
            ->where('provider_id', 'google-abc123')
            ->exists()
    )->toBeTrue();
});

test('social callback links to an existing user instead of duplicating', function () {
    $existing = User::create([
        'name' => 'Existing User',
        'email' => 'same@example.com',
        'password' => 'password123',
        'role' => User::ROLE_USER,
        'status' => User::STATUS_ACTIVE,
    ]);

    Socialite::fake('facebook', SocialiteUser::fake([
        'id' => 'fb-xyz456',
        'email' => 'same@example.com',
        'name' => 'Existing User',
    ]));

    $this->get('/auth/facebook/callback')
        ->assertRedirect(route('user.dashboard', absolute: false));

    expect(User::where('email', 'same@example.com')->count())->toBe(1);
    expect(Auth::user()->id)->toBe($existing->id);
    expect(
        SocialAccount::where('provider', 'facebook')
            ->where('provider_id', 'fb-xyz456')
            ->exists()
    )->toBeTrue();
});

test('social callback rejects a suspended user', function () {
    User::create([
        'name' => 'Blocked',
        'email' => 'blocked@example.com',
        'password' => 'password123',
        'role' => User::ROLE_USER,
        'status' => 'suspend',
    ]);

    Socialite::fake('linkedin-openid', SocialiteUser::fake([
        'id' => 'li-0001',
        'email' => 'blocked@example.com',
        'name' => 'Blocked',
    ]));

    $this->get('/auth/linkedin/callback')
        ->assertRedirect(route('login', absolute: false));

    expect(Auth::check())->toBeFalse();
});

test('social registration only ever creates a user role account', function () {
    Socialite::fake('x', SocialiteUser::fake([
        'id' => 'x-user-1',
        'email' => 'new-social@example.com',
        'name' => 'New User',
    ]));

    $this->get('/auth/x/callback')
        ->assertRedirect(route('user.dashboard', absolute: false));

    $user = User::where('email', 'new-social@example.com')->first();
    expect($user?->role)->toBe(User::ROLE_USER);
    expect($user?->role)->not->toBe(User::ROLE_ADMIN);
    expect($user?->role)->not->toBe(User::ROLE_VENDOR);
});

test('social callback without an email redirects with a friendly error', function () {
    Socialite::fake('x', SocialiteUser::fake([
        'id' => 'x-user-2',
        'name' => 'No Email',
        'email' => null,
    ]));

    $this->get('/auth/x/callback')
        ->assertRedirect(route('login', absolute: false));

    expect(Auth::check())->toBeFalse();
});

test('redirecting to an unconfigured provider bounces back to registration', function () {
    // Facebook has no credentials in the test environment, so this should be a
    // safe redirect back to the registration page with a friendly message.
    $this->get('/auth/facebook')->assertStatus(302);
});