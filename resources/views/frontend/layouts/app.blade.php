<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'منصة التعلم الإلكتروني')</title>
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/main.css') }}">
</head>
<body>
    @include('frontend.partials.header')
    
    <main>
        @yield('content')
    </main>
    
    @include('frontend.partials.footer')
    
    <script src="{{ asset('assets/frontend/js/main.js') }}"></script>
</body>
</html>