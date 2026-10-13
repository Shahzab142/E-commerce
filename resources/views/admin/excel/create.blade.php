@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid px-4 py-5 d-flex flex-column justify-content-center align-items-center" style="min-height: 80vh;">
        
        <div class="card shadow-lg border-0" style="width: 100%; max-width: 500px; border-radius: 12px;">
            <div class="card-body p-5">
                
                <div class="text-center mb-4 pb-2 border-bottom border-light">
                    <div class="mb-3">
                        <i class="bi bi-file-earmark-excel text-success" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="text-dark mb-2" style="font-weight: 500;">Export Excel Report</h4>
                    <p class="text-muted small mb-0">Generate a custom excel report based on date and order status.</p>
                </div>
                @if (session('error'))
                    <div class="alert alert-danger rounded-3">{{ session('error') }}</div>
                @endif

                <form action="{{ route('admin.excel.generate') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="from_date" class="form-label text-muted small fw-bold">From Date</label>
                        <input type="date" class="form-control form-control-lg bg-light border-0 text-dark" id="from_date" name="from_date" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="to_date" class="form-label text-muted small fw-bold">To Date</label>
                        <input type="date" class="form-control form-control-lg bg-light border-0 text-dark" id="to_date" name="to_date" required>
                    </div>

                    <div class="mb-5">
                        <label for="order_status" class="form-label text-muted small fw-bold">Order Status</label>
                        <select class="form-select form-select-lg bg-light border-0 text-dark" id="order_status" name="order_status">
                            <option value="" selected>All Statuses</option>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg fw-bold" style="border-radius: 30px;">
                            GENERATE
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
