<footer class="footer" id="contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="footer-brand">
                    <img src="{{ asset('assets/frontend/images/logo.png') }}" alt="شعار أكاديمية المهارات الرقمية" class="footer-logo">
                    <h3>أكاديمية المهارات الرقمية</h3>
                </div>
                <p class="footer-description">نقدم دورات تدريبية عالية الجودة في مختلف المجالات التقنية والرقمية لتطوير مهاراتك ومساعدتك في تحقيق أهدافك المهنية.</p>
                <div class="footer-social">
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 mb-4">
                <h4 class="footer-title">روابط سريعة</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">الرئيسية</a></li>
                    <li><a href="{{ route('courses.index') }}">الكورسات</a></li>
                    <li><a href="{{ route('team.index') }}">فريق العمل</a></li>
                    <li><a href="#contact">اتصل بنا</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-4 mb-4">
                <h4 class="footer-title">الكورسات</h4>
                <ul class="footer-links">
                    @foreach($categories as $category)
                    <li><a href="{{ route('courses.byCategory', $category) }}">{{ $category->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-3 col-md-4 mb-4">
                <h4 class="footer-title">اتصل بنا</h4>
                <div class="footer-contact">
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <span>01032072464</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span>info@dsa-academy.com</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>مصر، القاهرة</span>
                    </div>
                </div>
                
                <div class="footer-newsletter">
                    <h5>اشترك في النشرة البريدية</h5>
                    <form class="newsletter-form">
                        <input type="email" class="form-control" placeholder="بريدك الإلكتروني">
                        <button type="submit" class="btn btn-primary">اشتراك</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} أكاديمية المهارات الرقمية. جميع الحقوق محفوظة.</p>
        </div>
    </div>
</footer>