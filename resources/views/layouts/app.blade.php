<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>أكاديمية المهارات الرقمية</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f9f9f9;
        }
        header {
            background-color: #007bff;
            padding: 15px 0;
            color: white;
        }
        footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            margin-top: 40px;
        }
    </style>
</head>
<body>

    {{-- الهيدر --}}
    <header>
        <div class="container d-flex justify-content-between align-items-center">
            <h3 class="mb-0">أكاديمية المهارات الرقمية</h3>
            <nav>
                <a href="{{ route('home') }}" class="text-white mx-2">الرئيسية</a>
                <a href="{{ route('team.index') }}" class="text-white mx-2">فريق العمل</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="text-white mx-2">حسابي</a>
                    <a href="{{ route('logout') }}" class="text-white mx-2"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">خروج</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-white mx-2">تسجيل الدخول</a>
                @endauth
            </nav>
        </div>
    </header>

    {{-- الكونتنت --}}
    <main class="container py-4">
        @yield('content')
    </main>

    {{-- الفوتر --}}
    <footer class="text-center">
        <p>&copy; {{ date('Y') }} جميع الحقوق محفوظة | أكاديمية المهارات الرقمية</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
