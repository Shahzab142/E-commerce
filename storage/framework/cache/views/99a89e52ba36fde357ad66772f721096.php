<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

?>

<section class="w-100">
    <?php echo $__env->make('partials.settings-heading', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php if (isset($component)) { $__componentOriginal951a5936e8413b65cd052beecc1fba57 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal951a5936e8413b65cd052beecc1fba57 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.settings.layout','data' => ['heading' => 'Appearance','subheading' => 'Update your account\'s appearance settings']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('settings.layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['heading' => 'Appearance','subheading' => 'Update your account\'s appearance settings']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

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
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal951a5936e8413b65cd052beecc1fba57)): ?>
<?php $attributes = $__attributesOriginal951a5936e8413b65cd052beecc1fba57; ?>
<?php unset($__attributesOriginal951a5936e8413b65cd052beecc1fba57); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal951a5936e8413b65cd052beecc1fba57)): ?>
<?php $component = $__componentOriginal951a5936e8413b65cd052beecc1fba57; ?>
<?php unset($__componentOriginal951a5936e8413b65cd052beecc1fba57); ?>
<?php endif; ?>
</section><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\livewire\settings\appearance.blade.php ENDPATH**/ ?>