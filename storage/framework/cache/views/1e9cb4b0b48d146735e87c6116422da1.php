<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

?>

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
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block text-danger small mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
</section><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\livewire\settings\delete-user-form.blade.php ENDPATH**/ ?>