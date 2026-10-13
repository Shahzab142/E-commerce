<?php if (isset($component)) { $__componentOriginald275691d15a0a68ca98ac956f9920812 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald275691d15a0a68ca98ac956f9920812 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app.sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app.sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <div class="container-fluid py-4 px-3 px-md-4">
        <?php echo e($slot); ?>

    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald275691d15a0a68ca98ac956f9920812)): ?>
<?php $attributes = $__attributesOriginald275691d15a0a68ca98ac956f9920812; ?>
<?php unset($__attributesOriginald275691d15a0a68ca98ac956f9920812); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald275691d15a0a68ca98ac956f9920812)): ?>
<?php $component = $__componentOriginald275691d15a0a68ca98ac956f9920812; ?>
<?php unset($__componentOriginald275691d15a0a68ca98ac956f9920812); ?>
<?php endif; ?>
<?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\components\layouts\app.blade.php ENDPATH**/ ?>