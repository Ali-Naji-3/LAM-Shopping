<!DOCTYPE html>
<html>
<head>
    <title>Test Logout</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Test Logout Form</h1>
    
    <p>CSRF Token: {{ csrf_token() }}</p>
    
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
    
    <script>
        // Set up CSRF token for AJAX requests
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        };
    </script>
</body>
</html>
