@extends('admin.layouts.main')

@push('title')
    <title>Edit Category</title>
@endpush

@section('content')

    <div id="layoutSidenav_content">

        <main>

            <div class="container-fluid px-4 py-4">

                {{-- =========================================================
                    HEADER
                ========================================================== --}}

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


                    {{-- Header Buttons --}}

                    <div class="mt-3 mt-md-0 d-flex gap-2">

                        {{-- Back to Category List --}}

                        <a href="{{ route('admin.categories.view') }}" class="btn btn-outline-secondary">

                            <i class="bi bi-arrow-left me-1"></i>

                            Back to List

                        </a>


                        {{-- Preview --}}

                        @if ($category->slug)
                            <a href="{{ url('/category/' . $category->slug) }}" target="_blank"
                                class="btn btn-outline-secondary">

                                <i class="bi bi-eye me-1"></i>

                                Preview

                            </a>
                        @endif


                        {{-- Update Button --}}

                        <button type="submit" form="category-form" class="btn btn-primary">

                            <i class="bi bi-check-circle me-1"></i>

                            Update Category

                        </button>

                    </div>

                </div>



                {{-- =========================================================
                    VALIDATION ERRORS
                ========================================================== --}}

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">

                        <strong>
                            Please fix the following:
                        </strong>

                        <ul class="mb-0 mt-1">

                            @foreach ($errors->all() as $error)
                                <li>
                                    {{ $error }}
                                </li>
                            @endforeach

                        </ul>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>

                    </div>
                @endif



                {{-- =========================================================
                    SUCCESS MESSAGE
                ========================================================== --}}

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">

                        <i class="bi bi-check-circle me-1"></i>

                        {{ session('success') }}

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>

                    </div>
                @endif



                {{-- =========================================================
                    UPDATE FORM
                ========================================================== --}}

                <form id="category-form" action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    @method('PUT')


                    <div class="card shadow-sm border-0">


                        {{-- =================================================
                            CARD HEADER
                        ================================================== --}}

                        <div class="card-header bg-white">

                            <h5 class="fw-bold mb-0">

                                <i class="bi bi-info-circle me-1 text-primary"></i>

                                Category Details

                            </h5>

                        </div>



                        {{-- =================================================
                            CATEGORY DETAILS
                        ================================================== --}}

                        <div class="table-responsive">

                            <table class="table align-middle mb-0">

                                <tbody>


                                    {{-- =====================================
                                        CATEGORY NAME
                                    ====================================== --}}

                                    <tr>

                                        <th class="fw-semibold text-nowrap" style="width: 220px;">

                                            Category Name

                                            <span class="text-danger">
                                                *
                                            </span>

                                        </th>


                                        <td>

                                            <input type="text" id="name" name="name"
                                                value="{{ old('name', $category->name) }}"
                                                class="form-control @error('name') is-invalid @enderror" required>


                                            @error('name')
                                                <div class="invalid-feedback">

                                                    {{ $message }}

                                                </div>
                                            @enderror

                                        </td>

                                    </tr>



                                    {{-- =====================================
                                        SLUG
                                    ====================================== --}}

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
                                                    value="{{ old('slug', $category->slug) }}"
                                                    class="form-control @error('slug') is-invalid @enderror">

                                            </div>


                                            @error('slug')
                                                <div class="text-danger small mt-1">

                                                    {{ $message }}

                                                </div>
                                            @enderror


                                            <div class="form-text">

                                                Changing the slug will change this category's URL.

                                            </div>

                                        </td>

                                    </tr>



                                    {{-- =====================================
                                        SHORT DESCRIPTION
                                    ====================================== --}}

                                    <tr>

                                        <th class="fw-semibold text-nowrap">

                                            Short Description

                                        </th>


                                        <td>

                                            <textarea id="short_description" name="short_description"
                                                class="form-control @error('short_description') is-invalid @enderror" rows="3" maxlength="160">{{ old('short_description', $category->short_description) }}</textarea>


                                            @error('short_description')
                                                <div class="text-danger small mt-1">

                                                    {{ $message }}

                                                </div>
                                            @enderror


                                            <div class="form-text">

                                                Recommended: up to 160 characters.

                                            </div>

                                        </td>

                                    </tr>



                                    {{-- =====================================
                                        FULL DESCRIPTION
                                    ====================================== --}}

                                    <tr>

                                        <th class="fw-semibold text-nowrap">

                                            Full Description

                                        </th>


                                        <td>

                                            <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror"
                                                rows="8">{{ old('description', $category->description) }}</textarea>


                                            @error('description')
                                                <div class="text-danger small mt-1">

                                                    {{ $message }}

                                                </div>
                                            @enderror

                                        </td>

                                    </tr>



                                    {{-- =====================================
                                        STATUS
                                    ====================================== --}}

                                    <tr>

                                        <th class="fw-semibold text-nowrap">

                                            Status

                                        </th>


                                        <td>

                                            <select id="status" name="status"
                                                class="form-select @error('status') is-invalid @enderror">


                                                <option value="published"
                                                    {{ old('status', $category->status) == 'published' ? 'selected' : '' }}>

                                                    Published

                                                </option>


                                                <option value="draft"
                                                    {{ old('status', $category->status) == 'draft' ? 'selected' : '' }}>

                                                    Draft

                                                </option>


                                                <option value="hidden"
                                                    {{ old('status', $category->status) == 'hidden' ? 'selected' : '' }}>

                                                    Hidden

                                                </option>


                                            </select>


                                            @error('status')
                                                <div class="text-danger small mt-1">

                                                    {{ $message }}

                                                </div>
                                            @enderror


                                            <div class="form-text">

                                                Draft or hidden categories aren't shown to customers.

                                            </div>

                                        </td>

                                    </tr>



                                    {{-- =====================================
                                        SHOW ON HOMEPAGE
                                    ====================================== --}}

                                    <tr>

                                        <th class="fw-semibold text-nowrap">

                                            Show on Homepage

                                        </th>


                                        <td>

                                            <div class="form-check form-switch mb-0">


                                                <input class="form-check-input" type="checkbox" id="show_on_homepage"
                                                    name="show_on_homepage" value="1"
                                                    {{ old('show_on_homepage', $category->show_on_homepage) ? 'checked' : '' }}>


                                                <label class="form-check-label" for="show_on_homepage">

                                                    Feature this category on the homepage

                                                </label>


                                            </div>

                                        </td>

                                    </tr>


                                    {{-- =====================================
                                        CATEGORY IMAGE
                                    ====================================== --}}

                                    <tr>

                                        <th class="fw-semibold text-nowrap">

                                            Category Image

                                        </th>


                                        <td>

                                            @if ($category->image)
                                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                                    class="rounded border mb-2"
                                                    style="width: 80px; height: 80px; object-fit: cover;">
                                            @endif

                                            <input type="file" id="image" name="image"
                                                class="form-control @error('image') is-invalid @enderror"
                                                accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml">

                                            <div class="form-text">
                                                Upload a cover image for this category. Leave empty to keep the current image.
                                            </div>

                                            @error('image')
                                                <div class="text-danger small mt-1">

                                                    {{ $message }}

                                                </div>
                                            @enderror

                                        </td>

                                    </tr>


                                </tbody>

                            </table>

                        </div>



                        {{-- =================================================
                            CARD FOOTER
                        ================================================== --}}

                        <div class="card-footer bg-white d-flex justify-content-end gap-2">


                            {{-- Reset Changes --}}

                            <button type="button" id="resetChanges" class="btn btn-outline-secondary">

                                <i class="bi bi-arrow-counterclockwise me-1"></i>

                                Reset Changes

                            </button>


                            {{-- Update Category --}}

                            <button type="submit" class="btn btn-primary">

                                <i class="bi bi-cloud-upload me-2"></i>

                                Update Category

                            </button>


                        </div>


                    </div>

                </form>

            </div>

        </main>


    @endsection


    @push('scripts')
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
    @endpush
