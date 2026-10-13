<section class="py-5">
    <div class="container-fluid px-4 px-lg-5 p-5">

        <div class="row justify-content-center">
            <div class="col-lg-10">

                <!-- Review Form -->
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-lg-5">

                        <div class="d-flex align-items-center gap-2 mb-1">
                            <i class="bi bi-pencil-square text-primary fs-4"></i>
                            <h4 class="fw-bold mb-0">Write Your Review</h4>
                        </div>
                        <p class="text-muted mb-4">
                            Share your experience to help other customers decide
                        </p>

                        @if (session('review_success'))
                            <div class="alert alert-success rounded-3">{{ session('review_success') }}</div>
                        @endif

                        <form action="{{ route('review.store', $product) }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div class="row g-4">

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control p-3 rounded-3 @error('name') is-invalid @enderror"
                                        value="{{ old('name', auth()->user()?->name) }}"
                                        placeholder="Enter your name" {{ auth()->check() ? 'readonly' : '' }} required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control p-3 rounded-3 @error('email') is-invalid @enderror"
                                        value="{{ old('email', auth()->user()?->email) }}"
                                        placeholder="example@gmail.com" {{ auth()->check() ? 'readonly' : '' }} required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold d-block mb-2">
                                        Rate this Product <span class="text-danger">*</span>
                                    </label>

                                    <div class="d-flex flex-wrap gap-2">

                                        <input type="radio" class="btn-check" name="rating" id="star5"
                                            value="5" {{ old('rating') == 5 ? 'checked' : '' }} required>
                                        <label class="btn btn-outline-secondary rounded-pill px-3" for="star5">
                                            5 <i class="bi bi-star-fill text-warning ms-1"></i>
                                        </label>

                                        <input type="radio" class="btn-check" name="rating" id="star4"
                                            value="4" {{ old('rating') == 4 ? 'checked' : '' }}>
                                        <label class="btn btn-outline-secondary rounded-pill px-3" for="star4">
                                            4 <i class="bi bi-star-fill text-warning ms-1"></i>
                                        </label>

                                        <input type="radio" class="btn-check" name="rating" id="star3"
                                            value="3" {{ old('rating') == 3 ? 'checked' : '' }}>
                                        <label class="btn btn-outline-secondary rounded-pill px-3" for="star3">
                                            3 <i class="bi bi-star-fill text-warning ms-1"></i>
                                        </label>

                                        <input type="radio" class="btn-check" name="rating" id="star2"
                                            value="2" {{ old('rating') == 2 ? 'checked' : '' }}>
                                        <label class="btn btn-outline-secondary rounded-pill px-3" for="star2">
                                            2 <i class="bi bi-star-fill text-warning ms-1"></i>
                                        </label>

                                        <input type="radio" class="btn-check" name="rating" id="star1"
                                            value="1" {{ old('rating') == 1 ? 'checked' : '' }}>
                                        <label class="btn btn-outline-secondary rounded-pill px-3" for="star1">
                                            1 <i class="bi bi-star-fill text-warning ms-1"></i>
                                        </label>

                                    </div>
                                    @error('rating')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold">Your Review <span
                                            class="text-danger">*</span></label>
                                    <textarea name="comment" rows="4" class="form-control p-3 rounded-3 @error('comment') is-invalid @enderror"
                                        placeholder="Tell other customers about your experience..." required>{{ old('comment') }}</textarea>
                                    @error('comment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    {{-- Honeypot spam trap: real users never fill this hidden field --}}
                                    <input type="text" name="website_url" class="d-none" tabindex="-1" autocomplete="off">
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary p-3 px-5 rounded-pill">
                                        <i class="bi bi-send-fill me-2"></i>Submit Review
                                    </button>
                                </div>

                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>
</section>
