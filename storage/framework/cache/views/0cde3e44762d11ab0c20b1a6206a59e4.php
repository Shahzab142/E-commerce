<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $__env->yieldContent('meta_description', 'Discover quality products and trusted sellers at ' . config('app.name', 'E-Commerce') . '.'); ?>">
    <meta name="robots" content="<?php echo $__env->yieldContent('robots', 'index, follow'); ?>">
    <link rel="canonical" href="<?php echo $__env->yieldContent('canonical', url()->current()); ?>">
    <meta property="og:title" content="<?php echo $__env->yieldContent('og_title', config('app.name', 'E-Commerce')); ?>">
    <meta property="og:description" content="<?php echo $__env->yieldContent('meta_description', 'Discover quality products and trusted sellers at ' . config('app.name', 'E-Commerce') . '.'); ?>">
    <meta property="og:url" content="<?php echo e(url()->current()); ?>">
    <meta property="og:type" content="website">
    <title><?php echo $__env->yieldContent('title', config('app.name', 'E-Commerce')); ?></title>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(is_file(public_path('assets/images/logo.png'))): ?>
        <link rel="icon" type="image/png" href="<?php echo e(asset('assets/images/logo.png')); ?>">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!-- Shop Design System -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/shop.css')); ?>">

    <!-- Home Page Extras -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/home-page.css')); ?>">

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body>

    <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <?php echo $__env->yieldPushContent('scripts'); ?>

    <!-- Back to Top Button -->
    <button id="backToTop" class="back-to-top-btn" title="Back to top">
        <i class="bi bi-arrow-up"></i>
    </button>

    <!-- Search Autocomplete & Dark Mode Script -->
    <script>
        // Dark Mode Toggle
        (function() {
            const darkModeToggle = document.getElementById('darkModeToggle');
            const darkModeIcon = document.getElementById('darkModeIcon');
            const savedTheme = localStorage.getItem('shop-theme') || 'light';
            
            if (savedTheme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
                darkModeIcon?.classList.replace('bi-moon-stars', 'bi-sun');
            }

            darkModeToggle?.addEventListener('click', function() {
                const currentTheme = document.documentElement.getAttribute('data-theme');
                if (currentTheme === 'dark') {
                    document.documentElement.removeAttribute('data-theme');
                    darkModeIcon?.classList.replace('bi-sun', 'bi-moon-stars');
                    localStorage.setItem('shop-theme', 'light');
                } else {
                    document.documentElement.setAttribute('data-theme', 'dark');
                    darkModeIcon?.classList.replace('bi-moon-stars', 'bi-sun');
                    localStorage.setItem('shop-theme', 'dark');
                }
            });
        })();

        // Search Autocomplete
        (function() {
            const searchInput = document.getElementById('searchInput');
            const searchDropdown = document.getElementById('searchDropdown');
            let debounceTimer;

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const query = this.value.trim();
                    clearTimeout(debounceTimer);
                    
                    if (query.length < 2) {
                        searchDropdown?.classList.remove('show');
                        return;
                    }

                    debounceTimer = setTimeout(() => {
                        fetch(`/search/suggest?q=${encodeURIComponent(query)}`)
                            .then(response => response.json())
                            .then(data => {
                                let html = '';
                                
                                if (data.products && data.products.length > 0) {
                                    html += '<div class="search-autocomplete-title">Products</div>';
                                    data.products.forEach(product => {
                                        html += '<a href="' + product.url + '" class="search-autocomplete-item">';
                                        if (product.image) {
                                            html += '<img src="' + product.image + '" alt="' + product.name + '">';
                                        }
                                        html += '<div class="search-autocomplete-info"><div class="search-autocomplete-name">' + product.name + '</div><div class="search-autocomplete-price">' + product.price + '</div></div></a>';
                                    });
                                }

                                if (data.categories && data.categories.length > 0) {
                                    html += '<div class="search-autocomplete-title">Categories</div>';
                                    data.categories.forEach(category => {
                                        html += '<a href="' + category.url + '" class="search-autocomplete-item"><i class="bi bi-tag"></i><div class="search-autocomplete-info"><div class="search-autocomplete-name">' + category.name + '</div></div></a>';
                                    });
                                }

                                if (html) {
                                    const searchProducts = document.getElementById('searchProducts');
                                    if (searchProducts) searchProducts.innerHTML = html;
                                    searchDropdown?.classList.add('show');
                                } else {
                                    searchDropdown?.classList.remove('show');
                                }
                            })
                            .catch(() => searchDropdown?.classList.remove('show'));
                    }, 300);
                });

                searchInput.addEventListener('blur', function() {
                    setTimeout(() => searchDropdown?.classList.remove('show'), 200);
                });

                searchInput.addEventListener('focus', function() {
                    if (this.value.trim().length >= 2) {
                        searchDropdown?.classList.add('show');
                    }
                });
            }
        })();

        // Empty Search Guard — don't leave the page when the search term is blank
        (function() {
            document.querySelectorAll('form').forEach((form) => {
                const q = form.querySelector('input[name="q"]');
                const action = (form.getAttribute('action') || '');
                if (!q || action.indexOf('/search') === -1) return;

                form.addEventListener('submit', (e) => {
                    q.value = q.value.trim();
                    if (q.value !== '') return;

                    e.preventDefault();
                    e.stopPropagation();
                    q.focus();
                    q.classList.remove('is-invalid');
                    void q.offsetWidth; // restart the invalid animation
                    q.classList.add('is-invalid');
                    showToast('Please enter a search term.', 'error');
                });

                // Show a friendly message instead of the browser's generic tooltip
                q.addEventListener('invalid', () => q.setCustomValidity('Please enter a search term.'));
                q.addEventListener('input', () => q.setCustomValidity(''));
            });
        })();

        // Back to Top Button
        (function() {
            const backToTopBtn = document.getElementById('backToTop');
            
            window.addEventListener('scroll', function() {
                if (window.scrollY > 300) {
                    backToTopBtn?.classList.add('show');
                } else {
                    backToTopBtn?.classList.remove('show');
                }
            });

            backToTopBtn?.addEventListener('click', function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        })();

        // Toast Notification System
        function showToast(message, type = 'success') {
            let container = document.getElementById('toastContainer');
            if (!container) {
                container = document.createElement('div');
                container.id = 'toastContainer';
                container.className = 'toast-container';
                document.body.appendChild(container);
            }
            const toast = document.createElement('div');
            toast.className = 'toast-notification ' + type;
            const icon = type === 'success' ? 'bi-check-circle-fill text-success' : 'bi-exclamation-circle-fill text-danger';
            toast.innerHTML = '<i class="bi ' + icon + '"></i><span>' + message + '</span>';
            container.appendChild(toast);
            setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 300); }, 3000);
        }
    </script>

    <!-- WhatsApp Chat Button -->
    <a href="https://wa.me/923462435985" target="_blank" rel="noopener noreferrer" class="whatsapp-float-btn" title="Chat with us on WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

</body>

</html>
<?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\layouts\main.blade.php ENDPATH**/ ?>