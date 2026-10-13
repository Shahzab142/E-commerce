@props(['product'])

<div class="product-share">
    <button class="btn btn-sm btn-outline-secondary" onclick="toggleShareMenu(this)" title="Share this product">
        <i class="bi bi-share"></i>
    </button>
    <div class="share-menu">
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('product.detail', $product->id)) }}" target="_blank" class="share-link" title="Share on Facebook">
            <i class="bi bi-facebook text-primary"></i>
        </a>
        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('product.detail', $product->id)) }}&text={{ urlencode($product->name) }}" target="_blank" class="share-link" title="Share on Twitter">
            <i class="bi bi-twitter text-info"></i>
        </a>
        <a href="https://wa.me/?text={{ urlencode($product->name . ' ' . route('product.detail', $product->id)) }}" target="_blank" class="share-link" title="Share on WhatsApp">
            <i class="bi bi-whatsapp text-success"></i>
        </a>
        <a href="https://www.pinterest.com/pin/create/button/?url={{ urlencode(route('product.detail', $product->id)) }}&media={{ urlencode($product->images->first() ? asset('storage/' . $product->images->first()->image) : '') }}&description={{ urlencode($product->name) }}" target="_blank" class="share-link" title="Share on Pinterest">
            <i class="bi bi-pinterest text-danger"></i>
        </a>
        <button class="share-link" onclick="copyProductLink('{{ route('product.detail', $product->id) }}')" title="Copy Link">
            <i class="bi bi-link-45deg"></i>
        </button>
    </div>
</div>

@push('styles')
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
@endpush

@push('scripts')
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
@endpush