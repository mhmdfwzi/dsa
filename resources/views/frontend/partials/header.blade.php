<header class="site-header">
    <div class="container">
        <div class="logo">
            <a href="{{ route('home') }}">
                <h1>منصة التعلم</h1>
            </a>
        </div>
        
        <nav class="main-nav">
            <ul>
                <li><a href="{{ route('home') }}">الرئيسية</a></li>
                <li><a href="{{ route('courses.index') }}">الكورسات</a></li>
                <li><a href="{{ route('team.index') }}">فريق العمل</a></li>
                
                @auth
                    <li><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">تسجيل الخروج</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}">تسجيل الدخول</a></li>
                    <li><a href="{{ route('register') }}">إنشاء حساب</a></li>
                @endauth
            </ul>
        </nav>
    </div>
</header>