<!DOCTYPE html>
<html lang="en">
<head>
    @include('frontend.layouts.head')

    <!-- مكان لإضافة CSS من أي صفحة -->
    @stack('styles')
</head>
<body>

<div id="page">

    @include('frontend.layouts.header')
    <!-- /header -->

    @yield('content')
    <!-- /main -->

    @include('frontend.layouts.footer')
    <!-- /footer -->

</div>
<!-- /page -->

<div id="toTop"></div><!-- Back to top button -->

<!-- COMMON SCRIPTS -->
@include('frontend.layouts.script')

<!-- مكان لإضافة JS من أي صفحة -->
@stack('scripts')

</body>
</html>
