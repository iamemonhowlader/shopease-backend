@extends('backend.app')

@section('title')
    {{ env('APP_NAME') }} || Dashboard
@endsection

@section('content')
    <div class="container-fluid py-5">
        <!-- Page Top Header -->
        <div class="row align-items-center mb-6">
            <div class="col-md-8">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-primary-light rounded-circle p-2 me-3">
                        {{-- <i data-feather="terminal" class="text-primary icon-xs"></i> --}}
                    </div>
                    <h1 class="h3 mb-0 fw-extrabold tracking-tight">Overview</h1>
                </div>
                <p class="text-muted mb-0">Monitor your project performance and team activity in real-time.</p>
            </div>
            <div class="col-md-4 text-md-end mt-4 mt-md-0">
                <div class="d-flex gap-2 justify-content-md-end">
                    <button class="btn btn-outline-light border rounded-pill px-4 text-dark bg-white shadow-sm">
                        <i data-feather="calendar" class="icon-xxs me-2 text-muted"></i>Last 30 Days
                    </button>
                    <button class="btn btn-modern-primary rounded-pill px-4">
                        <i data-feather="plus" class="icon-xxs me-2"></i>New Project
                    </button>
                </div>
            </div>
        </div>

        <!-- Welcome Message -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 bg-gradient-primary text-white overflow-hidden">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div>
                            <h4 class="fw-bold mb-1">
                                 Welcome back, {{ auth()->user()->name ?? 'User' }}!
                            </h4>
                            <p class="mb-0 opacity-75">
                                Here's what's happening with your projects today — <strong>{{ now()->format('l, F j, Y') }}</strong>.
                            </p>
                        </div>
                        <div>
                            <a href="#" class="btn btn-light text-primary fw-semibold rounded-pill px-4">
                                <i data-feather="activity" class="icon-xxs me-2"></i>View Activity
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection