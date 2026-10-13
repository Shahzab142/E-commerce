<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.app')] class extends Component {
    public string $appearance = 'system';
}; ?>

<section class="w-100">
    @include('partials.settings-heading')

    <x-settings.layout heading="Appearance" subheading="Update your account's appearance settings">
        <div class="mb-4">
            <p class="small fw-medium text-uppercase text-muted mb-2">Theme</p>

            <div class="btn-group" role="group">
                <input type="radio" class="btn-check" wire:model="appearance"
                    id="appearance_light" value="light" autocomplete="off">
                <label class="btn btn-outline-secondary" for="appearance_light">
                    <i class="bi bi-sun fs-5 mb-1"></i>
                    Light
                </label>

                <input type="radio" class="btn-check" wire:model="appearance"
                    id="appearance_dark" value="dark" autocomplete="off">
                <label class="btn btn-outline-secondary" for="appearance_dark">
                    <i class="bi bi-moon fs-5 mb-1"></i>
                    Dark
                </label>

                <input type="radio" class="btn-check" wire:model="appearance"
                    id="appearance_system" value="system" autocomplete="off">
                <label class="btn btn-outline-secondary" for="appearance_system">
                    <i class="bi bi-gear-wide fs-5 mb-1"></i>
                    System
                </label>
            </div>

            <p class="text-muted small mt-2 mb-0">
                Choose your preferred theme. System will follow your device's preference.
            </p>
        </div>
    </x-settings.layout>
</section>
