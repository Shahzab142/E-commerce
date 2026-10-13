<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['product']));

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

foreach (array_filter((['product']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="product-share">
    <button class="btn btn-sm btn-outline-secondary" onclick="toggleShareMenu(this)" title="Share this product">
        <i class="bi bi-share"></i>
    </button>
    <div class="share-menu">
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e(urlencode(route('product.detail', $product->id))); ?>" target="_blank" class="share-link" title="Share on Facebook">
            <i class="bi bi-facebook text-primary"></i>
        </a>
        <a href="https://twitter.com/intent/tweet?url=<?php echo e(urlencode(route('product.detail', $product->id))); ?>&text=<?php echo e(urlencode($product->name)); ?>" target="_blank" class="share-link" title="Share on Twitter">
            <i class="bi bi-twitter text-info"></i>
        </a>
        <a href="https://wa.me/?text=<?php echo e(urlencode($product->name . ' ' . route('product.detail', $product->id))); ?>" target="_blank" class="share-link" title="Share on WhatsApp">
            <i class="bi bi-whatsapp text-success"></i>
        </a>
        <a href="https://www.pinterest.com/pin/create/button/?url=<?php echo e(urlencode(route('product.detail', $product->id))); ?>&media=<?php echo e(urlencode($product->images->first() ? asset('storage/' . $product->images->first()->image) : '')); ?>&description=<?php echo e(urlencode($product->name)); ?>" target="_blank" class="share-link" title="Share on Pinterest">
            <i class="bi bi-pinterest text-danger"></i>
        </a>
        <button class="share-link" onclick="copyProductLink('<?php echo e(route('product.detail', $product->id)); ?>')" title="Copy Link">
            <i class="bi bi-link-45deg"></i>
        </button>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
    .product-share {
        position: relative;
        display: inline-block;
    }
    .share-menu {
        position: absolute;
        top: 100%;
        right: 0;
        display: none;
        gap: 0.5rem;
        padding: 0.5rem;
        background: #fff;
        border-radius: 50px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        z-index: 100;
        animation: slideDown 0.2s ease;
    }
    .share-menu.show {
        display: flex;
    }
    .share-link {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: none;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 1.1rem;
        transition: transform 0.15s ease, background 0.15s ease;
    }
    .share-link:hover {
        transform: scale(1.1);
        background: #e9ecef;
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function toggleShareMenu(btn) {
        const menu = btn.nextElementSibling;
        menu.classList.toggle('show');
        
        // Close when clicking outside
        document.addEventListener('click', function closeMenu(e) {
            if (!btn.parentElement.contains(e.target)) {
                menu.classList.remove('show');
                document.removeEventListener('click', closeMenu);
            }
        });
    }
    
    function copyProductLink(url) {
        navigator.clipboard.writeText(url).then(() => {
            alert('Link copied to clipboard!');
        });
    }
</script>
<?php $__env->stopPush(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\components\product-share.blade.php ENDPATH**/ ?>