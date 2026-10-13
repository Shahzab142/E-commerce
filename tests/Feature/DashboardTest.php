<?php

use App\Models\User;
use Illuminate\Support\Facades\Storage;

test('guests are redirected to the login page', function () {
    $response = $this->get('/dashboard');
    $response->assertRedirect('/login');
});

test('authenticated users are redirected to their dashboard', function () {
    $user = User::factory()->create(['role' => 'user']);
    $this->actingAs($user);

    $response = $this->get('/dashboard');
    $response->assertRedirect('/user');
});

test('admin users are redirected to admin dashboard', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);

    $response = $this->get('/dashboard');
    $response->assertRedirect('/admin');
});

test('vendor users are redirected to vendor dashboard', function () {
    $vendor = User::factory()->create(['role' => 'vendor']);
    $this->actingAs($vendor);

    $response = $this->get('/dashboard');
    $response->assertRedirect('/vendor');
});

test('only customers see the become a seller action', function () {
    $user = User::factory()->create(['role' => 'user']);
    $vendor = User::factory()->create(['role' => 'vendor']);

    $this->actingAs($user)
        ->get('/user')
        ->assertSee('Become a Seller');

    $this->actingAs($vendor)
        ->get('/vendor')
        ->assertDontSee('Become a Seller');
});

test('customer dashboards use the persisted profile image', function () {
    Storage::fake('public');
    Storage::disk('public')->put('avatars/avatar.jpg', 'avatar');
    $user = User::factory()->create([
        'role' => 'user',
        'image' => 'avatars/avatar.jpg',
    ]);

    $this->actingAs($user)
        ->get('/user')
        ->assertSee(Storage::disk('public')->url('avatars/avatar.jpg'));
});