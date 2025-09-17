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
    
    <!-- LUXURY FASHION BRAND CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        /* Luxury Fashion Brand Theme */
        body {
            background: #000000 !important;
            background-image: 
                linear-gradient(135deg, #000000 0%, #1a1a1a 25%, #000000 50%, #2a2a2a 75%, #000000 100%),
                radial-gradient(circle at 30% 20%, rgba(212, 175, 55, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 70% 80%, rgba(212, 175, 55, 0.05) 0%, transparent 50%);
            background-size: 400% 400%, 100% 100%, 100% 100%;
            animation: luxuryGradient 20s ease infinite;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            position: relative;
        }
        
        @keyframes luxuryGradient {
            0%, 100% { background-position: 0% 50%, 0% 0%, 0% 0%; }
            50% { background-position: 100% 50%, 0% 0%, 0% 0%; }
        }
        
        .bg_gray {
            background: transparent !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        
        main {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            width: 100%;
        }
        
        header {
            background: rgba(0, 0, 0, 0.98) !important;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(212, 175, 55, 0.3);
            position: relative;
        }
        
        header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, #d4af37, transparent);
        }
        
        header .main_header {
            background: transparent !important;
        }
        
        header a, header span {
            color: #ffffff !important;
            font-weight: 300;
        }
        
        header #logo img {
            filter: brightness(0) invert(1) sepia(1) saturate(10000%) hue-rotate(35deg);
        }
        
        
        
        .container.margin_30 {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 0 !important;
            margin: 0 !important;
            width: 100vw !important;
            max-width: none !important;
        }
        
        .row.justify-content-center {
            width: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .col-lg-6 {
            display: flex;
            justify-content: center;
            width: 100%;
        }
        
        .box_account {
            background: linear-gradient(145deg, 
                rgba(0, 0, 0, 0.98) 0%, 
                rgba(10, 10, 10, 0.99) 50%, 
                rgba(0, 0, 0, 0.98) 100%) !important;
            backdrop-filter: blur(30px);
            border: 3px solid transparent;
            background-clip: padding-box;
            border-radius: 0 !important;
            box-shadow: 
                0 50px 100px rgba(0, 0, 0, 0.8),
                0 0 0 2px rgba(212, 175, 55, 0.6),
                inset 0 2px 0 rgba(212, 175, 55, 0.3),
                inset 0 -1px 0 rgba(212, 175, 55, 0.1);
            padding: 80px 70px;
            position: relative;
            overflow: hidden;
            width: 45%;
            min-width: 500px;
            max-width: 700px;
            margin: 0 auto;
            transform: translateY(0);
            transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        
        .box_account:hover {
            transform: translateY(-8px);
            box-shadow: 
                0 60px 120px rgba(0, 0, 0, 0.7),
                0 0 0 1px rgba(212, 175, 55, 0.6),
                inset 0 2px 0 rgba(212, 175, 55, 0.3),
                inset 0 -1px 0 rgba(0, 0, 0, 0.1);
        }
        
        .box_account::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, 
                transparent 0%, 
                #d4af37 25%, 
                #f4d03f 50%, 
                #d4af37 75%, 
                transparent 100%);
            background-size: 300% 100%;
            animation: luxuryShimmer 4s ease-in-out infinite;
        }
        
        .box_account::after {
            content: 'COLLECTION';
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            font-family: 'Playfair Display', serif;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 3px;
            color: #d4af37;
            text-transform: uppercase;
        }
        
        @keyframes luxuryShimmer {
            0%, 100% { background-position: -300% 0; }
            50% { background-position: 300% 0; }
        }
        
        .form-group {
            position: relative;
            margin-bottom: 25px;
        }
        
        .form-control {
            background: rgba(20, 20, 20, 0.95) !important;
            border: 2px solid rgba(212, 175, 55, 0.4) !important;
            border-radius: 0 !important;
            color: #ffffff !important;
            padding: 20px 30px !important;
            font-size: 16px !important;
            font-weight: 400 !important;
            font-family: 'Inter', sans-serif !important;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94) !important;
            width: 100%;
            margin: 0 auto;
            display: block;
            position: relative;
            z-index: 2;
            box-shadow: inset 0 2px 4px rgba(212, 175, 55, 0.1);
        }
        
        .form-control:focus {
            background: rgba(30, 30, 30, 1) !important;
            border-color: #d4af37 !important;
            box-shadow: 
                0 0 0 3px rgba(212, 175, 55, 0.3),
                0 8px 25px rgba(212, 175, 55, 0.4),
                inset 0 2px 4px rgba(212, 175, 55, 0.1) !important;
            color: #ffffff !important;
            transform: translateY(-2px);
        }
        
        .form-control::placeholder {
            color: rgba(212, 175, 55, 0.7) !important;
            font-weight: 300;
            font-style: italic;
        }
        
        /* Input glow effect */
        .form-group::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, #667eea, #764ba2);
            border-radius: 12px;
            opacity: 0;
            z-index: 1;
            transition: opacity 0.3s ease;
        }
        
        .form-control:focus + .form-group::before,
        .form-group:focus-within::before {
            opacity: 0.1;
        }
        
        .btn_1 {
            background: linear-gradient(135deg, #d4af37 0%, #f4d03f 50%, #d4af37 100%) !important;
            border: 2px solid #d4af37 !important;
            border-radius: 0 !important;
            padding: 20px 50px !important;
            font-weight: 600 !important;
            font-size: 16px !important;
            font-family: 'Playfair Display', serif !important;
            text-transform: uppercase !important;
            letter-spacing: 2px !important;
            color: #000000 !important;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94) !important;
            position: relative !important;
            overflow: hidden !important;
            width: 100% !important;
            margin: 30px auto 20px auto !important;
            display: block !important;
            cursor: pointer !important;
            box-shadow: 0 8px 20px rgba(212, 175, 55, 0.3);
        }
        
        .btn_1:hover {
            transform: translateY(-4px) !important;
            box-shadow: 
                0 20px 40px rgba(212, 175, 55, 0.5),
                0 8px 20px rgba(0, 0, 0, 0.2) !important;
            background: linear-gradient(135deg, #f4d03f 0%, #d4af37 50%, #f4d03f 100%) !important;
            border-color: #f4d03f !important;
        }
        
        .btn_1:active {
            transform: translateY(-1px) !important;
            transition: all 0.1s ease !important;
        }
        
        .btn_1::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn_1:hover::before {
            left: 100%;
        }
        
        .alert {
            background: rgba(220, 53, 69, 0.2) !important;
            border: 1px solid rgba(220, 53, 69, 0.3) !important;
            border-radius: 10px !important;
            color: #ffffff !important;
        }
        
        .alert-success {
            background: rgba(25, 135, 84, 0.2) !important;
            border-color: rgba(25, 135, 84, 0.3) !important;
        }
        
        .container_check {
            color: rgba(255, 255, 255, 0.9) !important;
            font-size: 14px;
            font-weight: 400;
        }
        
        .checkmark {
            background-color: rgba(255, 255, 255, 0.05) !important;
            border: 2px solid rgba(102, 126, 234, 0.3) !important;
            border-radius: 6px !important;
            transition: all 0.3s ease !important;
        }
        
        .container_check input:checked ~ .checkmark {
            background-color: #667eea !important;
            border-color: #667eea !important;
            box-shadow: 0 0 10px rgba(102, 126, 234, 0.5) !important;
        }
        
        .clearfix.add_bottom_15 {
            margin-bottom: 30px !important;
            margin-top: 20px !important;
            width: 70%;
            margin-left: auto;
            margin-right: auto;
        }
        
        a {
            color: #d4af37 !important;
            transition: all 0.3s ease !important;
            text-decoration: none !important;
            font-weight: 500;
        }
        
        a:hover {
            color: #f4d03f !important;
            text-shadow: 0 0 10px rgba(212, 175, 55, 0.6);
        }
        
        .text-center p {
            color: #ffffff !important;
            font-family: 'Inter', sans-serif;
            font-weight: 400;
        }
        
        .text-center.add_top_10 p {
            font-size: 15px !important;
            font-weight: 400 !important;
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        .text-center hr {
            border-color: rgba(255, 255, 255, 0.2) !important;
        }
        
        /* Demo credentials styling */
        .demo-credentials {
            background: rgba(212, 175, 55, 0.1) !important;
            border: 1px solid rgba(212, 175, 55, 0.3) !important;
            border-radius: 0 !important;
            padding: 30px 25px !important;
            margin-top: 30px !important;
            position: relative;
            overflow: hidden;
        }
        
        .demo-credentials::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #d4af37, #f4d03f, #d4af37, transparent);
            animation: luxuryScan 3s ease-in-out infinite;
        }
        
        @keyframes luxuryScan {
            0% { left: -100%; }
            100% { left: 100%; }
        }
        
        .demo-credentials p {
            margin-bottom: 15px !important;
            font-family: 'Inter', sans-serif !important;
            font-size: 14px !important;
            color: #ffffff !important;
            font-weight: 400;
        }
        
        .demo-credentials strong {
            color: #d4af37 !important;
            font-weight: 600;
            text-shadow: 0 0 8px rgba(212, 175, 55, 0.3);
        }
        
        /* Professional spacing */
        .text-center.add_top_10 {
            margin-top: 25px !important;
            margin-bottom: 15px !important;
        }
        
        .text-center.add_top_10 p {
            font-size: 15px !important;
            font-weight: 400 !important;
        }
        
        /* Luxury Fashion Elements */
        .luxury-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }
        
        .luxury-accent {
            position: absolute;
            background: linear-gradient(45deg, #d4af37, #f4d03f);
            opacity: 0.1;
            animation: luxuryFloat 8s ease-in-out infinite;
        }
        
        .luxury-accent:nth-child(1) {
            width: 2px;
            height: 200px;
            top: 10%;
            left: 15%;
            animation-delay: 0s;
        }
        
        .luxury-accent:nth-child(2) {
            width: 150px;
            height: 1px;
            top: 30%;
            right: 10%;
            animation-delay: 3s;
        }
        
        .luxury-accent:nth-child(3) {
            width: 1px;
            height: 100px;
            bottom: 20%;
            left: 25%;
            animation-delay: 6s;
        }
        
        @keyframes luxuryFloat {
            0%, 100% { transform: translateY(0px) scale(1); opacity: 0.1; }
            50% { transform: translateY(-10px) scale(1.1); opacity: 0.2; }
        }
        
        /* Responsive adjustments */
        @media (max-width: 1200px) {
            .box_account {
                width: 50%;
                min-width: 380px;
            }
        }
        
        @media (max-width: 768px) {
            .box_account {
                padding: 45px 40px;
                width: 70%;
                min-width: 350px;
                max-width: 500px;
                border-radius: 15px;
            }
            
            .container.margin_30 {
                padding: 20px !important;
            }
        }
        
        @media (max-width: 480px) {
            .box_account {
                padding: 35px 30px;
                width: 85%;
                min-width: 300px;
                max-width: 400px;
            }
        }
        
        /* Footer styling */
        footer {
            background: rgba(26, 26, 46, 0.95) !important;
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        footer h3, footer a, footer span {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        footer a:hover {
            color: #667eea !important;
        }
    </style>
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
            <div class="layer"></div><!-- Mobile menu overlay mask -->
            <div class="main_header">
                <div class="container">
                    <div class="row small-gutters">
                        <div class="col-xl-3 col-lg-3 d-lg-flex align-items-center">
                            <div id="logo">
                                <a href="{{ url('/') }}"><img src="{{ asset('img/logo.svg') }}" alt="" width="100" height="35"></a>
                            </div>
                        </div>
                        <nav class="col-xl-6 col-lg-7">
                            <div class="main-menu">
                                <ul>
                                    <li><a href="{{ url('/') }}">Home</a></li>
                                    <li><a href="{{ url('listing-grid-3') }}">Men</a></li>
                                    <li><a href="{{ url('listing-grid-1-full') }}">Woman</a></li>
                                    <li><a href="{{ url('listing-grid-2-full') }}">Boys</a></li>
                                    <li><a href="{{ url('girls') }}">Girls</a></li>
                                </ul>
                            </div>
                        </nav>
                        <div class="col-xl-3 col-lg-2 d-lg-flex align-items-center justify-content-end text-end">
                            <a class="phone_top" href="tel://9438843343"><strong><span>Need Help?</span>+94 423-23-221</strong></a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        <main class="bg_gray">
            <div class="container margin_30">
                
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
                                    <input type="email" class="form-control" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password" placeholder="Password" required>
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
                                <p>Don't have an account? <a href="{{ route('register') }}">Sign Up</a></p>
                            </div>
                            
                            <div class="demo-credentials text-center">
                                <p><strong>🔑 Demo Credentials:</strong></p>
                                <p><strong>👨‍💼 Admin:</strong> admin@collection.com / password123</p>
                                <p><strong>👤 User:</strong> user@collection.com / password123</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        
        <footer class="revealed">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <h3 data-bs-target="#collapse_1">Quick Links</h3>
                        <div class="collapse dont-collapse-sm links" id="collapse_1">
                            <ul>
                                <li><a href="{{ url('/') }}">Home</a></li>
                                <li><a href="{{ url('help') }}">Help</a></li>
                                <li><a href="{{ url('login') }}">My account</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row add_bottom_25">
                    <div class="col-lg-6">
                        <ul class="additional_links">
                            <li><span>© 2024 Collection Store</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    
    <!-- COMMON SCRIPTS -->
    <script src="{{ asset('js/common_scripts.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
            