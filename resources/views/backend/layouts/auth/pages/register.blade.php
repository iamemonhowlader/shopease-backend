@extends('backend.layouts.auth.app')

@section('title')
    {{ env('APP_NAME') }} || Registration
@endsection

@section('main')
    <div class="auth-wrapper">
        <div class="auth-card" style="max-width: 500px;">
            <div class="card-body p-5 p-md-6">
                <!-- Brand logo -->
                <div class="mb-5 text-center">
                    <h2 class="display-6 mb-1 text-primary">Create Account</h2>
                    <p class="text-muted">Join us and start managing your workspace.</p>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="row">
                        <!-- first name -->
                        <div class="col-md-6 mb-4">
                            <label for="first_name" class="form-label fw-semibold">First Name</label>
                            <input type="text" id="first_name" class="form-control" name="first_name"
                                placeholder="John" value="{{old('first_name')}}" required>
                            @error('first_name')
                                <div class="validation-error">
                                    <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- last name -->
                        <div class="col-md-6 mb-4">
                            <label for="last_name" class="form-label fw-semibold">Last Name</label>
                            <input type="text" id="last_name" class="form-control" name="last_name"
                                placeholder="Doe" value="{{old('last_name')}}" required>
                            @error('last_name')
                                <div class="validation-error">
                                    <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold">Email Address</label>
                        <input type="email" id="email" class="form-control" name="email"
                            placeholder="name@company.com" value="{{old('email')}}" required>
                        @error('email')
                            <div class="validation-error">
                                <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input type="password" id="password" class="form-control" name="password"
                            placeholder="••••••••" required>
                        @error('password')
                            <div class="validation-error">
                                <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label for="confirm-password" class="form-label fw-semibold">Confirm Password</label>
                        <input type="password" id="confirm-password" class="form-control" name="password_confirmation"
                            placeholder="••••••••" required>
                    </div>

                    <!-- Checkbox -->
                    <div class="mb-4">
                        <div class="form-check custom-checkbox">
                            <input type="checkbox" class="form-check-input" id="agreeCheck" name="agreeCheck" required>
                            <label class="form-check-label text-muted" for="agreeCheck">
                                <span class="fs-6">I agree to the <a href="#" class="text-primary text-decoration-none">Terms of Service</a> and <a href="#" class="text-primary text-decoration-none">Privacy Policy</a></span>
                            </label>
                        </div>
                        @error('agreeCheck')
                            <div class="validation-error">
                                <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Action Button -->
                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-modern-primary py-3">
                            Create Free Account
                        </button>
                    </div>

                    <!-- Footer Link -->
                    <div class="text-center">
                        <p class="mb-0 text-muted">Already have an account? 
                            <a href="{{route('login')}}" class="text-primary fw-bold text-decoration-none ms-1">Sign In</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
