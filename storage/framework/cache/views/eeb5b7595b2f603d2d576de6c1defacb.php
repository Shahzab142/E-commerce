

<?php $__env->startPush('title'); ?>
    <title>Edit Category</title>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div id="layoutSidenav_content">

        <main>

            <div class="container-fluid px-4 py-4">

                

                <div class="d-flex justify-content-between align-items-start flex-wrap mb-4">

                    <div>

                        <h2 class="fw-bold mb-1">

                            <i class="bi bi-pencil-square me-2 text-primary"></i>

                            Edit Category

                        </h2>

                        <p class="text-muted mb-0">

                            Update the details below and save your changes.

                        </p>

                    </div>


                    

                    <div class="mt-3 mt-md-0 d-flex gap-2">

                        

                        <a href="<?php echo e(route('admin.categories.view')); ?>" class="btn btn-outline-secondary">

                            <i class="bi bi-arrow-left me-1"></i>

                            Back to List

                        </a>


                        

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($category->slug): ?>
                            <a href="<?php echo e(url('/category/' . $category->slug)); ?>" target="_blank"
                                class="btn btn-outline-secondary">

                                <i class="bi bi-eye me-1"></i>

                                Preview

                            </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


                        

                        <button type="submit" form="category-form" class="btn btn-primary">

                            <i class="bi bi-check-circle me-1"></i>

                            Update Category

                        </button>

                    </div>

                </div>



                

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">

                        <strong>
                            Please fix the following:
                        </strong>

                        <ul class="mb-0 mt-1">

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <li>
                                    <?php echo e($error); ?>

                                </li>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                        </ul>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>



                

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">

                        <i class="bi bi-check-circle me-1"></i>

                        <?php echo e(session('success')); ?>


                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>



                

                <form id="category-form" action="<?php echo e(route('admin.categories.update', $category->id)); ?>" method="POST" enctype="multipart/form-data">

                    <?php echo csrf_field(); ?>

                    <?php echo method_field('PUT'); ?>


                    <div class="card shadow-sm border-0">


                        

                        <div class="card-header bg-white">

                            <h5 class="fw-bold mb-0">

                                <i class="bi bi-info-circle me-1 text-primary"></i>

                                Category Details

                            </h5>

                        </div>



                        

                        <div class="table-responsive">

                            <table class="table align-middle mb-0">

                                <tbody>


                                    

                                    <tr>

                                        <th class="fw-semibold text-nowrap" style="width: 220px;">

                                            Category Name

                                            <span class="text-danger">
                                                *
                                            </span>

                                        </th>


                                        <td>

                                            <input type="text" id="name" name="name"
                                                value="<?php echo e(old('name', $category->name)); ?>"
                                                class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>


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

                                        </td>

                                    </tr>



                                    

                                    <tr>

                                        <th class="fw-semibold text-nowrap">

                                            Slug

                                        </th>


                                        <td>

                                            <div class="input-group">

                                                <span class="input-group-text bg-light text-muted">

                                                    /category/

                                                </span>


                                                <input type="text" id="slug" name="slug"
                                                    value="<?php echo e(old('slug', $category->slug)); ?>"
                                                    class="form-control <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

                                            </div>


                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="text-danger small mt-1">

                                                    <?php echo e($message); ?>


                                                </div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


                                            <div class="form-text">

                                                Changing the slug will change this category's URL.

                                            </div>

                                        </td>

                                    </tr>



                                    

                                    <tr>

                                        <th class="fw-semibold text-nowrap">

                                            Short Description

                                        </th>


                                        <td>

                                            <textarea id="short_description" name="short_description"
                                                class="form-control <?php $__errorArgs = ['short_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="3" maxlength="160"><?php echo e(old('short_description', $category->short_description)); ?></textarea>


                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['short_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="text-danger small mt-1">

                                                    <?php echo e($message); ?>


                                                </div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


                                            <div class="form-text">

                                                Recommended: up to 160 characters.

                                            </div>

                                        </td>

                                    </tr>



                                    

                                    <tr>

                                        <th class="fw-semibold text-nowrap">

                                            Full Description

                                        </th>


                                        <td>

                                            <textarea id="description" name="description" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                rows="8"><?php echo e(old('description', $category->description)); ?></textarea>


                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="text-danger small mt-1">

                                                    <?php echo e($message); ?>


                                                </div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                        </td>

                                    </tr>



                                    

                                    <tr>

                                        <th class="fw-semibold text-nowrap">

                                            Status

                                        </th>


                                        <td>

                                            <select id="status" name="status"
                                                class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">


                                                <option value="published"
                                                    <?php echo e(old('status', $category->status) == 'published' ? 'selected' : ''); ?>>

                                                    Published

                                                </option>


                                                <option value="draft"
                                                    <?php echo e(old('status', $category->status) == 'draft' ? 'selected' : ''); ?>>

                                                    Draft

                                                </option>


                                                <option value="hidden"
                                                    <?php echo e(old('status', $category->status) == 'hidden' ? 'selected' : ''); ?>>

                                                    Hidden

                                                </option>


                                            </select>


                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="text-danger small mt-1">

                                                    <?php echo e($message); ?>


                                                </div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


                                            <div class="form-text">

                                                Draft or hidden categories aren't shown to customers.

                                            </div>

                                        </td>

                                    </tr>



                                    

                                    <tr>

                                        <th class="fw-semibold text-nowrap">

                                            Show on Homepage

                                        </th>


                                        <td>

                                            <div class="form-check form-switch mb-0">


                                                <input class="form-check-input" type="checkbox" id="show_on_homepage"
                                                    name="show_on_homepage" value="1"
                                                    <?php echo e(old('show_on_homepage', $category->show_on_homepage) ? 'checked' : ''); ?>>


                                                <label class="form-check-label" for="show_on_homepage">

                                                    Feature this category on the homepage

                                                </label>


                                            </div>

                                        </td>

                                    </tr>


                                    

                                    <tr>

                                        <th class="fw-semibold text-nowrap">

                                            Category Image

                                        </th>


                                        <td>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($category->image): ?>
                                                <img src="<?php echo e(asset('storage/' . $category->image)); ?>" alt="<?php echo e($category->name); ?>"
                                                    class="rounded border mb-2"
                                                    style="width: 80px; height: 80px; object-fit: cover;">
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                            <input type="file" id="image" name="image"
                                                class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml">

                                            <div class="form-text">
                                                Upload a cover image for this category. Leave empty to keep the current image.
                                            </div>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="text-danger small mt-1">

                                                    <?php echo e($message); ?>


                                                </div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                        </td>

                                    </tr>


                                </tbody>

                            </table>

                        </div>



                        

                        <div class="card-footer bg-white d-flex justify-content-end gap-2">


                            

                            <button type="button" id="resetChanges" class="btn btn-outline-secondary">

                                <i class="bi bi-arrow-counterclockwise me-1"></i>

                                Reset Changes

                            </button>


                            

                            <button type="submit" class="btn btn-primary">

                                <i class="bi bi-cloud-upload me-2"></i>

                                Update Category

                            </button>


                        </div>


                    </div>

                </form>

            </div>

        </main>


    <?php $__env->stopSection(); ?>


    <?php $__env->startPush('scripts'); ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                /*
                |--------------------------------------------------------------------------
                | Reset Changes
                |--------------------------------------------------------------------------
                */

                const resetButton = document.getElementById('resetChanges');
                const categoryForm = document.getElementById('category-form');

                if (resetButton && categoryForm) {

                    resetButton.addEventListener('click', function(event) {

                        event.preventDefault();

                        const confirmReset = confirm(
                            'Are you sure you want to discard all your changes?'
                        );

                        if (confirmReset) {

                            categoryForm.reset();

                            // Reset slug manual editing state
                            slugManuallyEdited = false;

                        }

                    });

                }


                /*
                |--------------------------------------------------------------------------
                | Auto Generate Slug
                |--------------------------------------------------------------------------
                */

                const nameInput = document.getElementById('name');
                const slugInput = document.getElementById('slug');

                let slugManuallyEdited = false;


                if (nameInput && slugInput) {

                    slugInput.addEventListener('input', function() {

                        slugManuallyEdited = true;

                    });


                    nameInput.addEventListener('input', function() {

                        if (!slugManuallyEdited) {

                            let slug = this.value
                                .toLowerCase()
                                .trim()
                                .replace(/[^a-z0-9\s-]/g, '')
                                .replace(/\s+/g, '-')
                                .replace(/-+/g, '-');

                            slugInput.value = slug;

                        }

                    });

                }

            });
        </script>
    <?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\admin\edit-category.blade.php ENDPATH**/ ?>