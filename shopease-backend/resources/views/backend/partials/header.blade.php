<div class="header">
    <nav class="navbar-custom navbar navbar-expand-lg">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center">
                <a id="nav-toggle" href="#!" class="btn btn-ghost btn-icon rounded-circle me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                    </svg>
                </a>

                <div class="d-none d-md-block">
                    <form action="#" class="ms-2">
                        <div class="input-group input-group-merge shadow-none border-0 bg-light rounded-pill px-3 py-1" style="width: 300px;">
                            <span class="input-group-text bg-transparent border-0 pe-2">
                                <i data-feather="search" class="icon-xs text-muted"></i>
                            </span>
                            <input class="form-control bg-transparent border-0 shadow-none ps-0 py-1" type="search" placeholder="Search resources..." aria-label="Search">
                        </div>
                    </form>
                </div>
            </div>

            <ul class="navbar-nav navbar-right-wrap ms-auto d-flex nav-top-wrap align-items-center">
                <!-- Theme Switcher -->
                <li class="nav-item">
                    <div class="form-check form-switch theme-switch btn btn-ghost btn-icon rounded-circle mb-0">
                        <input class="form-check-input d-none" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                        <label class="form-check-label mb-0" for="flexSwitchCheckDefault">
                            <i data-feather="moon" class="icon-xs"></i>
                        </label>
                    </div>
                </li>

                <!-- User Dropdown -->
                <li class="dropdown ms-3">
                    <a class="avatar-dropdown-toggle" href="#!" role="button" id="dropdownUser" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar avatar-md avatar-indicators avatar-online">
                            @php
                                $user = auth()->user();
                                $firstName = $user->first_name ?? 'U';
                                $initial = strtoupper(substr($firstName, 0, 1));
                                $colors = ['primary', 'success', 'info', 'warning', 'danger'];
                                $colorIndex = ord($initial) % count($colors);
                                $bgColor = $colors[$colorIndex];
                            @endphp
                            <div class="rounded-circle bg-{{ $bgColor }} text-white d-flex align-items-center justify-content-center border border-2 border-white shadow-sm"
                                 style="width: 38px; height: 38px; font-weight: 700; font-size: 15px;">
                                {{ $initial }}
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2 p-2 rounded-lg" style="min-width: 220px;" aria-labelledby="dropdownUser">
                        <div class="px-3 py-3 border-bottom-0">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm rounded-circle bg-light-{{ $bgColor }} text-{{ $bgColor }} d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; font-weight: 700;">
                                    {{ $initial }}
                                </div>
                                <div class="lh-1">
                                    <h6 class="mb-0 fw-bold">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h6>
                                    <p class="mb-0 small text-muted mt-1">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider opacity-50"></div>
                        <a class="dropdown-item d-flex align-items-center rounded-sm py-2" href="#!">
                            <i class="me-2 icon-xxs" data-feather="user"></i>
                            <span>My Profile</span>
                        </a>
                        <a class="dropdown-item d-flex align-items-center rounded-sm py-2" href="#!">
                            <i class="me-2 icon-xxs" data-feather="settings"></i>
                            <span>Account Settings</span>
                        </a>
                        <div class="dropdown-divider opacity-50"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center rounded-sm py-2 text-danger">
                                <i class="me-2 icon-xxs text-danger" data-feather="power"></i>
                                <span>Sign Out</span>
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>

