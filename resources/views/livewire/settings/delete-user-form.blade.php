<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public string $password = '';

    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="mt-10 pt-4 border-top">
    <h2 class="h5 fw-bold mb-1">Delete Account</h2>
    <p class="text-muted small mb-3">Delete your account and all of its resources</p>

    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
        data-bs-target="#confirm-user-deletion">
        Delete Account
    </button>

    <div class="modal fade" id="confirm-user-deletion" tabindex="-1"
        aria-labelledby="confirm-user-deletion-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit="deleteUser">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirm-user-deletion-label">
                            Are you sure you want to delete your account?
                        </h5>
                        <button type="button" class="btn-close"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="small text-muted">
                            Once your account is deleted, all of its resources and data
                            will be permanently deleted. Please enter your password to
                            confirm you would like to permanently delete your account.
                        </p>
                        <div class="mb-3">
                            <label for="password" class="form-label fw-medium">Password</label>
                            <input
                                wire:model="password"
                                id="password"
                                type="password"
                                name="password"
                                required
                                class="form-control"
                            >
                            @error('password')
                                <div class="invalid-feedback d-block text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" wire:loading.attr="disabled"
                            class="btn btn-danger">
                            <span wire:loading.remove>Delete Account</span>
                            <span wire:loading>
                                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                Deleting...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
