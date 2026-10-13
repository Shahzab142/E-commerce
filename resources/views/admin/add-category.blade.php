@extends('admin.layouts.main')

@section('title', 'Add Category')

@section('content')

    <div id="layoutSidenav_content">

        <main>
            <div class="container-fluid px-4 py-4">

                {{-- ==================== HEADER ==================== --}}
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

                        {{-- Save as Draft --}}
                        <button type="submit" form="category-form" name="status" value="draft"
                            class="btn btn-outline-secondary">

                            <i class="bi bi-file-earmark me-1"></i>
                            Save as Draft

                        </button>

                        {{-- Publish Category --}}
                        <button type="submit" form="category-form" name="status" value="published"
                            class="btn btn-primary">

                            <i class="bi bi-check-circle me-1"></i>
                            Publish Category

                        </button>

                    </div>

                </div>


                {{-- ==================== VALIDATION ERRORS ==================== --}}
                @if ($errors->any())

                    <div class="alert alert-danger">

                        <strong>Please fix the following:</strong>

                        <ul class="mb-0 mt-1">

                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach

                        </ul>

                    </div>

                @endif


                {{-- ==================== SUCCESS MESSAGE ==================== --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">

                        <i class="bi bi-check-circle me-2"></i>

                        {{ session('success') }}

                        <button type="button" class="btn-close" data-bs-dismiss="alert">
                        </button>

                    </div>
                @endif


                {{-- ==================== CATEGORY FORM ==================== --}}
                <form id="category-form" action="{{ url('admin/add-category') }}" method="POST"
                    enctype="multipart/form-data">

                    @csrf


                    <div class="row g-4">


                        {{-- ========================================================= --}}
                        {{-- LEFT SIDE --}}
                        {{-- ========================================================= --}}
                        <div class="col-lg-8">


                            {{-- ==================== CATEGORY INFORMATION ==================== --}}
                            <div class="card shadow-sm border-0 mb-4">

                                <div class="card-header bg-white d-flex align-items-center">

                                    <i class="bi bi-info-circle text-primary me-2"></i>

                                    <h5 class="fw-bold mb-0">
                                        Category Information
                                    </h5>

                                </div>


                                <div class="card-body">


                                    {{-- ==================== CATEGORY NAME ==================== --}}
                                    <div class="mb-3">

                                        <label for="name" class="form-label fw-semibold">

                                            Category Name
                                            <span class="text-danger">*</span>

                                        </label>


                                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="e.g. Men's Footwear" required>


                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror


                                        <div class="form-text">
                                            This is how the category will appear to customers.
                                        </div>

                                    </div>


                                    {{-- ==================== SLUG ==================== --}}
                                    <div class="mb-3">

                                        <label for="slug" class="form-label fw-semibold">

                                            Slug

                                        </label>


                                        <div class="input-group">

                                            <span class="input-group-text bg-light text-muted">
                                                /category/
                                            </span>


                                            <input type="text" id="slug" name="slug" value="{{ old('slug') }}"
                                                class="form-control @error('slug') is-invalid @enderror"
                                                placeholder="mens-footwear">


                                            @error('slug')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>


                                        <div class="form-text">
                                            Auto-generated from the category name.
                                            You can edit it if needed.
                                        </div>

                                    </div>


                                    {{-- ==================== SHORT DESCRIPTION ==================== --}}
                                    <div class="mb-3">

                                        <label for="short_description" class="form-label fw-semibold">

                                            Short Description

                                        </label>


                                        <textarea id="short_description" name="short_description"
                                            class="form-control @error('short_description') is-invalid @enderror" rows="2" maxlength="160"
                                            placeholder="A one-line summary shown in category listings">{{ old('short_description') }}</textarea>


                                        @error('short_description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror


                                        <div class="form-text">
                                            Recommended: up to 160 characters.
                                        </div>

                                    </div>


                                    {{-- ==================== FULL DESCRIPTION ==================== --}}
                                    <div class="mb-0">

                                        <label for="description" class="form-label fw-semibold">

                                            Full Description

                                        </label>


                                        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror"
                                            rows="7" placeholder="Describe what belongs in this category">{{ old('description') }}</textarea>


                                        @error('description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                    {{-- ==================== CATEGORY IMAGE ==================== --}}
                                    <div class="mb-0 mt-3">

                                        <label for="image" class="form-label fw-semibold">

                                            Category Image

                                        </label>


                                        <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror"
                                            accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml">


                                        <div class="form-text">
                                            Upload a cover image for this category.
                                        </div>


                                        @error('image')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                </div>

                            </div>


                        </div>


                        {{-- ========================================================= --}}
                        {{-- RIGHT SIDE --}}
                        {{-- ========================================================= --}}
                        <div class="col-lg-4">


                            {{-- ==================== VISIBILITY ==================== --}}
                            <div class="card shadow-sm border-0 mb-4">

                                <div class="card-header bg-white d-flex align-items-center">

                                    <i class="bi bi-eye text-primary me-2"></i>

                                    <h5 class="fw-bold mb-0">
                                        Visibility
                                    </h5>

                                </div>


                                <div class="card-body">


                                    {{-- ==================== STATUS ==================== --}}
                                    <div class="mb-3">

                                        <label for="status" class="form-label fw-semibold">

                                            Status

                                        </label>


                                        <select id="status" name="status"
                                            class="form-select @error('status') is-invalid @enderror">

                                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>
                                                Published
                                            </option>

                                            <option value="draft"
                                                {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>
                                                Draft
                                            </option>

                                            <option value="hidden" {{ old('status') == 'hidden' ? 'selected' : '' }}>
                                                Hidden
                                            </option>

                                        </select>


                                        @error('status')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror


                                        <div class="form-text">
                                            Draft categories aren't shown to customers.
                                        </div>

                                    </div>


                                    {{-- ==================== SHOW ON HOMEPAGE ==================== --}}
                                    <div class="form-check form-switch mb-0">

                                        <input class="form-check-input" type="checkbox" id="show_on_homepage"
                                            name="show_on_homepage" value="1"
                                            {{ old('show_on_homepage') ? 'checked' : '' }}>


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



    @endsection


    {{-- ==================== JAVASCRIPT ==================== --}}
    @push('scripts')
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
    @endpush
