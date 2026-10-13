<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Volt\Volt;

test('profile page is displayed', function () {
    $this->actingAs($user = User::factory()->create());

    $this->get('/settings/profile')->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Volt::test('settings.profile')
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->call('updateProfileInformation');

    $response->assertHasNoErrors();

    $user->refresh();

    expect($user->name)->toEqual('Test User');
    expect($user->email)->toEqual('test@example.com');
    expect($user->email_verified_at)->toBeNull();
});

test('profile image can be uploaded', function () {
    Storage::fake('public');
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Volt::test('settings.profile')
        ->set('image', UploadedFile::fake()->image('profile.jpg'))
        ->call('updateProfileInformation');

    $response->assertHasNoErrors();

    $imagePath = $user->refresh()->image;

    expect($imagePath)->toStartWith('avatars/');
    Storage::disk('public')->assertExists($imagePath);
});

test('dashboard profile image can be uploaded', function () {
    Storage::fake('public');
    $user = User::factory()->create();

    $response = $this->actingAs($user)->patch(route('user.settings.update'), [
        'name' => $user->name,
        'email' => $user->email,
        'phone' => '',
        'address' => '',
        'image' => UploadedFile::fake()->image('dashboard-profile.jpg'),
    ]);

    $response->assertRedirect();

    $imagePath = $user->refresh()->image;

    expect($imagePath)->toStartWith('avatars/');
    Storage::disk('public')->assertExists($imagePath);
});

test('email verification status is unchanged when email address is unchanged', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Volt::test('settings.profile')
        ->set('name', 'Test User')
        ->set('email', $user->email)
        ->call('updateProfileInformation');

    $response->assertHasNoErrors();

    expect($user->refresh()->email_verified_at)->not->toBeNull();
});

test('user can delete their account', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Volt::test('settings.delete-user-form')
        ->set('password', 'password')
        ->call('deleteUser');

    $response
        ->assertHasNoErrors()
        ->assertRedirect('/');

    // Users are soft-deleted (recycle bin); the record must be trashed, not hard-deleted.
    expect($user->fresh()->trashed())->toBeTrue();
    expect(auth()->check())->toBeFalse();
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Volt::test('settings.delete-user-form')
        ->set('password', 'wrong-password')
        ->call('deleteUser');

    $response->assertHasErrors(['password']);

    expect($user->fresh())->not->toBeNull();
});