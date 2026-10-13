@extends('admin.layouts.main')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 mb-4 text-center" style="color: #4a5568; font-weight: 600;">User Message Broadcast</h1>
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-body p-4">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('admin.user-message.update') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="message" class="form-label text-muted small fw-bold">Message Text</label>
                            <textarea class="form-control bg-light border-0" id="message" name="message" rows="4" placeholder="Enter the message you want to display on the user dashboard...">{{ $userMessage->message ?? '' }}</textarea>
                        </div>
                        
                        <div class="mb-4 form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ ($userMessage->is_active ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="is_active">Enable this message?</label>
                            <div class="form-text">If enabled, this message will be visible to all users on their dashboard.</div>
                        </div>
                        
                        <div>
                            <button type="submit" class="btn btn-primary px-4 py-2 fw-bold" style="border-radius: 4px;">Save Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
