<?php

use App\Models\User;
use App\Services\VerificationCodeService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

?>

<div class="card-body p-0">
<style>
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
        border-radius: 0;
    }
    .material-input:focus {
        border-bottom: 2px solid #4f46e5;
        box-shadow: none;
    }
    .material-label {
        font-size: 0.85rem;
        color: #888;
        margin-bottom: 5px;
        display: block;
        font-weight: 500;
    }
    .btn-khybar {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: white;
        border: none;
        border-radius: 50px;
        padding: 15px;
        width: 100%;
        font-weight: 700;
        font-size: 1rem;
        letter-spacing: 1px;
        margin-top: 10px;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .btn-khybar:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
        color: white;
    }
    .register-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }
    .register-header h2 {
        font-weight: 800;
        color: #212529;
    }
</style>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('status')): ?>
        <?php if (isset($component)) { $__componentOriginal6da4f549a5e837ad34d208a4725c54bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6da4f549a5e837ad34d208a4725c54bb = $attributes; } ?>
<?php $component = App\View\Components\AuthSessionStatus::resolve(['status' => session('status')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth-session-status'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AuthSessionStatus::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mb-3']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6da4f549a5e837ad34d208a4725c54bb)): ?>
<?php $attributes = $__attributesOriginal6da4f549a5e837ad34d208a4725c54bb; ?>
<?php unset($__attributesOriginal6da4f549a5e837ad34d208a4725c54bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6da4f549a5e837ad34d208a4725c54bb)): ?>
<?php $component = $__componentOriginal6da4f549a5e837ad34d208a4725c54bb; ?>
<?php unset($__componentOriginal6da4f549a5e837ad34d208a4725c54bb); ?>
<?php endif; ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="p-4 p-md-5">
        <div class="register-header">
            <h2>Create Your Account</h2>
            <p class="text-muted">Join us and start shopping today.</p>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Please check the form below for errors.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <form wire:submit.prevent="register" novalidate>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="name" class="material-label">Full Name</label>
                    <input wire:model="name" id="name" type="text" required autofocus autocomplete="name" placeholder="John Doe" class="material-input">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                
                <div class="col-md-6 mb-4">
                    <label for="email" class="material-label">Email Address</label>
                    <input wire:model="email" id="email" type="email" required autocomplete="email" placeholder="you@example.com" class="material-input">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="phone" class="material-label">Phone Number (Optional)</label>
                    <input wire:model="phone" id="phone" type="tel" autocomplete="tel" placeholder="+92 300 1234567" class="material-input">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="material-label">Captcha: <?php echo e($captcha['question'] ?? 'Loading...'); ?></label>
                    <div class="d-flex position-relative">
                        <input wire:model="captcha_answer" type="text" class="material-input pe-5" placeholder="Enter answer" required>
                        <button type="button" wire:click="refreshCaptcha" class="position-absolute top-50 end-0 translate-middle-y border-0 bg-transparent text-primary" style="padding-right: 10px;">
                            <i class="bi bi-arrow-clockwise fs-5"></i>
                        </button>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['captcha_answer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="password" class="material-label">Password</label>
                    <div class="position-relative">
                        <input wire:model="password" id="password" type="password" required autocomplete="new-password" placeholder="Create a password" class="material-input pe-5">
                        <button type="button" onclick="togglePassword('password', this)" class="position-absolute top-50 end-0 translate-middle-y me-2 p-0 border-0 bg-transparent text-muted">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="col-md-6 mb-4">
                    <label for="password_confirmation" class="material-label">Confirm Password</label>
                    <div class="position-relative">
                        <input wire:model="password_confirmation" id="password_confirmation" type="password" required autocomplete="new-password" placeholder="Confirm your password" class="material-input pe-5">
                        <button type="button" onclick="togglePassword('password_confirmation', this)" class="position-absolute top-50 end-0 translate-middle-y me-2 p-0 border-0 bg-transparent text-muted">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
            </div>

            <button type="submit" wire:loading.attr="disabled" class="btn-khybar">
                <span wire:loading.remove>REGISTER SECURELY</span>
                <span wire:loading>
                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                    CREATING ACCOUNT...
                </span>
            </button>
        </form>

        <div class="text-center mt-4 pt-4 border-top">
            <p class="text-muted mb-0">
                Already have an account?
                <a href="<?php echo e(route('login')); ?>" wire:navigate class="fw-bold" style="color: #4f46e5; text-decoration: none;">
                    Sign in here
                </a>
            </p>
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
    </script>
</div><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\livewire\auth\register.blade.php ENDPATH**/ ?>