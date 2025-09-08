<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم الأدمن</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .admin-header {
            background-color: #343a40;
            color: white;
            padding: 10px 20px;
        }
        .admin-footer {
            background-color: #343a40;
            color: white;
            padding: 10px 20px;
            margin-top: 40px;
            text-align: center;
        }
    </style>
</head>
<body>

    {{-- الهيدر --}}
    <header class="admin-header">
        <div class="container d-flex justify-content-between align-items-center">
            <h3>لوحة التحكم</h3>
            <div>
                <a href="{{ route('dashboard') }}" class="btn btn-sm btn-light">لوحة الطالب</a>
                <a href="{{ route('logout') }}"
                   class="btn btn-sm btn-danger"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">تسجيل الخروج</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </header>

    {{-- الكونتنت --}}
    <main class="py-4">
        @yield('content')
    </main>

    {{-- الفوتر --}}
    <footer class="admin-footer">
        جميع الحقوق محفوظة &copy; {{ date('Y') }} | أكاديمية المهارات الرقمية
    </footer>

    {{-- سكريبتات --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
