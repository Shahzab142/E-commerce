<?php

use App\Models\User;
use App\Services\VerificationCodeService;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

?>

<div>
<style>
    .material-group {
        margin-bottom: 30px;
    }
    .material-label {
        font-size: 0.85rem;
        color: #888;
        margin-bottom: 5px;
        display: block;
    }
    .material-input {
        width: 100%;
        border: none;
        border-bottom: 1px solid #ccc;
        padding: 8px 0;
        font-size: 1rem;
        color: #333;
        background: transparent;
        outline: none;
        transition: border-color 0.2s;
    }
    .material-input:focus {
        border-bottom: 2px solid #5cb85c;
    }
    .btn-khybar {
        background-color: #5cb85c;
        color: white;
        border: none;
        border-radius: 50px;
        padding: 15px;
        width: 100%;
        font-weight: 700;
        font-size: 1rem;
        letter-spacing: 1px;
        margin-top: 20px;
        box-shadow: 0 4px 10px rgba(92, 184, 92, 0.3);
        transition: background-color 0.2s;
    }
    .btn-khybar:hover {
        background-color: #4cae4c;
        color: white;
    }
    .btn-khybar-outline {
        display: inline-block;
        background-color: transparent;
        color: #4f46e5;
        border: 2px solid #4f46e5;
        border-radius: 50px;
        padding: 12px 25px;
        width: 100%;
        font-weight: 700;
        font-size: 1rem;
        letter-spacing: 1px;
        text-align: center;
        text-decoration: none;
        transition: all 0.2s ease-in-out;
    }
    .btn-khybar-outline:hover {
        background-color: #4f46e5;
        color: white;
    }
</style>
<div style="max-width: 450px; margin: 0 auto; padding: 2rem 1rem;">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('status')): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?php echo e(session('status')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
        <div class="alert alert-warning alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <form wire:submit="login" novalidate>
        
        <div class="material-group">
            <label class="material-label" for="email">Email</label>
            <input wire:model="email" id="email" type="email" class="material-input" required autofocus autocomplete="email">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="text-danger small mt-1"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="material-group">
            <label class="material-label" for="password">Password</label>
            <input wire:model="password" id="password" type="password" class="material-input" required autocomplete="current-password" style="border-bottom: 2px solid #5cb85c;">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="text-danger small mt-1"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <button type="submit" wire:loading.attr="disabled" class="btn-khybar">
            <span wire:loading.remove>LOGIN</span>
            <span wire:loading>
                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                LOGGING IN...
            </span>
        </button>

        <div class="mt-4 text-center">
            <p style="color: #888; margin-bottom: 15px;">Don't have an account?</p>
            <a href="<?php echo e(route('register')); ?>" class="btn-khybar-outline">CREATE NEW ACCOUNT</a>
        </div>
    </form>
</div>
</div>

<script>
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        if (!input) return;
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }
</script><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\livewire\auth\login.blade.php ENDPATH**/ ?>