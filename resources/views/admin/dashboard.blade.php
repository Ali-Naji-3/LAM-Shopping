<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - Collection Store</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
    
    <!-- GOOGLE WEB FONT - Professional Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    
    <!-- Custom Admin CSS - Professional Corporate Theme -->
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
            
            /* Typography Variables - Clean & Authoritative */
            --font-primary: 'Inter', 'Roboto', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            --font-secondary: 'Roboto', sans-serif;
            
            /* Font Sizes - Harmonious Scale */
            --text-xs: 0.75rem;    /* 12px */
            --text-sm: 0.875rem;   /* 14px */
            --text-base: 1rem;     /* 16px */
            --text-lg: 1.125rem;   /* 18px */
            --text-xl: 1.25rem;    /* 20px */
            --text-2xl: 1.5rem;    /* 24px */
            --text-3xl: 1.875rem;  /* 30px */
            --text-4xl: 2.25rem;   /* 36px */
            
            /* Font Weights - Professional Hierarchy */
            --font-light: 300;
            --font-normal: 400;
            --font-medium: 500;
            --font-semibold: 600;
            --font-bold: 700;
            
            /* Line Heights - Comfortable Reading */
            --leading-tight: 1.25;
            --leading-normal: 1.5;
            --leading-relaxed: 1.625;
            
            /* Layout & Spacing Variables - Structured & Spacious */
            --space-1: 0.25rem;    /* 4px */
            --space-2: 0.5rem;     /* 8px */
            --space-3: 0.75rem;    /* 12px */
            --space-4: 1rem;       /* 16px */
            --space-5: 1.25rem;    /* 20px */
            --space-6: 1.5rem;     /* 24px */
            --space-8: 2rem;       /* 32px */
            --space-10: 2.5rem;    /* 40px */
            --space-12: 3rem;      /* 48px */
            --space-16: 4rem;      /* 64px */
            --space-20: 5rem;      /* 80px */
            
            /* Layout Dimensions */
            --sidebar-width: 280px;
            --content-max-width: 1200px;
            --card-border-radius: 12px;
            --button-border-radius: 8px;
            
            /* Container Spacing */
            --container-padding: var(--space-8);
            --section-spacing: var(--space-12);
            --card-padding: var(--space-8);
            --grid-gap: var(--space-6);
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
            color: var(--text-primary);
            font-family: var(--font-primary);
            font-size: var(--text-base);
            line-height: var(--leading-normal);
            font-weight: var(--font-normal);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            min-height: 100vh;
        }

        /* Typography Hierarchy - Clean & Authoritative */
        h1, .h1 {
            font-size: var(--text-4xl);
            font-weight: var(--font-bold);
            line-height: var(--leading-tight);
            color: var(--text-primary);
            margin-bottom: 1rem;
            letter-spacing: -0.025em;
        }

        h2, .h2 {
            font-size: var(--text-3xl);
            font-weight: var(--font-semibold);
            line-height: var(--leading-tight);
            color: var(--text-primary);
            margin-bottom: 0.875rem;
            letter-spacing: -0.025em;
        }

        h3, .h3 {
            font-size: var(--text-2xl);
            font-weight: var(--font-semibold);
            line-height: var(--leading-tight);
            color: var(--text-primary);
            margin-bottom: 0.75rem;
        }

        h4, .h4 {
            font-size: var(--text-xl);
            font-weight: var(--font-medium);
            line-height: var(--leading-normal);
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        h5, .h5 {
            font-size: var(--text-lg);
            font-weight: var(--font-medium);
            line-height: var(--leading-normal);
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        h6, .h6 {
            font-size: var(--text-base);
            font-weight: var(--font-medium);
            line-height: var(--leading-normal);
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        p, .text-body {
            font-size: var(--text-base);
            font-weight: var(--font-normal);
            line-height: var(--leading-relaxed);
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .text-small {
            font-size: var(--text-sm);
            line-height: var(--leading-normal);
        }

        .text-large {
            font-size: var(--text-lg);
            line-height: var(--leading-normal);
        }

        .text-muted {
            color: var(--text-secondary);
        }

        .text-bold {
            font-weight: var(--font-semibold);
        }

        .text-light {
            font-weight: var(--font-light);
        }

        /* Layout Grid System - Structured & Spacious */
        .dashboard-grid {
            display: grid;
            gap: var(--grid-gap);
            margin-bottom: var(--section-spacing);
        }

        .dashboard-section {
            margin-bottom: var(--section-spacing);
        }

        .dashboard-section:last-child {
            margin-bottom: 0;
        }

        /* Responsive Grid for Stats Cards */
        @media (min-width: 768px) {
            .stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: var(--grid-gap);
            }
            
            .stats-grid .col-lg-4,
            .stats-grid .col-md-6 {
                margin-bottom: 0;
            }
        }

        /* Button Improvements */
        .btn {
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
        }

        /* User Info Section */
        .user-info {
            display: flex;
            align-items: center;
            gap: var(--space-4);
        }

        .user-info span {
            font-size: var(--text-sm);
            color: var(--text-secondary);
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--bg-secondary);
            border-right: 2px solid var(--border-accent);
            box-shadow: var(--shadow-xl);
            z-index: 1000;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            backdrop-filter: blur(10px);
        }
        
        .sidebar .logo {
            padding: var(--space-8) var(--space-6);
            text-align: center;
            border-bottom: 2px solid var(--border-accent);
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
        }
        
        .sidebar .logo::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s;
        }
        
        .sidebar .logo:hover::before {
            left: 100%;
        }
        
        .sidebar .logo img {
            max-width: 140px;
            filter: brightness(0) invert(1);
        }
        
        .sidebar .logo h4 {
            color: var(--text-primary);
            margin: var(--space-3) 0 0 0;
            font-weight: var(--font-semibold);
            font-size: var(--text-lg);
            line-height: var(--leading-tight);
            letter-spacing: -0.025em;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
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
        
        .sidebar .nav-links li a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: var(--primary-color);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }
        
        .sidebar .nav-links li a:hover,
        .sidebar .nav-links li a.active {
            background: var(--bg-tertiary);
            color: var(--text-primary);
            transform: translateX(8px);
            box-shadow: var(--glow);
            border-left: 3px solid var(--primary-color);
        }
        
        .sidebar .nav-links li a:hover::before,
        .sidebar .nav-links li a.active::before {
            transform: scaleY(1);
        }
        
        .sidebar .nav-links li a.active {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            color: var(--text-primary);
            box-shadow: var(--glow-hover);
        }

        .sidebar .nav-links li a .icon {
            margin-right: var(--space-3);
            font-size: var(--text-lg);
            width: var(--space-5);
            text-align: center;
            flex-shrink: 0;
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 0;
            min-height: 100vh;
            background: var(--bg-primary);
            display: flex;
            flex-direction: column;
        }
        
        .top-navbar {
            background: var(--bg-secondary);
            padding: var(--space-6) var(--container-padding);
            border-bottom: 2px solid var(--border-accent);
            box-shadow: var(--shadow-lg);
            position: sticky;
            top: 0;
            z-index: 100;
            flex-shrink: 0;
            backdrop-filter: blur(10px);
        }

        .top-navbar h4 {
            color: var(--text-primary);
            font-weight: var(--font-semibold);
            font-size: var(--text-2xl);
            line-height: var(--leading-tight);
            margin: 0;
            letter-spacing: -0.025em;
        }

        .content-area {
            padding: var(--container-padding);
            flex: 1;
            max-width: var(--content-max-width);
            margin: 0 auto;
            width: 100%;
        }
        
        .stats-card {
            background: var(--bg-card);
            border-radius: var(--card-border-radius);
            padding: var(--card-padding);
            margin-bottom: var(--grid-gap);
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
            backdrop-filter: blur(10px);
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        }
        
        .stats-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--glow-hover);
            border-color: var(--border-accent);
            background: var(--bg-card-hover);
        }
        
        .stats-card.users::before {
            background: linear-gradient(90deg, var(--success-color) 0%, #10b981 100%);
        }

        .stats-card.admins::before {
            background: linear-gradient(90deg, var(--warning-color) 0%, #f59e0b 100%);
        }

        .stats-card.total::before {
            background: linear-gradient(90deg, var(--info-color) 0%, #06b6d4 100%);
        }
        
        .stats-card .icon {
            font-size: 3rem;
            margin-bottom: 15px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stats-card.users .icon {
            background: linear-gradient(135deg, var(--success-color) 0%, #10b981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stats-card.admins .icon {
            background: linear-gradient(135deg, var(--warning-color) 0%, #f59e0b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stats-card.total .icon {
            background: linear-gradient(135deg, var(--info-color) 0%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .stats-card .number {
            font-size: var(--text-4xl);
            font-weight: var(--font-bold);
            line-height: var(--leading-tight);
            margin-bottom: 8px;
            color: var(--text-primary);
            letter-spacing: -0.025em;
        }
        
        .stats-card .label {
            font-size: var(--text-base);
            color: var(--text-secondary);
            font-weight: var(--font-medium);
            line-height: var(--leading-normal);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .welcome-card, .info-card {
            background: var(--bg-card);
            border-radius: var(--card-border-radius);
            padding: var(--card-padding);
            margin-bottom: var(--section-spacing);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-lg);
            position: relative;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .welcome-card:hover, .info-card:hover {
            box-shadow: var(--glow);
            border-color: var(--border-accent);
            transform: translateY(-2px);
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--accent-color) 100%);
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.5);
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
        
        .btn-logout {
            background: linear-gradient(135deg, var(--danger-color) 0%, var(--danger-hover) 100%);
            border: none;
            color: var(--text-primary);
            padding: var(--space-3) var(--space-5);
            border-radius: var(--button-border-radius);
            text-decoration: none;
            font-family: var(--font-primary);
            font-weight: var(--font-medium);
            font-size: var(--text-sm);
            line-height: var(--leading-normal);
            transition: all 0.3s ease;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }
        
        .btn-logout:hover {
            background: linear-gradient(135deg, var(--danger-hover) 0%, #b91c1c 100%);
            color: var(--text-primary);
            transform: translateY(-3px);
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.4);
        }

        .btn-primary, .btn-info, .btn-success, .btn-warning {
            border-radius: 8px;
            font-weight: 500;
            padding: 12px 20px;
            border: none;
            transition: all 0.3s ease;
            box-shadow: var(--shadow);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-info {
            background: linear-gradient(135deg, var(--info-color) 0%, #06b6d4 100%);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success-color) 0%, #10b981 100%);
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning-color) 0%, #f59e0b 100%);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .alert {
            border-radius: 12px;
            border: none;
            box-shadow: var(--shadow);
            font-weight: 500;
        }

        .user-info {
            display: flex;
            align-items: center;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .user-info strong {
            color: var(--primary-color);
        }
        
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -270px;
            }
            
            .main-content {
                margin-left: 0;
            }

            .content-area {
                padding: 20px;
            }

            .top-navbar {
                padding: 15px 20px;
            }
        }

        /* Smooth animations */
        * {
            transition: all 0.3s ease;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-secondary);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.3);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent-color);
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.5);
        }

        /* Skip to Content Accessibility */
        .skip-to-content {
            position: absolute;
            top: -40px;
            left: 6px;
            background: var(--primary-color);
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
            z-index: 9999;
            transition: top 0.3s ease;
            font-weight: 500;
            box-shadow: var(--shadow);
        }

        .skip-to-content:focus {
            top: 6px;
            color: white;
            text-decoration: none;
        }

        .skip-to-content:hover {
            background: var(--secondary-color);
            color: white;
        }
    </style>
</head>

<body>
    
    <!-- Skip to Content (Accessibility) -->
    <a href="#main-content" class="skip-to-content">Skip to Content</a>
    
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
            <li><a href="#users-section">
                <span class="icon">👥</span>
                <span>Users</span>
            </a></li>
            <li><a href="#products-section">
                <span class="icon">🛍️</span>
                <span>Products</span>
            </a></li>
            <li><a href="#orders-section">
                <span class="icon">📦</span>
                <span>Orders</span>
            </a></li>
            <li><a href="#analytics-section">
                <span class="icon">📈</span>
                <span>Analytics</span>
            </a></li>
            <li><a href="#system-info">
                <span class="icon">⚙️</span>
                <span>System Info</span>
            </a></li>
            <li><a href="{{ url('/') }}" target="_blank">
                <span class="icon">🏪</span>
                <span>View Store</span>
            </a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        
        <!-- Top Navbar -->
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Admin Dashboard</h4>
            <div class="d-flex align-items-center user-info">
                <span class="me-3">Welcome, <strong>{{ auth()->user()->name }}</strong>!</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area" id="main-content">

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

        <!-- Welcome Card -->
        <div class="welcome-card">
            <h2>🎉 Welcome to Collection Store Admin Dashboard!</h2>
            <p class="mb-0">You are logged in as <strong>{{ strtoupper(auth()->user()->u_type) }}</strong> - {{ auth()->user()->name }}</p>
        </div>

        <!-- Statistics Cards -->
        <div class="row" id="users-section">
            <div class="col-lg-4 col-md-6">
                <div class="stats-card users">
                    <div class="icon">👥</div>
                    <div class="number">{{ $stats['total_users'] }}</div>
                    <div class="label">Total Users</div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="stats-card admins">
                    <div class="icon">👨‍💼</div>
                    <div class="number">{{ $stats['total_admins'] }}</div>
                    <div class="label">Admins & Managers</div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="stats-card total">
                    <div class="icon">📊</div>
                    <div class="number">{{ $stats['total_all_users'] }}</div>
                    <div class="label">All Users</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row" id="products-section">
            <div class="col-12">
                <div class="info-card">
                    <h3>🚀 Quick Actions</h3>
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <a href="#" class="btn btn-primary w-100 mb-2">📦 Add Product</a>
                        </div>
                        <div class="col-md-3" id="orders-section">
                            <a href="#" class="btn btn-info w-100 mb-2">📋 View Orders</a>
                        </div>
                        <div class="col-md-3" id="analytics-section">
                            <a href="#" class="btn btn-success w-100 mb-2">📈 Analytics</a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ url('/') }}" class="btn btn-warning w-100 mb-2" target="_blank">🏪 View Store</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Database ERD -->
        <div class="row" id="database-erd">
            <div class="col-12">
                <div class="info-card">
                    <h3>🗄️ Database Entity Relationship Diagram</h3>
                    <p class="text-muted mb-4">Visual representation of the e-commerce database structure with relationships</p>
                    
                    <div class="erd-container" style="overflow-x: auto; background: #f8f9fa; border-radius: 10px; padding: 20px;">
                        <div class="erd-diagram" style="min-width: 1200px; position: relative;">
                            
                            <!-- Users Table -->
                            <div class="erd-table" style="position: absolute; top: 20px; left: 50px; background: #fff; border: 2px solid #2563eb; border-radius: 8px; padding: 15px; min-width: 180px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                <div class="erd-table-header" style="background: #2563eb; color: white; padding: 8px; margin: -15px -15px 10px -15px; border-radius: 6px 6px 0 0; font-weight: bold;">
                                    👤 Users
                                </div>
                                <div class="erd-fields" style="font-size: 12px; line-height: 1.4;">
                                    <div><strong>id</strong> - PK</div>
                                    <div>name</div>
                                    <div>email</div>
                                    <div>mobile</div>
                                    <div>password</div>
                                    <div>u_type</div>
                                    <div>email_verified_at</div>
                                </div>
                            </div>

                            <!-- Categories Table -->
                            <div class="erd-table" style="position: absolute; top: 20px; left: 280px; background: #fff; border: 2px solid #059669; border-radius: 8px; padding: 15px; min-width: 180px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                <div class="erd-table-header" style="background: #059669; color: white; padding: 8px; margin: -15px -15px 10px -15px; border-radius: 6px 6px 0 0; font-weight: bold;">
                                    📁 Categories
                                </div>
                                <div class="erd-fields" style="font-size: 12px; line-height: 1.4;">
                                    <div><strong>id</strong> - PK</div>
                                    <div>name</div>
                                    <div>slug</div>
                                    <div>image</div>
                                    <div>description</div>
                                    <div>parent_id - FK</div>
                                    <div>is_active</div>
                                    <div>order</div>
                                </div>
                            </div>

                            <!-- Brands Table -->
                            <div class="erd-table" style="position: absolute; top: 20px; left: 510px; background: #fff; border: 2px solid #d97706; border-radius: 8px; padding: 15px; min-width: 180px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                <div class="erd-table-header" style="background: #d97706; color: white; padding: 8px; margin: -15px -15px 10px -15px; border-radius: 6px 6px 0 0; font-weight: bold;">
                                    🏷️ Brands
                                </div>
                                <div class="erd-fields" style="font-size: 12px; line-height: 1.4;">
                                    <div><strong>id</strong> - PK</div>
                                    <div>name</div>
                                    <div>slug</div>
                                    <div>image</div>
                                    <div>description</div>
                                    <div>is_active</div>
                                </div>
                            </div>

                            <!-- Products Table (Central) -->
                            <div class="erd-table" style="position: absolute; top: 200px; left: 280px; background: #fff; border: 3px solid #dc2626; border-radius: 8px; padding: 15px; min-width: 200px; box-shadow: 0 6px 12px rgba(0,0,0,0.15);">
                                <div class="erd-table-header" style="background: #dc2626; color: white; padding: 8px; margin: -15px -15px 10px -15px; border-radius: 6px 6px 0 0; font-weight: bold; text-align: center;">
                                    🛍️ Products (CORE)
                                </div>
                                <div class="erd-fields" style="font-size: 12px; line-height: 1.4;">
                                    <div><strong>id</strong> - PK</div>
                                    <div>name, slug, sku</div>
                                    <div>description</div>
                                    <div>regular_price</div>
                                    <div>sale_price</div>
                                    <div>featured, status</div>
                                    <div>quantity, image</div>
                                    <div><strong>category_id</strong> - FK</div>
                                    <div><strong>brand_id</strong> - FK</div>
                                    <div>weight, dimensions</div>
                                    <div>meta_title, meta_desc</div>
                                </div>
                            </div>

                            <!-- Orders Table -->
                            <div class="erd-table" style="position: absolute; top: 200px; left: 50px; background: #fff; border: 2px solid #7c3aed; border-radius: 8px; padding: 15px; min-width: 180px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                <div class="erd-table-header" style="background: #7c3aed; color: white; padding: 8px; margin: -15px -15px 10px -15px; border-radius: 6px 6px 0 0; font-weight: bold;">
                                    📦 Orders
                                </div>
                                <div class="erd-fields" style="font-size: 12px; line-height: 1.4;">
                                    <div><strong>id</strong> - PK</div>
                                    <div><strong>user_id</strong> - FK</div>
                                    <div>order_number</div>
                                    <div>subtotal, total_amount</div>
                                    <div>customer_name</div>
                                    <div>customer_email</div>
                                    <div>shipping_address</div>
                                    <div>status</div>
                                    <div>payment_status</div>
                                </div>
                            </div>

                            <!-- Order Items Table -->
                            <div class="erd-table" style="position: absolute; top: 380px; left: 150px; background: #fff; border: 2px solid #7c3aed; border-radius: 8px; padding: 15px; min-width: 180px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                <div class="erd-table-header" style="background: #7c3aed; color: white; padding: 8px; margin: -15px -15px 10px -15px; border-radius: 6px 6px 0 0; font-weight: bold;">
                                    📋 Order Items
                                </div>
                                <div class="erd-fields" style="font-size: 12px; line-height: 1.4;">
                                    <div><strong>id</strong> - PK</div>
                                    <div><strong>order_id</strong> - FK</div>
                                    <div><strong>product_id</strong> - FK</div>
                                    <div>quantity</div>
                                    <div>unit_price</div>
                                    <div>total_price</div>
                                    <div>attributes</div>
                                </div>
                            </div>

                            <!-- Reviews Table -->
                            <div class="erd-table" style="position: absolute; top: 380px; left: 380px; background: #fff; border: 2px solid #0891b2; border-radius: 8px; padding: 15px; min-width: 180px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                <div class="erd-table-header" style="background: #0891b2; color: white; padding: 8px; margin: -15px -15px 10px -15px; border-radius: 6px 6px 0 0; font-weight: bold;">
                                    ⭐ Reviews
                                </div>
                                <div class="erd-fields" style="font-size: 12px; line-height: 1.4;">
                                    <div><strong>id</strong> - PK</div>
                                    <div><strong>user_id</strong> - FK</div>
                                    <div><strong>product_id</strong> - FK</div>
                                    <div>rating</div>
                                    <div>title</div>
                                    <div>comment</div>
                                    <div>is_approved</div>
                                </div>
                            </div>

                            <!-- Attributes -->
                            <div class="erd-table" style="position: absolute; top: 20px; left: 740px; background: #fff; border: 2px solid #ec4899; border-radius: 8px; padding: 15px; min-width: 160px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                <div class="erd-table-header" style="background: #ec4899; color: white; padding: 8px; margin: -15px -15px 10px -15px; border-radius: 6px 6px 0 0; font-weight: bold;">
                                    🎨 Attributes
                                </div>
                                <div class="erd-fields" style="font-size: 12px; line-height: 1.4;">
                                    <div><strong>id</strong> - PK</div>
                                    <div>name</div>
                                    <div>slug</div>
                                    <div>type</div>
                                    <div>is_required</div>
                                </div>
                            </div>

                            <!-- Attribute Values -->
                            <div class="erd-table" style="position: absolute; top: 150px; left: 740px; background: #fff; border: 2px solid #ec4899; border-radius: 8px; padding: 15px; min-width: 160px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                <div class="erd-table-header" style="background: #ec4899; color: white; padding: 8px; margin: -15px -15px 10px -15px; border-radius: 6px 6px 0 0; font-weight: bold;">
                                    🎯 Attr Values
                                </div>
                                <div class="erd-fields" style="font-size: 12px; line-height: 1.4;">
                                    <div><strong>id</strong> - PK</div>
                                    <div><strong>attribute_id</strong> - FK</div>
                                    <div>value</div>
                                </div>
                            </div>

                            <!-- Product Attributes -->
                            <div class="erd-table" style="position: absolute; top: 280px; left: 540px; background: #fff; border: 2px solid #ec4899; border-radius: 8px; padding: 15px; min-width: 160px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                <div class="erd-table-header" style="background: #ec4899; color: white; padding: 8px; margin: -15px -15px 10px -15px; border-radius: 6px 6px 0 0; font-weight: bold;">
                                    🔗 Prod Attributes
                                </div>
                                <div class="erd-fields" style="font-size: 12px; line-height: 1.4;">
                                    <div><strong>id</strong> - PK</div>
                                    <div><strong>product_id</strong> - FK</div>
                                    <div><strong>attribute_value_id</strong> - FK</div>
                                    <div>additional_price</div>
                                </div>
                            </div>

                            <!-- Warehouses -->
                            <div class="erd-table" style="position: absolute; top: 380px; left: 600px; background: #fff; border: 2px solid #16a34a; border-radius: 8px; padding: 15px; min-width: 160px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                <div class="erd-table-header" style="background: #16a34a; color: white; padding: 8px; margin: -15px -15px 10px -15px; border-radius: 6px 6px 0 0; font-weight: bold;">
                                    🏬 Warehouses
                                </div>
                                <div class="erd-fields" style="font-size: 12px; line-height: 1.4;">
                                    <div><strong>id</strong> - PK</div>
                                    <div>name</div>
                                    <div>code</div>
                                    <div>location</div>
                                    <div>manager</div>
                                    <div>is_active</div>
                                </div>
                            </div>

                            <!-- Inventory -->
                            <div class="erd-table" style="position: absolute; top: 380px; left: 800px; background: #fff; border: 2px solid #16a34a; border-radius: 8px; padding: 15px; min-width: 160px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                <div class="erd-table-header" style="background: #16a34a; color: white; padding: 8px; margin: -15px -15px 10px -15px; border-radius: 6px 6px 0 0; font-weight: bold;">
                                    📊 Inventory
                                </div>
                                <div class="erd-fields" style="font-size: 12px; line-height: 1.4;">
                                    <div><strong>id</strong> - PK</div>
                                    <div><strong>product_id</strong> - FK</div>
                                    <div><strong>warehouse_id</strong> - FK</div>
                                    <div>quantity</div>
                                    <div>minimum_stock</div>
                                    <div>reorder_level</div>
                                </div>
                            </div>

                            <!-- Sliders -->
                            <div class="erd-table" style="position: absolute; top: 20px; left: 950px; background: #fff; border: 2px solid #f59e0b; border-radius: 8px; padding: 15px; min-width: 160px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                <div class="erd-table-header" style="background: #f59e0b; color: white; padding: 8px; margin: -15px -15px 10px -15px; border-radius: 6px 6px 0 0; font-weight: bold;">
                                    🎠 Sliders
                                </div>
                                <div class="erd-fields" style="font-size: 12px; line-height: 1.4;">
                                    <div><strong>id</strong> - PK</div>
                                    <div>title</div>
                                    <div>subtitle</div>
                                    <div>image</div>
                                    <div>link</div>
                                    <div>button_text</div>
                                    <div>is_active</div>
                                    <div>order</div>
                                </div>
                            </div>

                            <!-- Transactions -->
                            <div class="erd-table" style="position: absolute; top: 200px; left: 950px; background: #fff; border: 2px solid #8b5cf6; border-radius: 8px; padding: 15px; min-width: 160px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                <div class="erd-table-header" style="background: #8b5cf6; color: white; padding: 8px; margin: -15px -15px 10px -15px; border-radius: 6px 6px 0 0; font-weight: bold;">
                                    💳 Transactions
                                </div>
                                <div class="erd-fields" style="font-size: 12px; line-height: 1.4;">
                                    <div><strong>id</strong> - PK</div>
                                    <div><strong>user_id</strong> - FK</div>
                                    <div><strong>order_id</strong> - FK</div>
                                    <div>transaction_id</div>
                                    <div>amount</div>
                                    <div>payment_method</div>
                                    <div>status</div>
                                </div>
                            </div>

                            <!-- Relationship Lines (SVG) -->
                            <svg style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none;" viewBox="0 0 1200 600">
                                <!-- Users -> Orders -->
                                <line x1="140" y1="120" x2="140" y2="200" stroke="#666" stroke-width="2" marker-end="url(#arrowhead)"/>
                                
                                <!-- Orders -> Order Items -->
                                <line x1="140" y1="350" x2="240" y2="380" stroke="#666" stroke-width="2" marker-end="url(#arrowhead)"/>
                                
                                <!-- Products -> Order Items -->
                                <line x1="330" y1="350" x2="330" y2="380" stroke="#666" stroke-width="2" marker-end="url(#arrowhead)"/>
                                
                                <!-- Categories -> Products -->
                                <line x1="370" y1="170" x2="370" y2="200" stroke="#666" stroke-width="2" marker-end="url(#arrowhead)"/>
                                
                                <!-- Brands -> Products -->
                                <line x1="500" y1="170" x2="400" y2="200" stroke="#666" stroke-width="2" marker-end="url(#arrowhead)"/>
                                
                                <!-- Users -> Reviews -->
                                <line x1="140" y1="120" x2="470" y2="380" stroke="#666" stroke-width="2" stroke-dasharray="5,5" marker-end="url(#arrowhead)"/>
                                
                                <!-- Products -> Reviews -->
                                <line x1="380" y1="350" x2="470" y2="380" stroke="#666" stroke-width="2" marker-end="url(#arrowhead)"/>
                                
                                <!-- Attributes -> Attribute Values -->
                                <line x1="820" y1="120" x2="820" y2="150" stroke="#666" stroke-width="2" marker-end="url(#arrowhead)"/>
                                
                                <!-- Products -> Product Attributes -->
                                <line x1="480" y1="280" x2="540" y2="280" stroke="#666" stroke-width="2" marker-end="url(#arrowhead)"/>
                                
                                <!-- Attribute Values -> Product Attributes -->
                                <line x1="740" y1="200" x2="620" y2="280" stroke="#666" stroke-width="2" marker-end="url(#arrowhead)"/>
                                
                                <!-- Products -> Inventory -->
                                <line x1="480" y1="320" x2="800" y2="380" stroke="#666" stroke-width="2" marker-end="url(#arrowhead)"/>
                                
                                <!-- Warehouses -> Inventory -->
                                <line x1="760" y1="380" x2="800" y2="380" stroke="#666" stroke-width="2" marker-end="url(#arrowhead)"/>
                                
                                <!-- Users -> Transactions -->
                                <line x1="230" y1="80" x2="950" y2="200" stroke="#666" stroke-width="2" stroke-dasharray="5,5" marker-end="url(#arrowhead)"/>
                                
                                <!-- Orders -> Transactions -->
                                <line x1="230" y1="250" x2="950" y2="250" stroke="#666" stroke-width="2" stroke-dasharray="5,5" marker-end="url(#arrowhead)"/>
                                
                                <!-- Arrow marker definition -->
                                <defs>
                                    <marker id="arrowhead" markerWidth="10" markerHeight="7" refX="9" refY="3.5" orient="auto">
                                        <polygon points="0 0, 10 3.5, 0 7" fill="#666" />
                                    </marker>
                                </defs>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Legend -->
                    <div class="mt-4">
                        <h5>📖 Legend</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Solid Lines:</strong> Direct relationships (Foreign Keys)</p>
                                <p><strong>Dashed Lines:</strong> Optional relationships</p>
                                <p><strong>PK:</strong> Primary Key</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>FK:</strong> Foreign Key</p>
                                <p><strong>Core Table:</strong> Products (central to e-commerce)</p>
                                <p><strong>Colors:</strong> Different entity groups</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Info -->
        <div class="row" id="system-info">
            <div class="col-12">
                <div class="info-card">
                    <h3>📋 System Information</h3>
                    <div class="row text-start">
                        <div class="col-md-6">
                            <p><strong>Laravel Version:</strong> {{ app()->version() }}</p>
                            <p><strong>PHP Version:</strong> {{ PHP_VERSION }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Environment:</strong> {{ app()->environment() }}</p>
                            <p><strong>Current Time:</strong> {{ now()->format('Y-m-d H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        </div> <!-- End content-area -->
    </div>

    <!-- Bootstrap JS -->
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

        // Enhanced Sidebar Navigation
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarLinks = document.querySelectorAll('.sidebar .nav-links a');
            const sections = document.querySelectorAll('[id]');
            
            // Handle sidebar navigation clicks
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    
                    // Only handle internal links (starting with #)
                    if (href && href.startsWith('#')) {
                        e.preventDefault();
                        
                        // Remove active class from all links
                        sidebarLinks.forEach(l => l.classList.remove('active'));
                        
                        // Add active class to clicked link
                        this.classList.add('active');
                        
                        // Scroll to target section
                        const targetId = href.substring(1);
                        const targetElement = document.getElementById(targetId);
                        
                        if (targetElement) {
                            targetElement.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    }
                });
            });

            // Highlight active section on scroll
            window.addEventListener('scroll', function() {
                let current = '';
                
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.clientHeight;
                    
                    if (window.pageYOffset >= sectionTop - 200) {
                        current = section.getAttribute('id');
                    }
                });

                // Update active link based on current section
                sidebarLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === '#' + current) {
                        link.classList.add('active');
                    }
                });

                // Keep dashboard link active if no other section is active
                if (!current) {
                    const dashboardLink = document.querySelector('.sidebar .nav-links a[href*="dashboard"]');
                    if (dashboardLink) {
                        dashboardLink.classList.add('active');
                    }
                }
            });
        });
    </script>
</body>

</html>
