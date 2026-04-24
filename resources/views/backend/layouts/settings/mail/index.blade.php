@extends('backend.app')

@section('title')
    {{ env('APP_NAME') }} || Mail Settings
@endsection

@section('content')
    <div id="app-content">
        <div class="app-content-area">
            <div class="container-fluid">
                <!-- Page Header -->
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="mb-2">
                             <h2 class="fw-bold mb-1">Email Configuration</h2>
                             <p class="text-muted">Configure your SMTP settings to enable system-wide email notifications.</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-8 col-lg-10 col-12">
                        <!-- Card -->
                        <div class="card border-0 shadow-sm rounded-lg overflow-hidden">
                            <div class="card-header bg-white border-bottom py-4 px-5">
                                <h4 class="mb-0 fw-bold">SMTP Settings</h4>
                            </div>
                            <div class="card-body p-5">
                                <form class="row g-4" action="{{ route('v1.setting.mail.store') }}" method="POST">
                                    @csrf
                                    
                                    <div class="col-md-6">
                                        <label for="mail_mailer" class="form-label fw-semibold">Mail Mailer</label>
                                        <input type="text" class="form-control bg-light border-0 shadow-none py-2" id="mail_mailer"
                                            name="mail_mailer" value="{{ env('MAIL_MAILER') }}" placeholder="smtp">
                                        @error('mail_mailer')
                                            <div class="validation-error small mt-1">
                                                <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="mail_host" class="form-label fw-semibold">Mail Host</label>
                                        <input type="text" class="form-control bg-light border-0 shadow-none py-2" id="mail_host"
                                            name="mail_host" value="{{ env('MAIL_HOST') }}" placeholder="smtp.mailtrap.io">
                                        @error('mail_host')
                                            <div class="validation-error small mt-1">
                                                <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="mail_port" class="form-label fw-semibold">Mail Port</label>
                                        <input type="text" class="form-control bg-light border-0 shadow-none py-2" id="mail_port"
                                            name="mail_port" value="{{ env('MAIL_PORT') }}" placeholder="2525">
                                        @error('mail_port')
                                            <div class="validation-error small mt-1">
                                                <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="mail_username" class="form-label fw-semibold">Username</label>
                                        <input type="text" class="form-control bg-light border-0 shadow-none py-2" id="mail_username"
                                            name="mail_username" value="{{ env('MAIL_USERNAME') }}" placeholder="username">
                                        @error('mail_username')
                                            <div class="validation-error small mt-1">
                                                <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="mail_password" class="form-label fw-semibold">Password</label>
                                        <input type="password" class="form-control bg-light border-0 shadow-none py-2" id="mail_password"
                                            name="mail_password" placeholder="••••••••" value="{{ env('MAIL_PASSWORD') }}">
                                        @error('mail_password')
                                            <div class="validation-error small mt-1">
                                                <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="mail_encryption" class="form-label fw-semibold">Encryption</label>
                                        <select class="form-select bg-light border-0 shadow-none py-2" id="mail_encryption" name="mail_encryption">
                                            <option value="tls" {{ env('MAIL_ENCRYPTION') == 'tls' ? 'selected' : '' }}>TLS</option>
                                            <option value="ssl" {{ env('MAIL_ENCRYPTION') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                            <option value="null" {{ env('MAIL_ENCRYPTION') == 'null' ? 'selected' : '' }}>None</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="mail_address" class="form-label fw-semibold">Sender Email Address</label>
                                        <input type="email" class="form-control bg-light border-0 shadow-none py-2" id="mail_address"
                                            name="mail_address" value="{{ env('MAIL_FROM_ADDRESS') }}" placeholder="hello@company.com">
                                        @error('mail_address')
                                            <div class="validation-error small mt-1">
                                                <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-12 mt-4">
                                        <div class="form-check bg-light p-3 rounded-3 ms-0 d-flex align-items-center">
                                            <input class="form-check-input ms-2" type="checkbox" id="condition" name="condition" required>
                                            <label class="form-check-label ms-2 text-muted small fw-medium" for="condition">
                                                I confirm that these SMTP settings are correct and I want to save them.
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-5">
                                        <button class="btn btn-modern-primary px-5 py-2 shadow-sm" type="submit">
                                            <i data-feather="save" class="icon-xxs me-2"></i> Save Configuration
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Help Sidebar -->
                    <div class="col-xl-4 col-12">
                        <div class="card border-0 shadow-none bg-light-primary rounded-lg p-3">
                            <div class="card-body">
                                <div class="icon-shape bg-primary text-white rounded-circle p-2 mb-4">
                                    <i data-feather="help-circle" class="icon-xs"></i>
                                </div>
                                <h5 class="fw-bold mb-3">SMTP help</h5>
                                <ul class="list-unstyled mb-0 text-muted small">
                                    <li class="mb-2 d-flex">
                                        <i data-feather="check" class="icon-xxs text-primary me-2 mt-1"></i>
                                        <span>Use <b>smtp.gmail.com</b> for Gmail accounts.</span>
                                    </li>
                                    <li class="mb-2 d-flex">
                                        <i data-feather="check" class="icon-xxs text-primary me-2 mt-1"></i>
                                        <span>Use port <b>465</b> for SSL or <b>587</b> for TLS.</span>
                                    </li>
                                    <li class="d-flex">
                                        <i data-feather="check" class="icon-xxs text-primary me-2 mt-1"></i>
                                        <span>Ensure "Less secure app access" is enabled for older services.</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
