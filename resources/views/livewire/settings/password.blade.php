<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.app')] class extends Component {
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section class="w-100">
    @include('partials.settings-heading')

    <x-settings.layout heading="Update password" subheading="Ensure your account is using a long, random password to stay secure">
        <form wire:submit="updatePassword">
            <div class="mb-3">
                <label for="current_password" class="form-label fw-medium">Current Password</label>
                <input
                    wire:model="current_password"
                    id="current_password"
                    type="password"
                    name="current_password"
                    required
                    autocomplete="current-password"
                    class="form-control"
                >
                @error('current_password')
                    <div class="invalid-feedback d-block text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-medium">New Password</label>
                <input
                    wire:model="password"
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    class="form-control"
                >
                @error('password')
                    <div class="invalid-feedback d-block text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label fw-medium">Confirm Password</label>
                <input
                    wire:model="password_confirmation"
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    class="form-control"
                >
                @error('password_confirmation')
                    <div class="invalid-feedback d-block text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex align-items-center gap-3">
                <button type="submit" wire:loading.attr="disabled"
                    class="btn btn-primary">
                    <span wire:loading.remove>Save</span>
                    <span wire:loading>
                        <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                        Saving...
                    </span>
                </button>

                <x-action-message class="small" on="password-updated">
                    Saved.
                </x-action-message>
            </div>
        </form>
    </x-settings.layout>
</section>
