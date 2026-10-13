@extends('admin.layouts.main')

@push('title')
    <title>Product Questions - {{ config('app.name', 'E-Commerce') }}</title>
@endpush

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 py-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h2 fw-bold">Product Questions</h1>
                        <p class="text-muted">All customer questions across products.</p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold mb-0">All Questions</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Product</th>
                                        <th>Customer</th>
                                        <th>Vendor</th>
                                        <th>Question</th>
                                        <th>Answer</th>
                                        <th class="text-end pe-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($questions as $question)
                                        <tr>
                                            <td class="ps-4 fw-semibold">{{ $question->product?->name ?? 'Deleted Product' }}</td>
                                            <td>{{ $question->user?->name ?? 'Guest' }}</td>
                                            <td>Admin</td>
                                            <td>{{ Str::limit($question->question, 80) }}</td>
                                            <td>
                                                @if ($question->answer)
                                                    <span class="text-success"><i class="bi bi-check-circle me-1"></i>Answered</span>
                                                @else
                                                    <span class="text-muted"><i class="bi bi-hourglass me-1"></i>Pending</span>
                                                @endif
                                            </td>
                                            <td class="text-end pe-4">
                                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill"
                                                        data-bs-toggle="modal" data-bs-target="#answerModal{{ $question->id }}">
                                                    <i class="bi bi-reply me-1"></i>Answer
                                                </button>
                                                <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this question?');" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">
                                                        <i class="bi bi-trash"></i> Delete
                                                    </button>
                                                </form>

                                                @if ($question->answer)
                                                    <div class="mt-2 p-3 bg-light rounded-3 small">
                                                        <strong>Answer:</strong> {{ $question->answer }}
                                                        <br><small class="text-muted">Answered on {{ $question->answered_at?->format('M d, Y') }}</small>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>

                                        {{-- Answer Modal --}}
                                        <div class="modal fade" id="answerModal{{ $question->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Answer Question</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('admin.questions.answer', $question) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="modal-body">
                                                            <p class="mb-2"><strong>Question:</strong> {{ $question->question }}</p>
                                                            <div class="mb-3">
                                                                <label for="answer{{ $question->id }}" class="form-label">Your Answer</label>
                                                                <textarea id="answer{{ $question->id }}" name="answer" class="form-control" rows="5" required>{{ old('answer', $question->answer) }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary">Submit Answer</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-5">
                                                <i class="bi bi-question-circle fs-1 d-block mb-2"></i>
                                                No questions yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
  
@endsection
