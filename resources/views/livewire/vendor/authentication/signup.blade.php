<div class="min-vh-100 bg-light">

    @php
        $step = $currentStep ?? 1;

        $progress = match ($step) {
            1 => 33,
            2 => 66,
            3 => 100,
            default => 33,
        };
    @endphp

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">

    <div class="container-fluid min-vh-100">
        <div class="row justify-content-center min-vh-100">

            <div class="col-12 col-md-11 col-lg-9 col-xl-8">

                <div class="py-4 py-md-5">

                    {{-- Header --}}
                    <div class="text-center mb-4">

                        <div class="d-inline-flex align-items-center justify-content-center mb-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                style="width: 48px; height: 48px;">
                                <i class="bi bi-shop fs-4"></i>
                            </div>
                        </div>

                        <h1 class="fw-bold text-dark mb-2">
                            Become a Seller
                        </h1>

                        <p class="text-secondary mb-0">
                            Create your seller account and start growing your business.
                        </p>

                    </div>


                    {{-- Progress --}}
                    <div class="card border-0 shadow-sm rounded-4 mb-4">

                        <div class="card-body p-3 p-md-4">

                            <div class="d-flex justify-content-between align-items-center mb-2">

                                <span class="small fw-semibold text-secondary">
                                    Registration Progress
                                </span>

                                <span class="small fw-bold text-primary">
                                    Step {{ $step }} of 3
                                </span>

                            </div>

                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary" role="progressbar"
                                    style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <div class="row mt-3 g-2">

                                <div class="col-4 text-center">
                                    <div
                                        class="small fw-semibold
                                        {{ $step >= 1 ? 'text-primary' : 'text-secondary' }}">
                                        <i class="bi bi-person me-1"></i>
                                        Personal
                                    </div>
                                </div>

                                <div class="col-4 text-center">
                                    <div
                                        class="small fw-semibold
                                        {{ $step >= 2 ? 'text-primary' : 'text-secondary' }}">
                                        <i class="bi bi-building me-1"></i>
                                        Business
                                    </div>
                                </div>

                                <div class="col-4 text-center">
                                    <div
                                        class="small fw-semibold
                                        {{ $step >= 3 ? 'text-primary' : 'text-secondary' }}">
                                        <i class="bi bi-bank me-1"></i>
                                        Payout
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- Main Form --}}
                    <form wire:submit.prevent="register" class="card border-0 shadow-lg rounded-4 overflow-hidden">

                        {{-- Card Header --}}
                        <div class="card-header bg-white border-0 px-4 px-md-5 pt-4 pt-md-5">

                            <div class="d-flex align-items-center">

                                <div class="bg-primary bg-opacity-10 text-primary rounded-3 d-flex align-items-center justify-content-center me-3"
                                    style="width: 46px; height: 46px;">
                                    @if ($step == 1)
                                        <i class="bi bi-person fs-4"></i>
                                    @elseif ($step == 2)
                                        <i class="bi bi-building fs-4"></i>
                                    @else
                                        <i class="bi bi-credit-card fs-4"></i>
                                    @endif
                                </div>

                                <div>
                                    <h2 class="h4 fw-bold text-dark mb-1">
                                        @if ($step == 1)
                                            Personal Information
                                        @elseif ($step == 2)
                                            Business Information
                                        @else
                                            Account & Payout Information
                                        @endif
                                    </h2>

                                    <p class="text-secondary small mb-0">
                                        @if ($step == 1)
                                            Let's start with who you are.
                                        @elseif ($step == 2)
                                            This information will appear on your storefront.
                                        @else
                                            Tell us where to send your payments.
                                        @endif
                                    </p>
                                </div>

                            </div>

                        </div>


                        {{-- Error Messages --}}
                        <div class="px-4 px-md-5 pt-4">

                            @if ($errors->any())

                                <div class="alert alert-danger border-0 rounded-3 shadow-sm" role="alert">

                                    <div class="d-flex align-items-start">

                                        <i class="bi bi-exclamation-circle-fill me-2 mt-1"></i>

                                        <div>

                                            <strong>
                                                Please fix the following errors:
                                            </strong>

                                            <ul class="mb-0 mt-2 ps-3">

                                                @foreach ($errors->all() as $error)
                                                    <li>
                                                        {{ $error }}
                                                    </li>
                                                @endforeach

                                            </ul>

                                        </div>

                                    </div>

                                </div>

                            @endif

                        </div>


                        {{-- Form Body --}}
                        <div class="card-body px-4 px-md-5 pb-4 pb-md-5">


                            {{-- ================================================= --}}
                            {{-- STEP 1 --}}
                            {{-- ================================================= --}}

                            <div class="{{ $step == 1 ? 'd-block' : 'd-none' }}">

                                <div class="row g-4">

                                    {{-- Full Name --}}
                                    <div class="col-12">

                                        <label class="form-label fw-semibold text-dark">
                                            Full Name
                                        </label>

                                        <div class="input-group input-group-lg">

                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-person text-secondary"></i>
                                            </span>

                                            <input type="text" class="form-control border-start-0 bg-light"
                                                wire:model.live="name" autocomplete="name"
                                                placeholder="Enter your full name">

                                        </div>

                                        @error('name')
                                            <small class="text-danger d-block mt-1">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                    </div>


                                    {{-- Email --}}
                                    <div class="col-md-6">

                                        <label class="form-label fw-semibold text-dark">
                                            Email
                                        </label>

                                        <div class="input-group input-group-lg">

                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-envelope text-secondary"></i>
                                            </span>

                                            <input type="email" class="form-control border-start-0 bg-light"
                                                wire:model.live="email" autocomplete="email"
                                                placeholder="you@example.com">

                                        </div>

                                        @error('email')
                                            <small class="text-danger d-block mt-1">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                    </div>


                                    {{-- Phone --}}
                                    <div class="col-md-6">

                                        <label class="form-label fw-semibold text-dark">
                                            Phone
                                        </label>

                                        <div class="input-group input-group-lg">

                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-telephone text-secondary"></i>
                                            </span>

                                            <input type="text" class="form-control border-start-0 bg-light"
                                                wire:model.live="phone" autocomplete="tel"
                                                placeholder="Enter your phone number">

                                        </div>

                                    </div>


                                    @guest

                                        {{-- Password --}}
                                        <div class="col-md-6">

                                            <label class="form-label fw-semibold text-dark">
                                                Password
                                            </label>

                                        <div class="input-group input-group-lg">

                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-lock text-secondary"></i>
                                            </span>

                                            <input type="password" class="form-control border-start-0 bg-light"
                                                wire:model.live="password" autocomplete="new-password"
                                                placeholder="Create a password" id="vendor-password">

                                            <button type="button" class="btn btn-link text-muted"
                                                onclick="togglePassword('vendor-password', this)" aria-label="Toggle password visibility">
                                                <i class="bi bi-eye"></i>
                                            </button>

                                        </div>

                                        @error('password')
                                            <small class="text-danger d-block mt-1">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                    </div>


                                    {{-- Confirm Password --}}
                                    <div class="col-md-6">

                                        <label class="form-label fw-semibold text-dark">
                                            Confirm Password
                                        </label>

                                        <div class="input-group input-group-lg">

                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-shield-lock text-secondary"></i>
                                            </span>

                                            <input type="password" class="form-control border-start-0 bg-light"
                                                wire:model.live="password_confirmation" autocomplete="new-password"
                                                placeholder="Confirm your password" id="vendor-password-confirmation">

                                            <button type="button" class="btn btn-link text-muted"
                                                onclick="togglePassword('vendor-password-confirmation', this)" aria-label="Toggle password visibility">
                                                <i class="bi bi-eye"></i>
                                            </button>

                                        </div>

                                    </div>

                                    @endguest

                                </div>


                                {{-- Step 1 Navigation --}}
                                <div class="d-flex justify-content-end mt-5 pt-4 border-top">

                                    <button type="button" class="btn btn-primary btn-lg rounded-3 px-4 shadow-sm"
                                        wire:click="nextStep">

                                        Continue

                                        <i class="bi bi-arrow-right ms-2"></i>

                                    </button>

                                </div>

                            </div>



                            {{-- ================================================= --}}
                            {{-- STEP 2 --}}
                            {{-- ================================================= --}}

                            <div class="{{ $step == 2 ? 'd-block' : 'd-none' }}">

                                <div class="row g-4">

                                    {{-- Business Name --}}
                                    <div class="col-12">

                                        <label class="form-label fw-semibold text-dark">
                                            Business Name
                                        </label>

                                        <div class="input-group input-group-lg">

                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-shop text-secondary"></i>
                                            </span>

                                            <input type="text" class="form-control border-start-0 bg-light"
                                                wire:model.live="business_name"
                                                placeholder="Enter your business name">

                                        </div>

                                        @error('business_name')
                                            <small class="text-danger d-block mt-1">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                    </div>


                                    {{-- Business Type --}}
                                    <div class="col-md-6">

                                        <label class="form-label fw-semibold text-dark">
                                            Business Type
                                        </label>

                                        <select class="form-select form-select-lg bg-light rounded-3"
                                            wire:model.live="business_type">

                                            <option value="">
                                                Select Type
                                            </option>

                                            <option value="Sole Proprietorship">
                                                Sole Proprietorship
                                            </option>

                                            <option value="Partnership">
                                                Partnership
                                            </option>

                                            <option value="Private Limited">
                                                Private Limited
                                            </option>

                                            <option value="Other">
                                                Other
                                            </option>

                                        </select>

                                        @error('business_type')
                                            <small class="text-danger d-block mt-1">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                    </div>


                                    {{-- Business Phone --}}
                                    <div class="col-md-6">

                                        <label class="form-label fw-semibold text-dark">
                                            Business Phone
                                        </label>

                                        <div class="input-group input-group-lg">

                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-telephone text-secondary"></i>
                                            </span>

                                            <input type="text" class="form-control border-start-0 bg-light"
                                                wire:model.live="business_phone" placeholder="Business phone number">

                                        </div>

                                        @error('business_phone')
                                            <small class="text-danger d-block mt-1">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                    </div>


                                    {{-- Registration Number --}}
                                    <div class="col-md-6">

                                        <label class="form-label fw-semibold text-dark">
                                            Registration Number
                                        </label>

                                        <div class="input-group input-group-lg">

                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-file-earmark-text text-secondary"></i>
                                            </span>

                                            <input type="text" class="form-control border-start-0 bg-light"
                                                wire:model.live="registration_number"
                                                placeholder="Registration number">

                                        </div>

                                        @error('registration_number')
                                            <small class="text-danger d-block mt-1">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                    </div>


                                    {{-- Business Address --}}
                                    <div class="col-12">

                                        <label class="form-label fw-semibold text-dark">
                                            Business Address
                                        </label>

                                        <div class="input-group">

                                            <span
                                                class="input-group-text bg-light border-end-0 align-items-start pt-3">
                                                <i class="bi bi-geo-alt text-secondary"></i>
                                            </span>

                                            <textarea rows="4" class="form-control border-start-0 bg-light" wire:model.live="business_address"
                                                placeholder="Enter your complete business address"></textarea>

                                        </div>

                                        @error('business_address')
                                            <small class="text-danger d-block mt-1">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                    </div>

                                </div>


                                {{-- Step 2 Navigation --}}
                                <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">

                                    <button type="button" class="btn btn-outline-secondary btn-lg rounded-3 px-4"
                                        wire:click="previousStep">

                                        <i class="bi bi-arrow-left me-2"></i>

                                        Back

                                    </button>


                                    <button type="button" class="btn btn-primary btn-lg rounded-3 px-4 shadow-sm"
                                        wire:click="nextStep">

                                        Continue

                                        <i class="bi bi-arrow-right ms-2"></i>

                                    </button>

                                </div>

                            </div>



                            {{-- ================================================= --}}
                            {{-- STEP 3 --}}
                            {{-- ================================================= --}}

                            <div class="{{ $step == 3 ? 'd-block' : 'd-none' }}">

                                <div class="row g-4">

                                    {{-- Account Title --}}
                                    <div class="col-md-6">

                                        <label class="form-label fw-semibold text-dark">
                                            Account Title
                                        </label>

                                        <div class="input-group input-group-lg">

                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-person-vcard text-secondary"></i>
                                            </span>

                                            <input type="text" class="form-control border-start-0 bg-light"
                                                wire:model.live="account_title" placeholder="Account holder name">

                                        </div>

                                        @error('account_title')
                                            <small class="text-danger d-block mt-1">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                    </div>


                                    {{-- Bank Name --}}
                                    <div class="col-md-6">

                                        <label class="form-label fw-semibold text-dark">
                                            Bank Name
                                        </label>

                                        <div class="input-group input-group-lg">

                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-bank text-secondary"></i>
                                            </span>

                                            <input type="text" class="form-control border-start-0 bg-light"
                                                wire:model.live="bank_name" placeholder="Enter bank name">

                                        </div>

                                        @error('bank_name')
                                            <small class="text-danger d-block mt-1">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                    </div>


                                    {{-- Account Number --}}
                                    <div class="col-md-6">

                                        <label class="form-label fw-semibold text-dark">
                                            Account Number
                                        </label>

                                        <div class="input-group input-group-lg">

                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-credit-card text-secondary"></i>
                                            </span>

                                            <input type="text" class="form-control border-start-0 bg-light"
                                                wire:model.live="account_number" placeholder="Enter account number">

                                        </div>

                                        @error('account_number')
                                            <small class="text-danger d-block mt-1">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                    </div>


                                    {{-- IBAN --}}
                                    <div class="col-md-6">

                                        <label class="form-label fw-semibold text-dark">
                                            IBAN
                                        </label>

                                        <div class="input-group input-group-lg">

                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-globe2 text-secondary"></i>
                                            </span>

                                            <input type="text" class="form-control border-start-0 bg-light"
                                                wire:model.live="iban" placeholder="Enter your IBAN">

                                        </div>

                                        @error('iban')
                                            <small class="text-danger d-block mt-1">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                    </div>

                                </div>


                                {{-- Terms --}}
                                <div class="card bg-light border-0 rounded-3 mt-4">

                                    <div class="card-body">

                                        <div class="form-check">

                                            <input class="form-check-input" type="checkbox"
                                                wire:model.live="acceptTerms" id="acceptTerms">

                                            <label class="form-check-label fw-medium text-dark" for="acceptTerms">
                                                I agree to Seller Terms & Conditions.
                                            </label>

                                        </div>

                                        @error('acceptTerms')
                                            <small class="text-danger d-block mt-2">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                    </div>

                                </div>


                                {{-- Step 3 Navigation --}}
                                <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">

                                    <button type="button" class="btn btn-outline-secondary btn-lg rounded-3 px-4"
                                        wire:click="previousStep">

                                        <i class="bi bi-arrow-left me-2"></i>

                                        Back

                                    </button>


                                    <button type="submit" class="btn btn-primary btn-lg rounded-3 px-4 shadow-sm"
                                        wire:loading.attr="disabled">

                                        <span wire:loading.remove>

                                            <i class="bi bi-check-circle me-2"></i>

                                            Create Seller Account

                                        </span>


                                        <span wire:loading>

                                            <span class="spinner-border spinner-border-sm me-2" role="status"
                                                aria-hidden="true"></span>

                                            Creating...

                                        </span>

                                    </button>

                                </div>

                                

                            </div>

                        </div>

                    </form>

        @include('components.social-buttons')


                    {{-- Footer Hint --}}
                    <div class="text-center mt-4">

                        <p class="text-secondary small mb-0">

                            Already have a seller account?

                            <a href="{{ route('login') }}" class="text-primary fw-semibold text-decoration-none">
                                Login here
                            </a>

                        </p>

                    </div>

                </div>

            </div>

        </div>
    </div>

    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            if (!input) return;
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }
    </script>
</div>

