<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - Collection Store</title>
    
    <!-- Disable source map warnings in development -->
    <meta name="source-map" content="false">

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
            /* Enhanced Corporate Navy - Professional & Sophisticated Theme */
            --primary-color: #1e293b;
            --primary-hover: #0f172a;
            --secondary-color: #334155;
            --accent-color: #3b82f6;
            --accent-hover: #2563eb;

            --success-color: #10b981;
            --success-hover: #059669;
            --warning-color: #f59e0b;
            --warning-hover: #d97706;
            --danger-color: #ef4444;
            --danger-hover: #dc2626;
            --info-color: #3b82f6;
            --info-hover: #2563eb;

            /* Enhanced Corporate Navy Background Colors */
            --bg-primary: #0f172a;        /* Deep navy */
            --bg-secondary: #1e293b;      /* Corporate navy */
            --bg-tertiary: #334155;       /* Medium slate */
            --bg-card: #1e293b;           /* Card background */
            --bg-card-hover: #334155;     /* Card hover */
            --bg-light: #f8fafc;          /* Light background */
            --bg-white: #ffffff;          /* Pure white */

            /* Enhanced Text Colors */
            --text-primary: #f8fafc;      /* Light slate */
            --text-secondary: #cbd5e1;    /* Medium gray */
            --text-muted: #94a3b8;        /* Muted gray */
            --text-inverse: #1e293b;      /* Dark text for light backgrounds */
            --text-white: #ffffff;        /* Pure white text */

            /* Enhanced Border & Accent Colors */
            --border-color: #475569;      /* Slate border */
            --border-light: #e2e8f0;      /* Light border */
            --border-accent: #3b82f6;     /* Accent border */
            --border-navy: #334155;       /* Navy border */

            /* Enhanced Shadows & Effects */
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-navy: 0 4px 6px rgba(30, 41, 59, 0.2);
            --glow: 0 0 20px rgba(59, 130, 246, 0.3);
            --glow-hover: 0 0 30px rgba(59, 130, 246, 0.5);

            /* Professional Typography */
            --font-primary: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            --text-xs: 0.75rem;    /* 12px */
            --text-sm: 0.875rem;   /* 14px */
            --text-base: 1rem;     /* 16px */
            --text-lg: 1.125rem;   /* 18px */
            --text-xl: 1.25rem;    /* 20px */
            --text-2xl: 1.5rem;    /* 24px */
            --font-light: 300;
            --font-normal: 400;
            --font-medium: 500;
            --font-semibold: 600;
            --font-bold: 700;
            --leading-normal: 1.5;

            /* Enhanced Layout & Spacing */
            --space-1: 0.25rem;    /* 4px */
            --space-2: 0.5rem;     /* 8px */
            --space-3: 0.75rem;    /* 12px */
            --space-4: 1rem;       /* 16px */
            --space-5: 1.25rem;    /* 20px */
            --space-6: 1.5rem;     /* 24px */
            --space-8: 2rem;       /* 32px */
            --space-10: 2.5rem;    /* 40px */
            --space-12: 3rem;      /* 48px */

            /* Enhanced Layout Dimensions */
            --button-border-radius: 12px;
            --card-border-radius: 16px;
            --input-border-radius: 8px;
            --sidebar-width: 280px;

            /* Professional Transitions */
            --transition-fast: 0.15s ease;
            --transition-normal: 0.2s ease;
            --transition-slow: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            background:
                linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%),
                radial-gradient(circle at 20% 80%, rgba(59, 130, 246, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(30, 41, 59, 0.08) 0%, transparent 50%);
            color: var(--text-primary);
            font-family: var(--font-primary);
            min-height: 100vh;
            position: relative;
        }

        /* Subtle texture overlay for professional depth */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                radial-gradient(circle at 1px 1px, rgba(59, 130, 246, 0.02) 1px, transparent 0);
            background-size: 24px 24px;
            pointer-events: none;
            z-index: 0;
            opacity: 0.6;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background:
                linear-gradient(180deg, var(--bg-secondary) 0%, var(--bg-primary) 100%),
                linear-gradient(45deg, rgba(59, 130, 246, 0.05) 0%, transparent 50%);
            border-right: 1px solid var(--border-navy);
            box-shadow: var(--shadow-xl), inset -1px 0 0 rgba(59, 130, 246, 0.1);
            z-index: 1000;
            transition: var(--transition-slow);
            display: flex;
            flex-direction: column;
            backdrop-filter: blur(10px);
        }

        .sidebar .logo {
            padding: var(--space-10) var(--space-6);
            text-align: center;
            border-bottom: 1px solid var(--border-navy);
            background:
                linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%),
                linear-gradient(45deg, rgba(59, 130, 246, 0.1) 0%, transparent 50%);
            flex-shrink: 0;
            position: relative;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        /* Logo glow effect */
        .sidebar .logo::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--accent-color), transparent);
            opacity: 0.6;
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
            padding: var(--space-5) var(--space-6);
            color: var(--text-secondary);
            text-decoration: none;
            transition: var(--transition-slow);
            font-weight: var(--font-medium);
            font-size: var(--text-sm);
            line-height: var(--leading-normal);
            border-radius: 0 var(--button-border-radius) var(--button-border-radius) 0;
            margin-right: var(--space-4);
            position: relative;
            overflow: hidden;
        }

        /* Navigation link hover effects */
        .sidebar .nav-links li a::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 3px;
            height: 100%;
            background: var(--accent-color);
            transform: scaleY(0);
            transition: var(--transition-normal);
            transform-origin: bottom;
        }

        .sidebar .nav-links li a:hover,
        .sidebar .nav-links li a.active {
            background:
                linear-gradient(135deg, var(--bg-tertiary) 0%, rgba(51, 65, 85, 0.8) 100%),
                linear-gradient(45deg, rgba(59, 130, 246, 0.1) 0%, transparent 50%);
            color: var(--text-white);
            transform: translateX(12px);
            box-shadow: var(--shadow-navy), inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        .sidebar .nav-links li a:hover::before,
        .sidebar .nav-links li a.active::before {
            transform: scaleY(1);
            transform-origin: top;
        }

        .sidebar .nav-links li a.active {
            background:
                linear-gradient(135deg, var(--accent-color) 0%, var(--primary-color) 100%),
                linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            color: var(--text-white);
            box-shadow: var(--glow), inset 0 1px 0 rgba(255, 255, 255, 0.2);
            font-weight: var(--font-semibold);
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
            margin-left: var(--sidebar-width);
            padding: 0;
            min-height: 100vh;
            background:
                linear-gradient(135deg, var(--bg-light) 0%, rgba(248, 250, 252, 0.95) 100%),
                radial-gradient(circle at 30% 70%, rgba(30, 41, 59, 0.03) 0%, transparent 50%);
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 1;
        }

        .top-navbar {
            background:
                linear-gradient(135deg, var(--bg-secondary) 0%, var(--bg-primary) 100%),
                linear-gradient(45deg, rgba(59, 130, 246, 0.08) 0%, transparent 50%);
            padding: var(--space-6) var(--space-8);
            border-bottom: 1px solid var(--border-navy);
            box-shadow: var(--shadow-lg), inset 0 1px 0 rgba(255, 255, 255, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
            flex-shrink: 0;
            backdrop-filter: blur(12px);
        }

        .top-navbar h4 {
            color: var(--text-primary);
            font-weight: var(--font-semibold);
            font-size: var(--text-2xl);
            margin: 0;
        }

        .stats-card {
            background:
                linear-gradient(135deg, var(--bg-white) 0%, var(--bg-light) 100%),
                linear-gradient(45deg, rgba(30, 41, 59, 0.02) 0%, transparent 50%);
            border-radius: var(--card-border-radius);
            padding: var(--space-8);
            margin-bottom: var(--space-6);
            text-align: center;
            transition: var(--transition-slow);
            border: 1px solid var(--border-light);
            box-shadow: var(--shadow), inset 0 1px 0 rgba(255, 255, 255, 0.8);
            position: relative;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            backdrop-filter: blur(8px);
        }

        /* Stats card glow effect */
        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--accent-color), transparent);
            opacity: 0;
            transition: var(--transition-normal);
        }

        .stats-card:hover::before {
            opacity: 0.6;
        }

        .stats-card:hover {
            transform: translateY(-4px) scale(1.01);
            box-shadow: var(--shadow-lg), 0 0 20px rgba(59, 130, 246, 0.15);
            border-color: var(--accent-color);
            background:
                linear-gradient(135deg, var(--bg-white) 0%, var(--bg-light) 100%),
                linear-gradient(45deg, rgba(59, 130, 246, 0.05) 0%, transparent 50%);
        }

        .stats-card .icon {
            font-size: 3rem;
            margin-bottom: var(--space-4);
            color: var(--accent-color);
            text-shadow: 0 2px 4px rgba(59, 130, 246, 0.2);
        }

        .stats-card .number {
            font-size: 2.25rem;
            font-weight: var(--font-bold);
            margin-bottom: var(--space-2);
            color: var(--text-inverse);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .stats-card .label {
            font-size: var(--text-base);
            color: var(--text-muted);
            font-weight: var(--font-medium);
        }

        .welcome-card, .info-card {
            background:
                linear-gradient(135deg, var(--bg-white) 0%, var(--bg-light) 100%),
                linear-gradient(45deg, rgba(30, 41, 59, 0.02) 0%, transparent 50%);
            border-radius: var(--card-border-radius);
            padding: var(--space-10) var(--space-8);
            margin-bottom: var(--space-8);
            border: 1px solid var(--border-light);
            box-shadow: var(--shadow), inset 0 1px 0 rgba(255, 255, 255, 0.8);
            position: relative;
            transition: var(--transition-slow);
            backdrop-filter: blur(8px);
            overflow: hidden;
        }

        /* Welcome card special styling */
        .welcome-card {
            background:
                linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%),
                linear-gradient(45deg, rgba(59, 130, 246, 0.1) 0%, transparent 50%);
            color: var(--text-white);
            border: 1px solid var(--border-navy);
            box-shadow: var(--shadow-lg), inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--accent-color), transparent);
            opacity: 0.8;
        }

        .welcome-card:hover, .info-card:hover {
            box-shadow: var(--shadow-xl), 0 0 25px rgba(59, 130, 246, 0.2);
            border-color: var(--accent-color);
            transform: translateY(-3px);
        }

        .welcome-card h2, .info-card h3 {
            color: var(--text-white);
            font-weight: var(--font-bold);
            margin-bottom: var(--space-4);
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .info-card h3 {
            color: var(--text-inverse);
            text-shadow: none;
        }

        .welcome-card p {
            color: var(--text-primary);
            margin: 0;
            opacity: 0.95;
        }

        .content-area {
            padding: var(--space-8);
            flex: 1;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
            position: relative;
            z-index: 2;
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
            <li><a href="{{ route('admin.categories.index') }}">
                <span class="icon">📂</span>
                <span>Categories</span>
            </a></li>
            <li><a href="{{ route('admin.brands.index') }}">
                <span class="icon">🏷️</span>
                <span>Brands</span>
            </a></li>
            <li><a href="{{ route('admin.products.index') }}">
                <span class="icon">🛍️</span>
                <span>Products</span>
            </a></li>
                    <li><a href="{{ route('admin.attributes.index') }}">
                        <span class="icon">🔧</span>
                        <span>Attributes</span>
                    </a></li>
                    <li><a href="{{ route('admin.attributeValues.index') }}">
                        <span class="icon">📝</span>
                        <span>Attribute Values</span>
                    </a></li>
            <li><a href="{{ route('admin.productAttributes.index') }}">
                <span class="icon">🔗</span>
                <span>Product Attributes</span>
            </a></li>
            <li><a href="{{ route('admin.reviews.index') }}">
                <span class="icon">⭐</span>
                <span>Reviews</span>
            </a></li>

            <!-- CONTENT MANAGEMENT -->
            <li class="nav-section-title">CONTENT</li>
            <li><a href="{{ route('admin.sliders.index') }}">
                <span class="icon">🖼️</span>
                <span>Sliders</span>
            </a></li>

        <!-- ORDER MANAGEMENT -->
        <li class="nav-section-title">ORDERS</li>
        <li><a href="{{ route('admin.orders.index') }}">
            <span class="icon">📦</span>
            <span>Orders</span>
        </a></li>
        <li><a href="{{ route('admin.orderItems.index') }}">
            <span class="icon">📋</span>
            <span>Order Items</span>
        </a></li>
        <li class="nav-item">
  <a
    class="nav-link d-flex justify-content-between align-items-center"
    data-bs-toggle="collapse"
    data-bs-target="#adminSettings"
    role="button"
    aria-expanded="false"
    aria-controls="adminSettings"
  >
    <span><span class="me-2">🏷️</span> SettingAdmin</span>
    <span class="small">▸</span>
  </a>

  <div class="collapse" id="adminSettings">
    <ul class="nav flex-column ms-3">
      <li class="nav-item">
        <a href="{{ route('permissions.index') }}" class="nav-link">Permissions</a>
      </li>
      <li class="nav-item">
        <a href="{{route('roles.index')}}" class="nav-link">Roles</a>
      </li>
      <li class="nav-item">
        <a href="{{route('users.index')}}" class="nav-link">Users</a>
      </li>
    </ul>
  </div>
</li>


        <!-- INVENTORY MANAGEMENT -->
        <li class="nav-section-title">INVENTORY</li>
        <li><a href="{{ route('admin.warehouses.index') }}">
            <span class="icon">🏪</span>
            <span>Warehouses</span>
        </a></li>
        <li><a href="{{ route('admin.inventory.index') }}">
            <span class="icon">📦</span>
            <span>Inventory</span>
        </a></li>

            <!-- FINANCIAL -->
            <li class="nav-section-title">FINANCIAL</li>
            <li><a href="{{ route('admin.transactions.index') }}">
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
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/jquery.mmenu.all.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/jquery.nice-select.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/lazyload.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/footer-reveal.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/wow.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/isotope.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/theia-sticky-sidebar.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/bootstrap-select.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/apexcharts/apexcharts.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/main.js') }}?v={{ time() }}"></script>

       @extends('components.script')
</body>

</html>
