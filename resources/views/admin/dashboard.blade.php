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
        body {
            background-color: #1e1e2e;
            color: #ffffff;
            font-family: 'Roboto', sans-serif;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            z-index: 1000;
            transition: all 0.3s;
        }

        .sidebar .logo {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar .logo img {
            max-width: 120px;
            filter: brightness(0) invert(1);
        }
        .sidebar .nav-links {
            padding: 20px 0;
        }

        .sidebar .nav-links li {
            list-style: none;
        }

        .sidebar .nav-links li a {
            display: block;
            padding: 15px 25px;
            color: #ffffff;
            text-decoration: none;
            transition: all 0.3s;
        }

        .sidebar .nav-links li a:hover,
        .sidebar .nav-links li a.active {
            background-color: rgba(255,255,255,0.1);
            padding-left: 35px;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
        }

        .top-navbar {
            background: #2d2d44;
            padding: 15px 30px;
            margin: -20px -20px 30px -20px;
            border-radius: 0 0 10px 10px;
        }

        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            color: white;
            text-align: center;
            transition: transform 0.3s;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .stats-card .icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .stats-card .number {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .stats-card .label {
            font-size: 16px;
            opacity: 0.9;
        }

        .welcome-card {
            background: #2d2d44;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            text-align: center;
        }

        .btn-logout {
            background: #dc3545;
            border: none;
            color: white;
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-logout:hover {
            background: #c82333;
            color: white;
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
            <li><a href="{{ route('admin.dashboard') }}" class="active">📊 Dashboard</a></li>
            <li><a href="#">👥 Users</a></li>
            <li><a href="{{route('admin.product')}}">🛍️ Products</a></li>
            <li><a href="#">📦 Orders</a></li>
            <li><a href="#">📊 Analytics</a></li>
            <li><a href="#">⚙️ Settings</a></li>
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
