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
                                 <i data-feather="terminal" class="text-primary icon-xs"></i>
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

                <!-- Stats Row: Compact & Smart -->
                <div class="row g-4 mb-6">
                    @php
                        $stats = [
                            ['label' => 'Revenue', 'value' => '$12,840', 'change' => '+14.5%', 'icon' => 'dollar-sign', 'color' => 'success'],
                            ['label' => 'Active Projects', 'value' => '42', 'change' => '+8.2%', 'icon' => 'cpu', 'color' => 'primary'],
                            ['label' => 'Completed', 'value' => '1,248', 'change' => '-2.4%', 'icon' => 'check-circle', 'color' => 'info'],
                            ['label' => 'Issues', 'value' => '3', 'change' => 'Stabilized', 'icon' => 'alert-circle', 'color' => 'warning'],
                        ];
                    @endphp
                    @foreach($stats as $stat)
                    <div class="col-xl-3 col-sm-6">
                        <div class="card border-0 shadow-sm rounded-xl overflow-hidden group">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="icon-shape bg-light-{{ $stat['color'] }} text-{{ $stat['color'] }} rounded-lg p-2">
                                        <i data-feather="{{ $stat['icon'] }}" class="icon-xs"></i>
                                    </div>
                                    <span class="small fw-bold {{ str_contains($stat['change'], '+') ? 'text-success' : (str_contains($stat['change'], '-') ? 'text-danger' : 'text-muted') }}">
                                        {{ $stat['change'] }}
                                    </span>
                                </div>
                                <h3 class="fw-bold mb-1 h2 font-heading">{{ $stat['value'] }}</h3>
                                <p class="text-muted small mb-0 fw-medium text-uppercase ls-wide">{{ $stat['label'] }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="row g-4">
                    <!-- Elegant Project List -->
                    <div class="col-xl-9 col-lg-8 col-12">
                        <div class="card border-0 shadow-sm rounded-xl overflow-hidden h-100">
                            <div class="card-header bg-white border-bottom py-4 px-5 d-flex justify-content-between align-items-center">
                                <h4 class="mb-0 fw-bold">Live Activity</h4>
                                <div class="dropdown">
                                    <button class="btn btn-ghost btn-sm btn-icon rounded-circle" data-bs-toggle="dropdown">
                                        <i data-feather="more-horizontal" class="icon-xs"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light-primary-subtle border-0">
                                        <tr>
                                            <th class="ps-5 py-3 border-0 small text-uppercase fw-bold text-muted ls-wide">Project Name</th>
                                            <th class="py-3 border-0 small text-uppercase fw-bold text-muted ls-wide">Phase</th>
                                            <th class="py-3 border-0 small text-uppercase fw-bold text-muted ls-wide">Ownership</th>
                                            <th class="pe-5 text-end border-0 small text-uppercase fw-bold text-muted ls-wide">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-top-0">
                                        @php
                                            $projects = [
                                                ['name' => 'Design System 2.0', 'cat' => 'Infrastructure', 'phase' => 'Execution', 'user' => 'JD', 'status' => 'On Track', 'color' => 'success'],
                                                ['name' => 'API Integration', 'cat' => 'Backend', 'phase' => 'UAT', 'user' => 'AM', 'status' => 'Pending', 'color' => 'warning'],
                                                ['name' => 'User Feedback Bot', 'cat' => 'AI', 'phase' => 'Discovery', 'user' => 'RW', 'status' => 'Delayed', 'color' => 'danger'],
                                                ['name' => 'Cloud Migration', 'cat' => 'DevOps', 'phase' => 'Testing', 'user' => 'SL', 'status' => 'Active', 'color' => 'primary'],
                                            ];
                                        @endphp
                                        @foreach($projects as $p)
                                        <tr>
                                            <td class="ps-5 py-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-light me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; border: 1px solid var(--border-color);">
                                                        <i data-feather="folder" class="text-muted icon-xxs"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1 fw-bold">{{ $p['name'] }}</h6>
                                                        <span class="small text-muted">{{ $p['cat'] }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4">
                                                <span class="small fw-bold text-dark">{{ $p['phase'] }}</span>
                                            </td>
                                            <td class="py-4">
                                                <div class="avatar avatar-xs rounded-circle bg-soft-primary text-primary d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 10px; border: 1px solid var(--primary-light);">
                                                    {{ $p['user'] }}
                                                </div>
                                            </td>
                                            <td class="pe-5 text-end py-4">
                                                <span class="badge rounded-pill bg-light-{{ $p['color'] }} text-{{ $p['color'] }} border-0 px-3 py-2 small fw-bold">
                                                    <i class="bi bi-circle-fill me-1" style="font-size: 6px;"></i> {{ $p['status'] }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Right Panel: Smart Alerts -->
                    <div class="col-xl-3 col-lg-4 col-12">
                        <div class="card border-0 shadow-sm rounded-xl overflow-hidden mb-4">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4">Quick Insights</h5>
                                <div class="p-3 bg-light-primary rounded-lg border-0 mb-3">
                                    <h6 class="fw-bold text-primary small mb-2"><i data-feather="zap" class="icon-xxs me-1"></i> Performance Tip</h6>
                                    <p class="small text-muted mb-0">Optimize your media assets to improve page load speed by roughly 12%.</p>
                                </div>
                                <div class="p-3 bg-light border-0 rounded-lg">
                                    <h6 class="fw-bold text-muted small mb-2"><i data-feather="clock" class="icon-xxs me-1"></i> System Update</h6>
                                    <p class="small text-muted mb-0">Database maintenance is scheduled for Sunday at 02:00 UTC.</p>
                                </div>
                            </div>
                        </div>

                        <div class="card bg-primary border-0 rounded-xl p-4 position-relative" style="overflow: hidden;">
                             <div class="position-relative" style="z-index: 2;">
                                 <h4 class="fw-bold mb-2" style="color: #0f172a; font-size: 1.15rem; line-height: 1.4;">Professional Support</h4>
                                 <p class="small mb-4" style="color: #334155; line-height: 1.6;">Unlock premium features and direct support from our dev team.</p>
                                 <button class="btn btn-sm rounded-pill px-4 fw-bold" style="background: #ffffff; color: var(--primary);">Upgrade Now</button>
                             </div>
                             <div class="position-absolute" style="bottom: -20px; right: -20px; z-index: 1; opacity: 0.1; pointer-events: none;">
                                 <i data-feather="award" style="width: 130px; height: 130px; transform: rotate(-15deg); display: block;"></i>
                             </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection
