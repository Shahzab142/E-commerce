<?php

use App\Models\User;
use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;

test('reset password screen can be rendered', function () {
    $response = $this->get('/forgot-password');

    $response->assertStatus(200);
});

test('password reset link can be requested for an existing account', function () {
    Notification::fake();

    $user = User::factory()->create();

    $response = $this->post(route('password.email'), [
        'email' => $user->email,
    ]);

    $response->assertSessionHas('status');

    Notification::assertSentTo($user, CustomResetPasswordNotification::class);
});

test('unknown emails receive no reset link and no account disclosure', function () {
    Notification::fake();

    $response = $this->post(route('password.email'), [
        'email' => 'ghost@example.com',
    ]);

    $response->assertSessionHas('status');

    Notification::assertNothingSent();
});

test('password can be reset with a valid token', function () {
    Notification::fake();

    $user = User::factory()->create();

    $response = $this->post(route('password.email'), [
        'email' => $user->email,
    ]);

    $response->assertSessionHas('status');

    $token = Password::broker()->createToken($user);

    $response = $this->post(route('password.update'), [
        'token' => $token,
        'email' => $user->email,
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ]);

    $response->assertSessionHas('status');

    expect(Hash::check('new-password', $user->fresh()->password))->toBeTrue();
});

test('password reset fails with invalid token', function () {
    Notification::fake();

    $user = User::factory()->create();

    $response = $this->post(route('password.update'), [
        'token' => 'invalid-token',
        'email' => $user->email,
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ]);

    $response->assertSessionHasErrors('email');

    expect(Hash::check('new-password', $user->fresh()->password))->toBeFalse();
});

test('password reset requires a confirmed password', function () {
    Notification::fake();

    $user = User::factory()->create();
    $token = Password::broker()->createToken($user);

    $response = $this->post(route('password.update'), [
        'token' => $token,
        'email' => $user->email,
        'password' => 'new-password',
        'password_confirmation' => 'different-password',
    ]);

    $response->assertSessionHasErrors('password');

    expect(Hash::check('new-password', $user->fresh()->password))->toBeFalse();
});
