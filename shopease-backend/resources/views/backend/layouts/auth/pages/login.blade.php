@extends('backend.layouts.auth.app')

@section('title')
    {{ env('APP_NAME') }} || Sign In
@endsection

@section('main')
    <div class="auth-wrapper py-6">
        <div class="container d-flex flex-column">
            <div class="row align-items-center justify-content-center g-0 min-vh-100">
                <div class="col-12 col-md-8 col-lg-5 col-xxl-4">
                    <!-- Card -->
                    <div class="card auth-card border-0 shadow-lg">
                        <!-- Card body -->
                        <div class="card-body p-5">
                            <div class="mb-4 text-center">
                                <h1 class="mb-1 fw-bold display-5 text-dark">Welcome Back</h1>
                                <p class="text-muted">Please enter your details to sign in.</p>
                            </div>
                            
                            <!-- Form -->
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" id="email" class="form-control form-control-lg" name="email" 
                                        value="{{old('email')}}" placeholder="name@company.com" required autofocus>
                                    @error('email')
                                        <div class="text-danger small mt-1">
                                            <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <!-- Password -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label for="password" class="form-label mb-0">Password</label>
                                    </div>
                                    <input type="password" id="password" class="form-control form-control-lg" name="password"
                                        placeholder="••••••••" required>
                                    @error('password')
                                        <div class="text-danger small mt-1">
                                            <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <!-- Checkbox -->
                                <div class="mb-4">
                                    <div class="form-check custom-checkbox">
                                        <input type="checkbox" class="form-check-input" id="rememberme" name="remember">
                                        <label class="form-check-label text-muted" for="rememberme">Keep me logged in</label>
                                    </div>
                                </div>
                                
                                <!-- Button -->
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-modern-primary py-3 fw-bold">
                                        Sign In to Account
                                    </button>
                                </div>
                                
                                <!-- Footer -->
                                <div class="mt-4 text-center">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
