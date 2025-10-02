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
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

    <!-- Custom Admin CSS -->

</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <img src="{{ asset('img/logo.svg') }}" alt="Collection Store">
            <h4>Collection Store</h4>
        </div>
        <ul class="nav-links">
            <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="icon">📊</span>
                <span>Dashboard</span>
            </a></li>

            <!-- CATALOG MANAGEMENT -->
            <li class="nav-section-title">CATALOG</li>
            <li><a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <span class="icon">📂</span>
                <span>Categories</span>
            </a></li>
            <li><a href="{{ route('admin.brands.index') }}" class="{{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
                <span class="icon">🏷️</span>
                <span>Brands</span>
            </a></li>
            <li><a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <span class="icon">🛍️</span>
                <span>Products</span>
            </a></li>

                    <li><a href="{{ route('admin.attributes.index') }}" class="{{ request()->routeIs('admin.attributes.*') ? 'active' : '' }}">
                        <span class="icon">🔧</span>
                        <span>Attributes</span>
                    </a></li>
                    <li><a href="{{ route('admin.attributeValues.index') }}" class="{{ request()->routeIs('admin.attributeValues.*') ? 'active' : '' }}">
                        <span class="icon">📝</span>
                        <span>Attribute Values</span>
                    </a></li>
            <li><a href="{{ route('admin.productAttributes.index') }}" class="{{ request()->routeIs('admin.productAttributes.*') ? 'active' : '' }}">
                <span class="icon">🔗</span>
                <span>Product Attributes</span>
            </a></li>
            <li><a href="{{ route('admin.reviews.index') }}" class="{{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                <span class="icon">⭐</span>
                <span>Reviews</span>
            </a></li>

            <!-- CONTENT MANAGEMENT -->
            <li class="nav-section-title">CONTENT</li>
            <li><a href="{{ route('admin.sliders.index') }}" class="{{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                <span class="icon">🖼️</span>
                <span>Sliders</span>
            </a></li>

        <!-- ORDER MANAGEMENT -->
        <li class="nav-section-title">ORDERS</li>
        <li><a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <span class="icon">📦</span>
            <span>Orders</span>
        </a></li>
        <li><a href="{{ route('admin.orderItems.index') }}" class="{{ request()->routeIs('admin.orderItems.*') ? 'active' : '' }}">
            <span class="icon">📋</span>
            <span>Order Items</span>
        </a></li>
        <li><a href="{{ route('admin.settings.edit') }}">
            <span class="icon">📋</span>
            <span>Settings</span>
        </a></li>

        <li class="nav-item">
  <a
    class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs('permissions.*') || request()->routeIs('roles.*') || request()->routeIs('users.*') ? 'active' : '' }}"
    data-bs-toggle="collapse"
    data-bs-target="#adminSettings"
    role="button"
    aria-expanded="{{ request()->routeIs('permissions.*') || request()->routeIs('roles.*') || request()->routeIs('users.*') ? 'true' : 'false' }}"
    aria-controls="adminSettings"
  >
    <span><span class="me-2">🏷️</span> SettingAdmin</span>
    <span class="small">▸</span>
  </a>

  <div class="collapse {{ request()->routeIs('permissions.*') || request()->routeIs('roles.*') || request()->routeIs('users.*') ? 'show' : '' }}" id="adminSettings">
    <ul class="nav flex-column ms-3">
      <li class="nav-item">
        <a href="{{ route('permissions.index') }}" class="nav-link {{ request()->routeIs('permissions.*') ? 'active' : '' }}">Permissions</a>
      </li>
      <li class="nav-item">
        <a href="{{route('roles.index')}}" class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">Roles</a>
      </li>
      <li class="nav-item">
        <a href="{{route('users.index')}}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">Users</a>
      </li>
    </ul>
  </div>
</li>


        <!-- INVENTORY MANAGEMENT -->
        <li class="nav-section-title">INVENTORY</li>
        <li><a href="{{ route('admin.warehouses.index') }}" class="{{ request()->routeIs('admin.warehouses.*') ? 'active' : '' }}">
            <span class="icon">🏪</span>
            <span>Warehouses</span>
        </a></li>
        <li><a href="{{ route('admin.inventory.index') }}" class="{{ request()->routeIs('admin.inventory.*') ? 'active' : '' }}">
            <span class="icon">📦</span>
            <span>Inventory</span>
        </a></li>

            <!-- FINANCIAL -->
            <li class="nav-section-title">FINANCIAL</li>
            <li><a href="{{ route('admin.transactions.index') }}" class="{{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}">
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
    {{-- <script src="{{ asset('js/Admin/adminC.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Admin/adminE.js') }}?v={{ time() }}"></script> --}}

       @extends('components.script')
</body>

</html>
