<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Collection Store">
    <title>Login - Collection Store</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">

    <!-- GOOGLE WEB FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- BASE CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- SPECIFIC CSS -->
    <link href="{{ asset('css/account.css') }}" rel="stylesheet">

    <!-- YOUR CUSTOM CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">

    <!-- LUXURY FASHION BRAND CSS -->
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">

</head>

<body>
    <!-- Luxury Fashion Elements -->
    <div class="luxury-elements">
        <div class="luxury-accent"></div>
        <div class="luxury-accent"></div>
        <div class="luxury-accent"></div>
    </div>

    <div id="page">

        <header class="version_1">
            <div class="layer"></div>

            @php
                $setting = \App\Models\Setting::first();
                $menuItems = $setting->menu_items ?? [];
            @endphp

            <div class="main_header">
                <div class="container">
                    <div class="row small-gutters">
                        <!-- Logo -->
                        <div class="col-xl-3 col-lg-3 d-lg-flex align-items-center">
                            <div id="logo">
                                <a href="{{ url('/') }}">
                                    <img src="{{ $setting->logo ? asset('storage/' . $setting->logo) : asset('img/logo.jpeg') }}"
                                        alt="Logo" width="130" height="55"
                                        onerror="this.onerror=null;this.src='{{ asset('img/logo.jpeg') }}';">
                                </a>

                            </div>
                        </div>

                        <!-- Navigation -->
                        <nav class="col-xl-6 col-lg-7">
                            <a class="open_close" href="javascript:void(0);">
                                <div class="hamburger hamburger--spin">
                                    <div class="hamburger-box">
                                        <div class="hamburger-inner"></div>
                                    </div>
                                </div>
                            </a>

                            <div class="main-menu">
                                <div id="header_menu">
                                    <a href="{{ url('/') }}">
                                        <img src="{{ $setting->logo ? asset('storage/' . $setting->logo) : asset('img/logo_black.svg') }}"
                                            alt="Logo" width="100" height="35">
                                    </a>
                                    <a href="#" class="open_close" id="close_in"><i class="ti-close"></i></a>
                                </div>

                                @php
                                    // Decode JSON safely
                                    $menuItems = !empty($setting->menu_items)
                                        ? json_decode($setting->menu_items, true)
                                        : [];
                                    if (!is_array($menuItems)) {
                                        $menuItems = [];
                                    }
                                @endphp
                                <ul>
                                    @forelse($menuItems as $item)
                                        <li>
                                            <a href="{{ $item['link'] ?? '#' }}">{{ $item['label'] ?? '' }}</a>
                                        </li>
                                    @empty

                                        <li>
                                            <a href="{{ url('/') }}">Home</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('listing-grid-3') }}">Men</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('listing-grid-1-full') }}">Woman</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('listing-grid-2-full') }}">Boys</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('girls') }}">Girls</a>
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        </nav>

                        <!-- Phone -->
                        <div class="col-xl-3 col-lg-2 d-lg-flex align-items-center justify-content-end text-end">

                            <a class="phone_top" href="tel://{{ $setting->phone }}">
                                <strong><span>{{ $setting->name ?? 'LAM Shopping' }}</span>
                                    {{ $setting->phone ?? '+961 81 195 971' }}</strong>
                            </a>

                        </div>
                    </div>
                </div>
            </div>


            <!-- /main_header -->



        </header>

        {{-- @include('frontend.layouts.header') --}}
        <main class="bg_gray">
            <div class="container margin_30" id="login-form">

                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="box_account">

                            @if (isset($errors) && $errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form action="{{ route('login.post') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email"
                                        placeholder="Email Address" value="{{ old('email') }}" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password" placeholder="Password"
                                        required>
                                </div>
                                <div class="clearfix add_bottom_15">
                                    <div class="checkboxes float-start">
                                        <label class="container_check">Remember me
                                            <input type="checkbox" name="remember">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="float-end">
                                        <a href="#0">Lost Password?</a>
                                    </div>
                                </div>
                                <button type="submit" class="btn_1 full-width">Login</button>
                            </form>

                            <div class="text-center add_top_10">
                                <p>Don't have an account? <a href="#" onclick="showRegisterForm()"
                                        style="color: #d4af37; text-decoration: none; font-weight: 500;">Sign Up</a>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Registration Form (Hidden by default) -->
            {{-- <div class="container margin_30" id="register-form" style="display: none;">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="box_account">
                            <h3 class="client">Register</h3>
                            <form method="POST" action="{{ route('register.post') }}" id="registerForm">
                                @csrf
                                <div class="form_container">
                                    <div class="row no-gutters mb-3">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" id="first_name" placeholder="First Name*" value="{{ old('first_name') }}" required>
                                                @error('first_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" id="last_name" placeholder="Last Name*" value="{{ old('last_name') }}" required>
                                                @error('last_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email_register" placeholder="Email Address*" value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password_register" placeholder="Password*" required>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password*" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="Phone Number (Optional)" value="{{ old('phone') }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="clearfix add_bottom_15">
                                        <div class="float-start">
                                            <label class="container_check">I agree to the <a href="#" style="color: #d4af37;">Terms and Conditions</a>
                                                <input type="checkbox" name="terms" id="terms" required>
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn_1 full-width">Create Account</button>
                                </div>
                            </form>
                            <div class="text-center add_top_10">
                                <p>Already have an account? <a href="#" onclick="showLoginForm()" style="color: #d4af37; text-decoration: none; font-weight: 500;">Sign In</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </main>

        
    </div>

    <!-- COMMON SCRIPTS -->
    <script src="{{ asset('js/common_scripts.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    <script>
        // Form switching functions
        function showRegisterForm() {
            document.getElementById('login-form').style.display = 'none';
            document.getElementById('register-form').style.display = 'block';
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }

        function showLoginForm() {
            document.getElementById('register-form').style.display = 'none';
            document.getElementById('login-form').style.display = 'block';
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }

        // Check if we should show register form (for validation errors)
        document.addEventListener('DOMContentLoaded', function() {
            @if (
                $errors->has('first_name') ||
                    $errors->has('last_name') ||
                    $errors->has('email') ||
                    $errors->has('password') ||
                    $errors->has('phone'))
                showRegisterForm();
            @endif
        });
    </script>
</body>

</html>
