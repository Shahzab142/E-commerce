@extends('admin.layouts.main')

@push('title')
    <title>{{ $category->name }} - View Category</title>
@endpush

@section('content')
    <div id="layoutSidenav_content">

        <main>

            <div class="container-fluid px-4 py-4">

                {{-- Header --}}
                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>

                        <h2 class="fw-bold mb-1">

                            <i class="bi bi-eye me-2 text-primary"></i>

                            View Category

                        </h2>

                        <p class="text-muted mb-0">
                            View the complete details of this category.
                        </p>

                    </div>

                    <div class="d-flex gap-2">

                        <a href="{{ route('admin.categories.view') }}" class="btn btn-outline-secondary">

                            <i class="bi bi-arrow-left me-1"></i>

                            Back to Categories

                        </a>

                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary">

                            <i class="bi bi-pencil-square me-1"></i>

                            Edit Category

                        </a>

                    </div>

                </div>


                {{-- Category Details --}}
                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white py-3">

                        <h5 class="fw-bold mb-0">

                            <i class="bi bi-info-circle text-primary me-2"></i>

                            Category Details

                        </h5>

                    </div>


                    <div class="card-body">

                        <div class="row g-4">

                            {{-- Category Name --}}
                            <div class="col-md-6">

                                <label class="fw-bold text-muted">
                                    Category Name
                                </label>

                                <div class="form-control bg-light">

                                    {{ $category->name }}

                                </div>

                            </div>


                            {{-- Category ID --}}
                            <div class="col-md-6">

                                <label class="fw-bold text-muted">
                                    Category ID
                                </label>

                                <div class="form-control bg-light">

                                    {{ $category->id }}

                                </div>

                            </div>


                            {{-- Slug --}}
                            <div class="col-md-6">

                                <label class="fw-bold text-muted">
                                    Slug
                                </label>

                                <div class="form-control bg-light">

                                    {{ $category->slug }}

                                </div>

                            </div>


                            {{-- Status --}}
                            <div class="col-md-6">

                                <label class="fw-bold text-muted">
                                    Status
                                </label>

                                <div>

                                    @if ($category->status === 'published')
                                        <span class="badge bg-success fs-6">
                                            Published
                                        </span>
                                    @elseif ($category->status === 'draft')
                                        <span class="badge bg-warning text-dark fs-6">
                                            Draft
                                        </span>
                                    @else
                                        <span class="badge bg-secondary fs-6">
                                            Hidden
                                        </span>
                                    @endif

                                </div>

                            </div>


                            {{-- Short Description --}}
                            <div class="col-12">

                                <label class="fw-bold text-muted">
                                    Short Description
                                </label>

                                <div class="border rounded p-3 bg-light">

                                    {{ $category->short_description ?? 'No short description available.' }}

                                </div>

                            </div>


                            {{-- Full Description --}}
                            <div class="col-12">

                                <label class="fw-bold text-muted">
                                    Full Description
                                </label>

                                <div class="border rounded p-3 bg-light">

                                    {!! nl2br(e($category->description ?? 'No description available.')) !!}

                                </div>

                            </div>


                            {{-- Homepage --}}
                            <div class="col-md-6">

                                <label class="fw-bold text-muted">
                                    Show on Homepage
                                </label>

                                <div class="mt-1">

                                    @if ($category->show_on_homepage)
                                        <span class="badge bg-success fs-6">

                                            <i class="bi bi-check-circle me-1"></i>

                                            Yes

                                        </span>
                                    @else
                                        <span class="badge bg-secondary fs-6">

                                            <i class="bi bi-x-circle me-1"></i>

                                            No

                                        </span>
                                    @endif

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- Footer --}}
                    <div class="card-footer bg-white">

                        <div class="d-flex justify-content-end gap-2">

                            <a href="{{ route('admin.categories.view') }}" class="btn btn-outline-secondary">

                                <i class="bi bi-arrow-left me-1"></i>

                                Back

                            </a>

                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary">

                                <i class="bi bi-pencil-square me-1"></i>

                                Edit Category

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </main>
    @endsection
