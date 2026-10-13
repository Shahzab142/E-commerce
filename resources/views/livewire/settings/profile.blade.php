<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Livewire\Volt\Component;

new #[Layout('components.layouts.app')] class extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public $image = null;

    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if ($this->image) {
            $path = $this->image->store('avatars', 'public');
            $user->image = $path;
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard'));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section class="w-100">
    @include('partials.settings-heading')

    <x-settings.layout heading="Profile" subheading="Update your name and email address">
        <form wire:submit="updateProfileInformation">
            <div class="mb-3">
                <label for="name" class="form-label fw-medium">Name</label>
                <input
                    wire:model="name"
                    id="name"
                    type="text"
                    name="name"
                    required
                    autofocus
                    autocomplete="name"
                    class="form-control"
                >
                @error('name')
                    <div class="invalid-feedback d-block text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-medium">Email</label>
                <input
                    wire:model="email"
                    id="email"
                    type="email"
                    name="email"
                    required
                    autocomplete="email"
                    class="form-control"
                >
                @error('email')
                    <div class="invalid-feedback d-block text-danger small mt-1">{{ $message }}</div>
                @enderror

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                    <div class="mt-2">
                        <p class="text-sm text-muted">
                            Your email address is unverified.
                            <button wire:click.prevent="resendVerificationNotification"
                                class="btn btn-link btn-sm p-0 text-decoration-underline">
                                Click here to re-send the verification email.
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 text-sm text-success fw-medium">
                                A new verification link has been sent to your email address.
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="mb-3">
                <label for="image" class="form-label fw-medium">Profile Image</label>
                <input
                    wire:model="image"
                    id="image"
                    type="file"
                    accept="image/*"
                    class="form-control"
                >
                @error('image')
                    <div class="invalid-feedback d-block text-danger small mt-1">{{ $message }}</div>
                @enderror

                @if (auth()->user()->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . auth()->user()->image) }}" alt="Profile" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                    </div>
                @endif
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

                <x-action-message class="small" on="profile-updated">
                    Saved.
                </x-action-message>
            </div>
        </form>

        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>
