<footer class="site-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h3>منصة التعلم</h3>
                <p>منصة تعليمية متكاملة تهدف إلى تقديم تجربة تعلم فريدة ومتميزة.</p>
            </div>
            
            <div class="footer-section">
                <h3>روابط سريعة</h3>
                <ul>
                    <li><a href="{{ route('home') }}">الرئيسية</a></li>
                    <li><a href="{{ route('courses.index') }}">الكورسات</a></li>
                    <li><a href="{{ route('team.index') }}">فريق العمل</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>اتصل بنا</h3>
                <p>البريد الإلكتروني: info@example.com</p>
                <p>الهاتف: +1234567890</p>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} منصة التعلم. جميع الحقوق محفوظة.</p>
        </div>
    </div>
</footer>