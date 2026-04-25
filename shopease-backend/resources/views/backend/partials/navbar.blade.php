<div class="navbar-vertical navbar-custom nav-dashboard px-3">
    <div class="h-100" data-simplebar>
            <!-- Brand logo -->
            <div class="mb-5 mt-4 px-3 d-flex align-items-center">
                <div class="bg-primary rounded-3 p-2 me-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 35px; height: 35px;">
                    <i data-feather="grid" class="text-white icon-xs"></i>
                </div>
                <h4 class="mb-0 fw-bold tracking-tight" style="color: var(--text-main);">Dashboard</h4>
            </div>

            <!-- Navbar nav -->
            <ul class="navbar-nav flex-column" id="sideNavbar">
                <li class="nav-item">
                    <p class="nav-label small text-muted text-uppercase fw-bold mb-2 px-3 opacity-50" style="font-size: 0.7rem; letter-spacing: 0.1em;">General</p>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{Route::is('dashboard') ? 'active': ''}}" href="{{route('dashboard')}}">
                        <i data-feather="home" class="nav-icon me-2 icon-xxs"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="nav-item mt-4">
                    <p class="nav-label small text-muted text-uppercase fw-bold mb-2 px-3 opacity-50" style="font-size: 0.7rem; letter-spacing: 0.1em;">Manage dirty data</p>
                </li>

             
                
             
            </ul>
        </div>
    </div>
