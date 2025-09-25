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
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style1.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


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
            <li><a href="{{ route('admin.layouts.dashboard') }}" class="active">
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

   @extends('components.script')
</body>

</html>
