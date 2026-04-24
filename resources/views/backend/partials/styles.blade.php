<link rel="stylesheet" href="{{asset('assets/backend/libs/bootstrap-icons/font/bootstrap-icons.css')}}">
<link rel="stylesheet" href="{{asset('assets/backend/css/theme.min.css')}}">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap');

    :root {
        --primary: #4f46e5;
        --primary-dark: #3730a3;
        --primary-light: #f5f3ff;
        --secondary: #64748b;
        --accent: #f59e0b;
        --danger: #ef4444;
        --success: #10b981;
        --background: #f8fafc;
        --card-bg: #ffffff;
        --sidebar-bg: #ffffff;
        --text-main: #0f172a;
        --text-muted: #64748b;
        --border-color: #f1f5f9;
        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 16px;
        --radius-xl: 24px;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05), 0 2px 4px -2px rgb(0 0 0 / 0.05);
        --shadow-elevated: 0 10px 15px -3px rgb(0 0 0 / 0.04), 0 4px 6px -4px rgb(0 0 0 / 0.04);
        --shadow-lg: 0 20px 25px -5px rgb(0 0 0 / 0.08), 0 8px 10px -6px rgb(0 0 0 / 0.08);
        --glass-bg: rgba(255, 255, 255, 0.9);
        --glass-border: rgba(255, 255, 255, 0.6);
    }

    body {
        font-family: 'Inter', sans-serif !important;
        background-color: var(--background);
        color: var(--text-main);
        -webkit-font-smoothing: antialiased;
        letter-spacing: -0.011em;
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        font-weight: 700 !important;
        letter-spacing: -0.022em !important;
        line-height: 1.3 !important;
    }

    /* Layout Structure */
    .main-wrapper {
        display: flex;
        width: 100%;
        min-height: 100vh;
    }

    #db-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-width: 0;
        background-color: var(--background);
        margin-left: 260px;
        transition: all 0.3s ease;
    }

    .navbar-vertical {
        width: 260px !important;
        height: 100vh !important;
        position: fixed !important;
        top: 0;
        left: 0;
        z-index: 1000;
        background-color: var(--sidebar-bg) !important;
        border-right: 1px solid var(--border-color) !important;
        overflow-y: auto;
    }

    .header {
        position: sticky;
        top: 0;
        z-index: 999;
        background-color: #ffffff !important;
        border-bottom: 1px solid var(--border-color) !important;
        padding: 0.5rem 0;
    }

    /* Auth Pages Styles */
    .auth-wrapper {
        min-height: 100vh;
        background: radial-gradient(circle at 10% 20%, rgba(79, 101, 229, 0.04) 0%, rgba(139, 92, 246, 0.02) 90.2%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .auth-card {
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border) !important;
        border-radius: var(--radius-xl) !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1) !important;
        animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Form Elements */
    .form-label {
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #334155;
    }

    .form-control {
        border-radius: var(--radius-md) !important;
        padding: 0.75rem 1rem !important;
        border: 1px solid #e2e8f0 !important;
        background-color: #f8fafc !important;
        font-size: 0.95rem;
        transition: all 0.2s ease !important;
    }

    .form-control:focus {
        border-color: var(--primary) !important;
        background-color: #ffffff !important;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1) !important;
    }

    /* Custom Checkbox */
    .custom-checkbox .form-check-input {
        width: 1.15em;
        height: 1.15em;
        margin-top: 0.2em;
        border-radius: 4px;
        border: 2px solid #cbd5e1;
    }

    .custom-checkbox .form-check-input:checked {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .custom-checkbox .form-check-label {
        padding-left: 0.25rem;
        cursor: pointer;
        user-select: none;
    }

    /* Navigation */
    .nav-link {
        border-radius: var(--radius-md) !important;
        margin: 4px 20px !important;
        padding: 12px 16px !important;
        color: #64748b !important;
        font-weight: 500 !important;
        font-family: 'Plus Jakarta Sans', sans-serif;
        transition: all 0.2s ease !important;
        font-size: 0.925rem;
    }

    .nav-link:hover {
        background-color: #f1f5f9 !important;
        color: var(--primary) !important;
    }

    .nav-link.active {
        background-color: var(--primary-light) !important;
        color: var(--primary) !important;
        font-weight: 700 !important;
    }

    /* Cards */
    .card {
        background: #ffffff !important;
        border-radius: var(--radius-lg) !important;
        border: 1px solid rgba(0,0,0,0.03) !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.02) !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    .card:hover {
        box-shadow: 0 12px 30px rgba(0,0,0,0.04) !important;
        transform: translateY(-2px);
    }

    .btn-modern-primary {
        background: var(--primary) !important;
        color: white !important;
        border: none !important;
        border-radius: var(--radius-md) !important;
        padding: 0.8rem 1.5rem !important;
        font-weight: 600 !important;
        box-shadow: 0 4px 14px rgba(79, 70, 229, 0.4) !important;
        transition: all 0.3s ease !important;
    }

    .btn-modern-primary:hover {
        background: var(--primary-dark) !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 6px 20px rgba(79, 70, 229, 0.5) !important;
    }

    /* Helper Classes */
    .bg-light-primary { background-color: rgba(79, 70, 229, 0.1) !important; color: var(--primary) !important; }
    .bg-light-success { background-color: rgba(16, 185, 129, 0.1) !important; color: var(--success) !important; }
    .bg-light-info { background-color: rgba(6, 182, 212, 0.1) !important; color: var(--info) !important; }
    .bg-light-warning { background-color: rgba(245, 158, 11, 0.1) !important; color: var(--accent) !important; }
    .bg-light-danger { background-color: rgba(239, 68, 68, 0.1) !important; color: var(--danger) !important; }
    .bg-primary-light { background-color: var(--primary-light) !important; }

    .rounded-xl { border-radius: 1.25rem !important; }
    .rounded-lg { border-radius: 0.75rem !important; }
    
    .ls-wide { letter-spacing: 0.025em !important; }
    
    .icon-shape {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        vertical-align: middle;
    }
    
    .icon-xs { width: 1.25rem; height: 1.25rem; }
    .icon-xxs { width: 1rem; height: 1rem; }

    /* Fix Content Overlap & Spacing */
    #db-wrapper {
        min-height: 100vh;
        width: 100%;
        margin-left: 260px;
        transition: margin-left 0.3s ease-in-out;
    }

    #app-content {
        padding: 0;
        min-height: calc(100vh - 64px);
        margin-left: 0 !important;
    }

    .app-content-area {
        width: 100%;
    }

    @media (max-width: 991.98px) {
        #db-wrapper {
            margin-left: 0 !important;
        }
        .navbar-vertical {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }
        .navbar-vertical.show {
            transform: translateX(0);
        }
    }
</style>
