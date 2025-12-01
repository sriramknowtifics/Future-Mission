<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Ekomart - Grocery Store')</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/fav.png') }}" type="image/x-icon">

    <!-- Font Awesome CDN (Required for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}">

    <!-- Main Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- Custom Fixes -->
    @stack('styles')
</head>

<body class="@yield('body_class', 'shop-main-h')">

    <!-- Header -->
    @include('partials.theme-header')

    <!-- Main Content -->
    <main class="rts-main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.theme-footer')

    <!-- Back to Top -->
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>

    <!-- jQuery First (Required by mmenu, slick, etc.) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Plugins JS -->
    <script src="{{ asset('assets/js/plugins.js') }}"></script>

    <!-- Main Template JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Custom Scripts -->
    @stack('scripts')
</body>
</html>
