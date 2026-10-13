<div>
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --border: #e5e7eb;
            --bg: #f5f7fb;
            --text: #374151;
            --muted: #6b7280;
        }

        body {
            margin: 0;
            background: linear-gradient(135deg, #eef2ff, #f8fafc);
            font-family: Inter, sans-serif;
        }

        .as-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 42% 58%;
            background: #fff;
        }

        @media(max-width:991px) {
            .as-shell {
                grid-template-columns: 1fr;
            }

            .as-visual {
                min-height: 280px;
            }

            .as-form-panel {
                padding: 30px 20px;
            }
        }

        .as-visual {
            position: relative;
            overflow: hidden;
        }

        .as-visual img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .as-visual::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(rgba(79, 70, 229, .20), rgba(0, 0, 0, .55));
        }

        .as-form-panel {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 45px;
        }

        .as-form-inner {
            width: 100%;
            max-width: 650px;
        }

        .acc-label {
            font-size: .9rem;
            font-weight: 600;
            color: var(--text);
        }

        .acc-input {
            height: 50px;
            border-radius: 12px;
            border: 1px solid var(--border);
        }

        textarea.acc-input {
            height: auto;
            min-height: 95px;
        }

        .acc-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 .18rem rgba(79, 70, 229, .15);
        }

        .btn-acc-primary {
            background: var(--primary);
            border: 1px solid var(--primary);
            color: #fff;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
        }

        .btn-acc-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .text-danger {
            font-size: 0.85rem;
        }
    </style>

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

    <div class="as-shell">
        <!-- LEFT Visual -->
        <div class="as-visual">
            <img src="{{ asset('assets/images/user.png') }}" alt="Admin">
        </div>
        <!-- RIGHT Form -->
        <div class="as-form-panel">
            <div class="as-form-inner">
                <h2 class="fw-bold mb-4">Create Admin Account</h2>

                <form wire:submit.prevent="register">
                    {{-- Global error summary --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><i class="bi bi-exclamation-triangle-fill me-2"></i>Please fix the following
                                errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>{{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label acc-label">Full Name</label>
                            <input type="text" wire:model="name" class="form-control acc-input"
                                placeholder="Muhammad Aaqib">
                            @error('name')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label acc-label">Email Address</label>
                            <input type="email" wire:model="email" class="form-control acc-input"
                                placeholder="admin@yourstore.com">
                            @error('email')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label acc-label"><i class="bi bi-telephone me-2 text-primary"></i>Phone
                                Number</label>
                            <input type="text" wire:model="phone" class="form-control acc-input"
                                placeholder="+92 300 1234567">
                            @error('phone')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label acc-label"><i
                                    class="bi bi-globe me-2 text-primary"></i>Country</label>
                            <select wire:model="country" class="form-select acc-input">
                                <option value="">Select Country</option>
                                <option value="Pakistan">Pakistan</option>
                                <option value="India">India</option>
                                <option value="United Arab Emirates">UAE</option>
                                <option value="Saudi Arabia">Saudi Arabia</option>
                                <option value="United Kingdom">UK</option>
                                <option value="United States">USA</option>
                            </select>
                            @error('country')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label acc-label"><i class="bi bi-geo-alt me-2 text-primary"></i>State /
                                Province</label>
                            <input type="text" wire:model="state" class="form-control acc-input"
                                placeholder="Punjab">
                            @error('state')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label acc-label"><i
                                    class="bi bi-building me-2 text-primary"></i>City</label>
                            <input type="text" wire:model="city" class="form-control acc-input" placeholder="Lahore">
                            @error('city')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label acc-label"><i class="bi bi-mailbox me-2 text-primary"></i>Postal
                                Code</label>
                            <input type="text" wire:model="postal_code" class="form-control acc-input"
                                placeholder="54000">
                            @error('postal_code')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label acc-label"><i
                                    class="bi bi-house-door me-2 text-primary"></i>Address</label>
                            <textarea wire:model="address" rows="3" class="form-control acc-input" placeholder="Enter your complete address"></textarea>
                            @error('address')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label acc-label"><i
                                    class="bi bi-lock me-2 text-primary"></i>Password</label>
                            <div class="position-relative">
                                <input type="password" wire:model="password" class="form-control acc-input pe-5"
                                    placeholder="Minimum 8 characters">
                                <button type="button" class="btn btn-link position-absolute end-0 top-0 mt-2 me-2 text-muted"
                                    onclick="togglePassword('admin-password', this)" aria-label="Toggle password visibility">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label acc-label"><i
                                    class="bi bi-shield-lock me-2 text-primary"></i>Confirm
                                Password</label>
                            <div class="position-relative">
                                <input type="password" wire:model="password_confirmation" class="form-control acc-input pe-5"
                                    placeholder="Re-enter password">
                                <button type="button" class="btn btn-link position-absolute end-0 top-0 mt-2 me-2 text-muted"
                                    onclick="togglePassword('admin-password-confirmation', this)" aria-label="Toggle password visibility">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-center gap-2 mt-5">
                        <button type="submit" class="btn btn-acc-primary">
                            <i class="bi bi-person-check-fill me-2"></i> Create Admin Account
                        </button>
                    </div>
                </form>

        @include('components.social-buttons')

                

                <p class="mt-4 text-center">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
            </div>
        </div>
    </div>

</div>

