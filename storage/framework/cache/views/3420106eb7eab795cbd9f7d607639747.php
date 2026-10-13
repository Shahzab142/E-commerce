<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'expandable' => false,
    'expanded' => true,
    'heading' => null,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'expandable' => false,
    'expanded' => true,
    'heading' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php if ($expandable && $heading): ?>

<ui-disclosure
    <?php echo e($attributes->class('group/disclosure')); ?>

    <?php if($expanded === true): ?> open <?php endif; ?>
    data-flux-navlist-group
>
    <button
        type="button"
        class="group/disclosure-button mb-[2px] flex h-10 w-full items-center rounded-lg text-zinc-500 hover:bg-zinc-800/5 hover:text-zinc-800 lg:h-8 dark:text-white/80 dark:hover:bg-white/[7%] dark:hover:text-white"
    >
        <div class="pl-3 pr-4">
            <flux:icon.chevron-down class="hidden size-3! group-data-open/disclosure-button:block" />
            <flux:icon.chevron-right class="block size-3! group-data-open/disclosure-button:hidden" />
        </div>

        <span class="text-sm font-medium leading-none"><?php echo e($heading); ?></span>
    </button>

    <div class="relative hidden space-y-[2px] pl-7 data-open:block" <?php if($expanded === true): ?> data-open <?php endif; ?>>
        <div class="absolute inset-y-[3px] left-0 ml-4 w-px bg-zinc-200 dark:bg-white/30"></div>

        <?php echo e($slot); ?>

    </div>
</ui-disclosure>

<?php elseif ($heading): ?>

<div <?php echo e($attributes->class('block space-y-[2px]')); ?>>
    <div class="px-1 py-2">
        <div class="text-xs leading-none text-zinc-400"><?php echo e($heading); ?></div>
    </div>

    <div>
        <?php echo e($slot); ?>

    </div>
</div>

<?php else: ?>

<div <?php echo e($attributes->class('block space-y-[2px]')); ?>>
    <?php echo e($slot); ?>

</div>

<?php endif; ?>
<?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\flux\navlist\group.blade.php ENDPATH**/ ?>