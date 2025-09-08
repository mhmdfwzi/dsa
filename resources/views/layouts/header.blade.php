<header class="bg-white shadow">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-xl font-bold text-blue-600">أكاديمية التدريب</a>

        <nav class="space-x-4">
            <a href="{{ route('home') }}">الرئيسية</a>
            <a href="{{ route('team.index') }}">فريق العمل</a>
            @auth
                <a href="{{ route('dashboard') }}">حسابي</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit">تسجيل الخروج</button>
                </form>
            @else
                <a href="{{ route('login') }}">تسجيل الدخول</a>
                <a href="{{ route('register') }}">إنشاء حساب</a>
            @endauth
        </nav>
    </div>
</header>
