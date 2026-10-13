

<?php $__env->startPush('title'); ?>
    <title>Compare Products | <?php echo e(config('app.name', 'Shop Hub')); ?></title>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h1 class="h2 fw-bold"><i class="bi bi-arrow-left-right text-primary me-2"></i>Compare Products</h1>
            <button class="btn btn-outline-danger btn-sm" onclick="clearComparison()" id="clearCompareBtn" style="display: none;">
                <i class="bi bi-x-lg me-1"></i>Clear All
            </button>
        </div>

        <div id="compareContent">
            <div class="text-center py-5" id="emptyCompare">
                <i class="bi bi-arrow-left-right display-1 text-muted"></i>
                <h3 class="h4 mt-4 text-muted">No products to compare</h3>
                <p class="text-muted">Add products to compare their features side by side.</p>
                <a href="<?php echo e(route('shop')); ?>" class="btn btn-primary mt-2">
                    <i class="bi bi-shop me-1"></i>Browse Products
                </a>
            </div>

            <div class="compare-table-wrapper" id="compareTable" style="display: none;">
                <div class="table-responsive">
                    <table class="table table-bordered compare-table">
                        <thead>
                            <tr id="compareHeader">
                                <th style="width: 150px;">Product</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="compareImages"><td class="fw-semibold">Image</td></tr>
                            <tr id="comparePrice"><td class="fw-semibold">Price</td></tr>
                            <tr id="compareRating"><td class="fw-semibold">Rating</td></tr>
                            <tr id="compareCategory"><td class="fw-semibold">Category</td></tr>
                            <tr id="compareVendor"><td class="fw-semibold">Seller</td></tr>
                            <tr id="compareAvailability"><td class="fw-semibold">Availability</td></tr>
                            <tr id="compareDescription"><td class="fw-semibold">Description</td></tr>
                            <tr id="compareActions"><td class="fw-semibold">Actions</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    const MAX_COMPARE = 4;
    const compareKey = 'product_compare';
    document.addEventListener('DOMContentLoaded', loadComparison);

    function loadComparison() {
        const products = JSON.parse(localStorage.getItem(compareKey) || '[]');
        if (products.length === 0) {
            document.getElementById('emptyCompare').style.display = 'block';
            document.getElementById('compareTable').style.display = 'none';
            document.getElementById('clearCompareBtn').style.display = 'none';
            return;
        }
        document.getElementById('emptyCompare').style.display = 'none';
        document.getElementById('compareTable').style.display = 'block';
        document.getElementById('clearCompareBtn').style.display = 'inline-block';
        const promises = products.map(id => fetch('/api/product/' + id + '/quick-view').then(r => r.json()));
        Promise.all(promises).then(productsData => { renderComparisonTable(productsData); });
    }

    function renderComparisonTable(products) {
        const rows = ['compareHeader', 'compareImages', 'comparePrice', 'compareRating', 'compareCategory', 'compareVendor', 'compareAvailability', 'compareDescription', 'compareActions'];
        rows.forEach(id => {
            const row = document.getElementById(id);
            while (row.children.length > 1) row.removeChild(row.lastChild);
        });

        products.forEach(product => {
            document.getElementById('compareHeader').innerHTML += '<th><a href="' + product.url + '" class="text-decoration-none">' + product.name + '</a></th>';
            document.getElementById('compareImages').innerHTML += '<td>' + (product.image ? '<img src="' + product.image + '" style="width:120px;height:120px;object-fit:cover;border-radius:8px;">' : '<i class="bi bi-image text-muted fs-1"></i>') + '</td>';
            document.getElementById('comparePrice').innerHTML += '<td><span class="fw-bold text-danger fs-5">$' + product.price + '</span>' + (product.oldPrice ? '<br><small class="text-decoration-line-through text-muted">$' + product.oldPrice + '</small>' : '') + '</td>';
            document.getElementById('compareRating').innerHTML += '<td>' + (product.rating ? '<span class="text-warning">' + '★'.repeat(Math.floor(product.rating)) + '☆'.repeat(5-Math.floor(product.rating)) + '</span> <small class="text-muted">(' + product.reviewCount + ')</small>' : '<span class="text-muted">No reviews</span>') + '</td>';
            document.getElementById('compareCategory').innerHTML += '<td>' + (product.category || '-') + '</td>';
            document.getElementById('compareVendor').innerHTML += '<td>' + (product.vendor ? '<a href="' + product.vendorUrl + '" class="text-decoration-none">' + product.vendor + '</a>' : '-') + '</td>';
            document.getElementById('compareAvailability').innerHTML += '<td>' + (product.inStock ? '<span class="badge bg-success">In Stock</span>' : '<span class="badge bg-danger">Out of Stock</span>') + '</td>';
            document.getElementById('compareDescription').innerHTML += '<td><small>' + (product.description || '-') + '</small></td>';
            document.getElementById('compareActions').innerHTML += '<td><button class="btn btn-sm btn-outline-danger mb-1" onclick="removeFromCompare(' + product.id + ')"><i class="bi bi-x-lg"></i></button> <a href="' + product.url + '" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i></a></td>';
        });
    }

    function addToCompare(productId) {
        let products = JSON.parse(localStorage.getItem(compareKey) || '[]');
        if (products.includes(productId)) { alert('Product already in comparison!'); return; }
        if (products.length >= MAX_COMPARE) { alert('Max ' + MAX_COMPARE + ' products allowed.'); return; }
        products.push(productId);
        localStorage.setItem(compareKey, JSON.stringify(products));
        updateCompareCount();
        alert('Product added to comparison!');
    }

    function removeFromCompare(productId) {
        let products = JSON.parse(localStorage.getItem(compareKey) || '[]');
        products = products.filter(id => id !== productId);
        localStorage.setItem(compareKey, JSON.stringify(products));
        loadComparison();
        updateCompareCount();
    }

    function clearComparison() {
        localStorage.removeItem(compareKey);
        loadComparison();
        updateCompareCount();
    }

    function updateCompareCount() {
        const products = JSON.parse(localStorage.getItem(compareKey) || '[]');
        const badge = document.getElementById('compareCount');
        if (badge) { badge.textContent = products.length; badge.style.display = products.length > 0 ? 'inline' : 'none'; }
    }
    updateCompareCount();
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\compare.blade.php ENDPATH**/ ?>