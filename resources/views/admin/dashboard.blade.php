<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - Collection Store</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- GOOGLE WEB FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom Admin CSS -->
    <style>
        :root {
            /* Dark Mode Professional - Sophisticated & Dark Theme */
            --primary-color: #3b82f6;
            --primary-hover: #2563eb;
            --secondary-color: #1e40af;
            --accent-color: #06b6d4;
            --accent-hover: #0891b2;
            
            --success-color: #10b981;
            --success-hover: #059669;
            --warning-color: #f59e0b;
            --warning-hover: #d97706;
            --danger-color: #ef4444;
            --danger-hover: #dc2626;
            --info-color: #06b6d4;
            --info-hover: #0891b2;
            
            /* Dark Theme Background Colors */
            --bg-primary: #0f172a;        /* Very dark blue-gray */
            --bg-secondary: #1e293b;      /* Dark slate */
            --bg-tertiary: #334155;       /* Medium slate */
            --bg-card: #1e293b;           /* Card background */
            --bg-card-hover: #334155;     /* Card hover */
            
            /* Dark Theme Text Colors */
            --text-primary: #f1f5f9;      /* Light gray */
            --text-secondary: #cbd5e1;    /* Medium gray */
            --text-muted: #94a3b8;        /* Muted gray */
            --text-inverse: #0f172a;      /* Dark text for light backgrounds */
            
            /* Dark Theme Border & Accent Colors */
            --border-color: #475569;      /* Slate border */
            --border-light: #334155;      /* Light border */
            --border-accent: #3b82f6;     /* Accent border */
            
            /* Dark Theme Shadows & Glows */
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.4);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.5);
            --glow: 0 0 20px rgba(59, 130, 246, 0.3);
            --glow-hover: 0 0 30px rgba(59, 130, 246, 0.5);
            
            /* Typography Variables */
            --font-primary: 'Inter', 'Roboto', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            --text-xs: 0.75rem;    /* 12px */
            --text-sm: 0.875rem;   /* 14px */
            --text-base: 1rem;     /* 16px */
            --text-lg: 1.125rem;   /* 18px */
            --text-xl: 1.25rem;    /* 20px */
            --text-2xl: 1.5rem;    /* 24px */
            --font-medium: 500;
            --font-semibold: 600;
            --leading-normal: 1.5;
            
            /* Layout & Spacing Variables */
            --space-1: 0.25rem;    /* 4px */
            --space-2: 0.5rem;     /* 8px */
            --space-3: 0.75rem;    /* 12px */
            --space-4: 1rem;       /* 16px */
            --space-5: 1.25rem;    /* 20px */
            --space-6: 1.5rem;     /* 24px */
            --space-8: 2rem;       /* 32px */
            
            /* Layout Dimensions */
            --button-border-radius: 8px;
        }

        body {
            background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
            color: var(--text-primary);
            font-family: var(--font-primary);
            min-height: 100vh;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            background: var(--bg-secondary);
            border-right: 2px solid var(--border-accent);
            box-shadow: var(--shadow-xl);
            z-index: 1000;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .sidebar .logo {
            padding: var(--space-8) var(--space-6);
            text-align: center;
            border-bottom: 2px solid var(--border-accent);
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            flex-shrink: 0;
        }
        
        .sidebar .logo h4 {
            color: var(--text-primary);
            margin: var(--space-3) 0 0 0;
            font-weight: var(--font-semibold);
            font-size: var(--text-lg);
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .sidebar .logo img {
            max-width: 120px;
            filter: brightness(0) invert(1);
        }
        .sidebar .nav-links {
            padding: var(--space-8) 0;
            flex: 1;
            overflow-y: auto;
        }

        .sidebar .nav-links li {
            list-style: none;
            margin-bottom: var(--space-1);
        }

        .sidebar .nav-links li a {
            display: flex;
            align-items: center;
            padding: var(--space-4) var(--space-6);
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: var(--font-medium);
            font-size: var(--text-sm);
            line-height: var(--leading-normal);
            border-radius: 0 var(--space-6) var(--space-6) 0;
            margin-right: var(--space-4);
            position: relative;
            overflow: hidden;
        }

        .sidebar .nav-links li a:hover,
        .sidebar .nav-links li a.active {
            background: var(--bg-tertiary);
            color: var(--text-primary);
            transform: translateX(8px);
            box-shadow: var(--glow);
            border-left: 3px solid var(--primary-color);
        }
        
        .sidebar .nav-links li a.active {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            color: var(--text-primary);
            box-shadow: var(--glow-hover);
        }
        
        /* Navigation Section Titles */
        .sidebar .nav-links .nav-section-title {
            color: var(--text-muted);
            font-size: var(--text-xs);
            font-weight: var(--font-bold);
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: var(--space-4) var(--space-6);
            margin-top: var(--space-6);
            border-bottom: 1px solid var(--border-light);
            list-style: none;
        }
        
        .sidebar .nav-links .nav-section-title:first-of-type {
            margin-top: var(--space-2);
        }
        
        /* Navigation Icons */
        .sidebar .nav-links li a .icon {
            margin-right: var(--space-3);
            font-size: var(--text-lg);
            width: var(--space-5);
            text-align: center;
            flex-shrink: 0;
        }

        .main-content {
            margin-left: 280px;
            padding: 0;
            min-height: 100vh;
            background: var(--bg-primary);
            display: flex;
            flex-direction: column;
        }

        .top-navbar {
            background: var(--bg-secondary);
            padding: var(--space-6) var(--space-8);
            border-bottom: 2px solid var(--border-accent);
            box-shadow: var(--shadow-lg);
            position: sticky;
            top: 0;
            z-index: 100;
            flex-shrink: 0;
        }

        .top-navbar h4 {
            color: var(--text-primary);
            font-weight: var(--font-semibold);
            font-size: var(--text-2xl);
            margin: 0;
        }

        .stats-card {
            background: var(--bg-card);
            border-radius: 12px;
            padding: var(--space-8);
            margin-bottom: var(--space-6);
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .stats-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--glow-hover);
            border-color: var(--border-accent);
            background: var(--bg-card-hover);
        }

        .stats-card .icon {
            font-size: 3rem;
            margin-bottom: var(--space-4);
            color: var(--primary-color);
        }

        .stats-card .number {
            font-size: 2.25rem;
            font-weight: var(--font-semibold);
            margin-bottom: var(--space-2);
            color: var(--text-primary);
        }

        .stats-card .label {
            font-size: var(--text-base);
            color: var(--text-secondary);
            font-weight: var(--font-medium);
        }

        .welcome-card, .info-card {
            background: var(--bg-card);
            border-radius: 12px;
            padding: var(--space-8);
            margin-bottom: var(--space-8);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-lg);
            position: relative;
            transition: all 0.3s ease;
        }
        
        .welcome-card:hover, .info-card:hover {
            box-shadow: var(--glow);
            border-color: var(--border-accent);
            transform: translateY(-2px);
        }

        .welcome-card h2, .info-card h3 {
            color: var(--text-primary);
            font-weight: var(--font-semibold);
            margin-bottom: var(--space-4);
        }

        .welcome-card p {
            color: var(--text-secondary);
            margin: 0;
        }

        .content-area {
            padding: var(--space-8);
            flex: 1;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        /* Navigation Section Titles */
        .sidebar .nav-links .nav-section-title {
            color: var(--text-muted);
            font-size: var(--text-xs);
            font-weight: var(--font-semibold);
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: var(--space-4) var(--space-6);
            margin-top: var(--space-6);
            border-bottom: 1px solid var(--border-light);
            list-style: none;
        }
        
        .sidebar .nav-links .nav-section-title:first-of-type {
            margin-top: var(--space-2);
        }

        /* Button Styling - Dark Theme Professional */
        .btn, button, input[type="submit"], input[type="button"] {
            padding: var(--space-3) var(--space-5);
            border-radius: var(--button-border-radius);
            font-family: var(--font-primary);
            font-weight: var(--font-medium);
            font-size: var(--text-sm);
            line-height: var(--leading-normal);
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-2);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        /* Primary Button */
        .btn-primary, .btn.btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            color: var(--text-primary);
            box-shadow: var(--shadow-lg);
        }

        .btn-primary:hover, .btn.btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-hover) 0%, var(--accent-hover) 100%);
            color: var(--text-primary);
            transform: translateY(-2px);
            box-shadow: var(--glow-hover);
        }

        /* Success Button */
        .btn-success, .btn.btn-success {
            background: linear-gradient(135deg, var(--success-color) 0%, var(--success-hover) 100%);
            color: var(--text-primary);
            box-shadow: var(--shadow-lg);
        }

        .btn-success:hover, .btn.btn-success:hover {
            background: linear-gradient(135deg, var(--success-hover) 0%, #047857 100%);
            color: var(--text-primary);
            transform: translateY(-2px);
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.4);
        }

        /* Warning Button */
        .btn-warning, .btn.btn-warning {
            background: linear-gradient(135deg, var(--warning-color) 0%, var(--warning-hover) 100%);
            color: var(--text-inverse);
            box-shadow: var(--shadow-lg);
        }

        .btn-warning:hover, .btn.btn-warning:hover {
            background: linear-gradient(135deg, var(--warning-hover) 0%, #b45309 100%);
            color: var(--text-inverse);
            transform: translateY(-2px);
            box-shadow: 0 0 20px rgba(245, 158, 11, 0.4);
        }

        /* Info Button */
        .btn-info, .btn.btn-info {
            background: linear-gradient(135deg, var(--info-color) 0%, var(--info-hover) 100%);
            color: var(--text-primary);
            box-shadow: var(--shadow-lg);
        }

        .btn-info:hover, .btn.btn-info:hover {
            background: linear-gradient(135deg, var(--info-hover) 0%, #0e7490 100%);
            color: var(--text-primary);
            transform: translateY(-2px);
            box-shadow: 0 0 20px rgba(6, 182, 212, 0.4);
        }

        /* Danger/Logout Button */
        .btn-danger, .btn-logout, .btn.btn-danger {
            background: linear-gradient(135deg, var(--danger-color) 0%, var(--danger-hover) 100%);
            color: var(--text-primary);
            box-shadow: var(--shadow-lg);
        }

        .btn-danger:hover, .btn-logout:hover, .btn.btn-danger:hover {
            background: linear-gradient(135deg, var(--danger-hover) 0%, #b91c1c 100%);
            color: var(--text-primary);
            transform: translateY(-2px);
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.4);
        }

        /* Secondary Button */
        .btn-secondary, .btn.btn-secondary {
            background: var(--bg-tertiary);
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow);
        }

        .btn-secondary:hover, .btn.btn-secondary:hover {
            background: var(--bg-card-hover);
            color: var(--text-primary);
            border-color: var(--border-accent);
            transform: translateY(-2px);
            box-shadow: var(--glow);
        }

        /* Outline Buttons */
        .btn-outline-primary {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: var(--text-primary);
            box-shadow: var(--glow);
        }

        /* Button Sizes */
        .btn-sm {
            padding: var(--space-2) var(--space-4);
            font-size: var(--text-xs);
        }

        .btn-lg {
            padding: var(--space-4) var(--space-8);
            font-size: var(--text-lg);
        }

        /* Disabled Button */
        .btn:disabled, .btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
            box-shadow: none !important;
        }

        /* Bootstrap Button Overrides for Dark Theme */
        .btn.w-100 {
            width: 100% !important;
        }

        .btn.mb-2 {
            margin-bottom: var(--space-2) !important;
        }

        /* Focus States */
        .btn:focus, .btn:focus-visible {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
            box-shadow: var(--glow);
        }

        /* Active States */
        .btn:active, .btn.active {
            transform: translateY(0) !important;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* Button Text Colors Override */
        .btn-primary, .btn-success, .btn-info, .btn-danger, .btn-logout {
            color: var(--text-primary) !important;
        }

        .btn-warning {
            color: var(--text-inverse) !important;
        }

        .btn-secondary {
            color: var(--text-secondary) !important;
        }

        .btn-secondary:hover {
            color: var(--text-primary) !important;
        }

        .alert {
            border-radius: 10px;
            border: none;
        }

        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <img src="{{ asset('img/logo.svg') }}" alt="Collection Store">
            <h4>Collection Store</h4>
        </div>
        <ul class="nav-links">
            <li><a href="{{ route('admin.dashboard') }}" class="active">
                <span class="icon">📊</span>
                <span>Dashboard</span>
            </a></li>
            
            <!-- CATALOG MANAGEMENT -->
            <li class="nav-section-title">CATALOG</li>
            <li><a href="#">
                <span class="icon">📂</span>
                <span>Categories</span>
            </a></li>
            <li><a href="#">
                <span class="icon">🏷️</span>
                <span>Brands</span>
            </a></li>
            <li><a href="{{route('admin.product')}}">
                <span class="icon">🛍️</span>
                <span>Products</span>
            </a></li>
            <li><a href="#">
                <span class="icon">🔧</span>
                <span>Attributes</span>
            </a></li>
            <li><a href="#">
                <span class="icon">📝</span>
                <span>Attribute Values</span>
            </a></li>
            <li><a href="#">
                <span class="icon">🔗</span>
                <span>Product Attributes</span>
            </a></li>
            <li><a href="#">
                <span class="icon">⭐</span>
                <span>Reviews</span>
            </a></li>
            
            <!-- CONTENT MANAGEMENT -->
            <li class="nav-section-title">CONTENT</li>
            <li><a href="#">
                <span class="icon">🖼️</span>
                <span>Sliders</span>
            </a></li>
            
            <!-- ORDER MANAGEMENT -->
            <li class="nav-section-title">ORDERS</li>
            <li><a href="#">
                <span class="icon">📦</span>
                <span>Orders</span>
            </a></li>
            <li><a href="#">
                <span class="icon">📋</span>
                <span>Order Items</span>
            </a></li>
            
            <!-- INVENTORY MANAGEMENT -->
            <li class="nav-section-title">INVENTORY</li>
            <li><a href="#">
                <span class="icon">🏪</span>
                <span>Warehouses</span>
            </a></li>
            <li><a href="#">
                <span class="icon">📊</span>
                <span>Inventory</span>
            </a></li>
            
            <!-- FINANCIAL -->
            <li class="nav-section-title">FINANCIAL</li>
            <li><a href="#">
                <span class="icon">💳</span>
                <span>Transactions</span>
            </a></li>
            
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">

        <!-- Top Navbar -->
        <div class="top-navbar main-content-inner d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Admin Dashboard</h4>
            <div class="d-flex align-items-center">
                <span class="me-3">Welcome, {{ auth()->user()->name }}!</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            </div>
        </div>

        <!-- Alerts -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

      @yield('content')
    </div>

    <!-- Bootstrap JS -->
      <script src="{{ asset('jsd/jquery.min.js') }}"></script>
    <script src="{{ asset('jsd/bootstrap.min.js') }}"></script>
    <script src="{{ asset('jsd/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('jsd/sweetalert.min.js') }}"></script>
    <script src="{{ asset('jsd/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('jsd/main.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <script>
        // Auto dismiss alerts after 5 seconds
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>

</html>
