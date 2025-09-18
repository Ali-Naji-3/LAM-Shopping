<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - Collection Store</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">

    <!-- GOOGLE WEB FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom Admin CSS - Professional Corporate Theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

      <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
      <link rel="stylesheet" type="text/css" href="{{asset('cssd/animate.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('cssd/animation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('cssd/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('cssd/bootstrap-select.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('cssd/style.css') }}">
    <link rel="stylesheet" href="{{ asset('font/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('icon/style.css') }}">
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
            <li><a href="{{route('admin.product')}}">
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

    @yield('content')

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
