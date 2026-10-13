@extends('admin.layouts.main')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
        <div>
            <h4 class="mb-1 text-dark" style="font-weight: 500;"><i class="bi bi-filetype-csv me-2 text-success"></i>Import Products</h4>
            <p class="text-muted mb-0">Upload a CSV file to bulk import products into your inventory.</p>
        </div>
        <div class="mt-3">
            <a href="{{ route('admin.products.view') }}" class="btn btn-outline-secondary rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Back to Products
            </a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0">Upload CSV File</h5>
                </div>
                <div class="card-body p-4">
                    
                    @if (session('success'))
                        <div class="alert alert-success rounded-3">{{ session('success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="alert alert-secondary border-0 rounded-4 shadow-sm mb-4">
                        <div class="d-flex">
                            <div class="text-muted me-3">
                                <i class="bi bi-info-circle-fill fs-3"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">CSV Format Requirements</h6>
                                <p class="mb-2 text-muted small">Your CSV file must have exactly these headers in order:</p>
                                <div class="bg-white p-2 rounded border mb-2 font-monospace small">Name, SKU, Regular Price, Quantity, Category ID</div>
                                <p class="text-muted small mb-1">Example row:</p>
                                <div class="bg-white p-2 rounded border font-monospace small text-success">My Product, SKU-1234, 19.99, 100, 1</div>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('admin.products.import_excel') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="file" class="form-label fw-bold">Select File</label>
                            <input type="file" class="form-control form-control-lg bg-light border-0" name="file" id="file" accept=".csv" required>
                        </div>
                        
                        <hr class="text-muted opacity-25 my-4">
                        
                        <div class="text-end">
                            <button type="submit" class="btn btn-success rounded-pill px-4">
                                <i class="bi bi-cloud-arrow-up me-2"></i>Upload and Import
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
