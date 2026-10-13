

<?php $__env->startSection('title', 'Add Category'); ?>

<?php $__env->startSection('content'); ?>

    <div id="layoutSidenav_content">

        <main>
            <div class="container-fluid px-4 py-4">

                
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-4">

                    <div>
                        <h2 class="fw-bold mb-1">
                            <i class="bi bi-tags-fill me-2 text-primary"></i>
                            Add New Category
                        </h2>

                        <p class="text-muted mb-0">
                            Create a category to organize your products in the store.
                        </p>
                    </div>

                    <div class="mt-3 mt-md-0 d-flex gap-2">

                        
                        <button type="submit" form="category-form" name="status" value="draft"
                            class="btn btn-outline-secondary">

                            <i class="bi bi-file-earmark me-1"></i>
                            Save as Draft

                        </button>

                        
                        <button type="submit" form="category-form" name="status" value="published"
                            class="btn btn-primary">

                            <i class="bi bi-check-circle me-1"></i>
                            Publish Category

                        </button>

                    </div>

                </div>


                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>

                    <div class="alert alert-danger">

                        <strong>Please fix the following:</strong>

                        <ul class="mb-0 mt-1">

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <li><?php echo e($error); ?></li>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                        </ul>

                    </div>

                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show">

                        <i class="bi bi-check-circle me-2"></i>

                        <?php echo e(session('success')); ?>


                        <button type="button" class="btn-close" data-bs-dismiss="alert">
                        </button>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


                
                <form id="category-form" action="<?php echo e(url('admin/add-category')); ?>" method="POST"
                    enctype="multipart/form-data">

                    <?php echo csrf_field(); ?>


                    <div class="row g-4">


                        
                        
                        
                        <div class="col-lg-8">


                            
                            <div class="card shadow-sm border-0 mb-4">

                                <div class="card-header bg-white d-flex align-items-center">

                                    <i class="bi bi-info-circle text-primary me-2"></i>

                                    <h5 class="fw-bold mb-0">
                                        Category Information
                                    </h5>

                                </div>


                                <div class="card-body">


                                    
                                    <div class="mb-3">

                                        <label for="name" class="form-label fw-semibold">

                                            Category Name
                                            <span class="text-danger">*</span>

                                        </label>


                                        <input type="text" id="name" name="name" value="<?php echo e(old('name')); ?>"
                                            class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            placeholder="e.g. Men's Footwear" required>


                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback">
                                                <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


                                        <div class="form-text">
                                            This is how the category will appear to customers.
                                        </div>

                                    </div>


                                    
                                    <div class="mb-3">

                                        <label for="slug" class="form-label fw-semibold">

                                            Slug

                                        </label>


                                        <div class="input-group">

                                            <span class="input-group-text bg-light text-muted">
                                                /category/
                                            </span>


                                            <input type="text" id="slug" name="slug" value="<?php echo e(old('slug')); ?>"
                                                class="form-control <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                placeholder="mens-footwear">


                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback">
                                                    <?php echo e($message); ?>

                                                </div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                        </div>


                                        <div class="form-text">
                                            Auto-generated from the category name.
                                            You can edit it if needed.
                                        </div>

                                    </div>


                                    
                                    <div class="mb-3">

                                        <label for="short_description" class="form-label fw-semibold">

                                            Short Description

                                        </label>


                                        <textarea id="short_description" name="short_description"
                                            class="form-control <?php $__errorArgs = ['short_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="2" maxlength="160"
                                            placeholder="A one-line summary shown in category listings"><?php echo e(old('short_description')); ?></textarea>


                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['short_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback">
                                                <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


                                        <div class="form-text">
                                            Recommended: up to 160 characters.
                                        </div>

                                    </div>


                                    
                                    <div class="mb-0">

                                        <label for="description" class="form-label fw-semibold">

                                            Full Description

                                        </label>


                                        <textarea id="description" name="description" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            rows="7" placeholder="Describe what belongs in this category"><?php echo e(old('description')); ?></textarea>


                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback">
                                                <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    </div>

                                    
                                    <div class="mb-0 mt-3">

                                        <label for="image" class="form-label fw-semibold">

                                            Category Image

                                        </label>


                                        <input type="file" id="image" name="image" class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml">


                                        <div class="form-text">
                                            Upload a cover image for this category.
                                        </div>


                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback">
                                                <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    </div>

                                </div>

                            </div>


                        </div>


                        
                        
                        
                        <div class="col-lg-4">


                            
                            <div class="card shadow-sm border-0 mb-4">

                                <div class="card-header bg-white d-flex align-items-center">

                                    <i class="bi bi-eye text-primary me-2"></i>

                                    <h5 class="fw-bold mb-0">
                                        Visibility
                                    </h5>

                                </div>


                                <div class="card-body">


                                    
                                    <div class="mb-3">

                                        <label for="status" class="form-label fw-semibold">

                                            Status

                                        </label>


                                        <select id="status" name="status"
                                            class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

                                            <option value="published" <?php echo e(old('status') == 'published' ? 'selected' : ''); ?>>
                                                Published
                                            </option>

                                            <option value="draft"
                                                <?php echo e(old('status', 'draft') == 'draft' ? 'selected' : ''); ?>>
                                                Draft
                                            </option>

                                            <option value="hidden" <?php echo e(old('status') == 'hidden' ? 'selected' : ''); ?>>
                                                Hidden
                                            </option>

                                        </select>


                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback">
                                                <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


                                        <div class="form-text">
                                            Draft categories aren't shown to customers.
                                        </div>

                                    </div>


                                    
                                    <div class="form-check form-switch mb-0">

                                        <input class="form-check-input" type="checkbox" id="show_on_homepage"
                                            name="show_on_homepage" value="1"
                                            <?php echo e(old('show_on_homepage') ? 'checked' : ''); ?>>


                                        <label class="form-check-label fw-semibold" for="show_on_homepage">

                                            Show on homepage

                                        </label>

                                    </div>


                                </div>

                            </div>


                        </div>

                    </div>

                </form>

            </div>
        </main>



    <?php $__env->stopSection(); ?>


    
    <?php $__env->startPush('scripts'); ?>
        <script>
            // =========================================================
            // AUTO GENERATE SLUG FROM CATEGORY NAME
            // =========================================================

            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');

            let slugEdited = false;


            // If user manually edits slug,
            // stop automatic slug generation.
            slugInput.addEventListener('input', function() {

                slugEdited = true;

            });


            // Generate slug automatically from category name.
            nameInput.addEventListener('input', function() {

                if (!slugEdited) {

                    slugInput.value = nameInput.value
                        .toLowerCase()
                        .trim()
                        .replace(/[^a-z0-9]+/g, '-')
                        .replace(/(^-|-$)/g, '');

                }

            });
        </script>
    <?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\admin\add-category.blade.php ENDPATH**/ ?>