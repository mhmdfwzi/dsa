@extends('frontend.layouts.app')

@section('title', 'أكاديمية المهارات الرقمية - منصة التعليم الإلكتروني الرائدة')

@section('content')
    <!-- القسم 1: الهيرو -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <h1>طور مهاراتك الرقمية مع <span>أكاديمية المهارات الرقمية</span></h1>
                <p>انضم إلى آلاف الطلاب الذين يطورون مهاراتهم مع منصتنا التعليمية المتكاملة، وابدأ رحلتك نحو النجاح المهني</p>
                <div class="hero-buttons">
                    <a href="{{ route('courses.index') }}" class="cta-button primary">استكشف الكورسات <i class="fas fa-arrow-left"></i></a>
                    <a href="#about" class="cta-button secondary">عن الأكاديمية <i class="fas fa-info-circle"></i></a>
                </div>
            </div>
        </div>
        <div class="hero-shape">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
                <path class="shape-fill" d="M0,0V100H1000V0C750,100 500,100 250,100C0,100 0,0 0,0Z"></path>
            </svg>
        </div>
    </section>

    <!-- القسم 2: الإحصائيات -->
    <section class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3 data-count="{{ $studentsCount }}">0</h3>
                    <p>طالب مسجل</p>
                </div>
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3 data-count="{{ $coursesCount }}">0</h3>
                    <p>كورس تعليمي</p>
                </div>
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h3 data-count="{{ $trainersCount }}">0</h3>
                    <p>مدرب محترف</p>
                </div>
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 data-count="{{ $hoursCount }}">0</h3>
                    <p>ساعة تعليمية</p>
                </div>
            </div>
        </div>
    </section>

    <!-- القسم 3: التصنيفات -->
    <section class="categories-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">تصفح حسب التصنيف</h2>
                <p>اختر من بين مجموعة واسعة من التخصصات لتطوير مهاراتك</p>
            </div>
            <div class="categories-grid">
                @foreach($categories as $category)
                    <div class="category-item">
                        <div class="category-icon">
                            <i class="fas fa-laptop-code"></i>
                        </div>
                        <h3>{{ $category->name }}</h3>
                        <p>{{ $category->courses_count }} كورس</p>
                        <a href="{{ route('courses.byCategory', $category) }}" class="category-link">
                            استكشف الكورسات <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- القسم 4: الكورسات الشائعة -->
    <section class="popular-courses-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">الكورسات الأكثر طلباً</h2>
                <p>انضم إلى أفضل الكورسات التي يوصي بها طلابنا</p>
                <a href="{{ route('courses.index') }}" class="view-all">عرض جميع الكورسات <i class="fas fa-arrow-left"></i></a>
            </div>
            <div class="courses-grid">
                @foreach($popularCourses as $course)
                    <div class="course-card">
                        <div class="course-image">
                            <img src="{{ $course->image_url }}" alt="{{ $course->title }}">
                            <div class="course-badge">الأكثر طلباً</div>
                        </div>
                        <div class="course-content">
                            <div class="course-category">{{ $course->category ? $course->category->name : 'بدون تصنيف' }}</div>     
                            <h3><a href="{{ route('courses.show', $course) }}">{{ $course->title }}</a></h3>
                            <p class="course-description">{{ Str::limit(strip_tags($course->description), 100) }}</p>
                            <div class="course-meta">
                                <div class="course-instructor">
                                    <i class="fas fa-user"></i>
                                    {{ $course->trainer ? $course->trainer->name : $course->instructor_name }}
                                </div>
                                <div class="course-rating">
                                    <i class="fas fa-star"></i>
                                    {{ number_format($course->reviews_avg_rating, 1) }} ({{ $course->reviews_count }} تقييم)
                                </div>
                            </div>
                            <div class="course-footer">
                                <div class="course-price">{{ $course->formatted_price }}</div>
                                <a href="{{ route('courses.show', $course) }}" class="course-button">التفاصيل <i class="fas fa-arrow-left"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- القسم 5: المدربين -->
    <section class="instructors-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">تعرف على مدربينا المتميزين</h2>
                <p>تعلم من أفضل الخبراء والمتخصصين في المجال الرقمي</p>
            </div>
            <div class="instructors-grid">
                @foreach($instructors as $instructor)
                    <div class="instructor-card">
                        <div class="instructor-image">
                            <img src="{{ $instructor->profile_photo_url }}" alt="{{ $instructor->name }}">
                            <div class="instructor-social">
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="instructor-content">
                            <h3>{{ $instructor->name }}</h3>
                            <p class="expertise">{{ $instructor->expertise }}</p>
                            <p class="bio">{{ Str::limit($instructor->bio, 100) }}</p>
                            <div class="instructor-stats">
                                <div class="stat">
                                    <span class="number">{{ $instructor->taughtCourses()->count() }}</span>
                                    <span class="label">كورس</span>
                                </div>
                                <div class="stat">
                                    <span class="number">{{ $instructor->reviews()->count() }}</span>
                                    <span class="label">تقييم</span>
                                </div>
                                <div class="stat">
                                    <span class="number">{{ $instructor->taughtCourses()->withCount('students')->get()->sum('students_count') }}</span>
                                    <span class="label">طالب</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- القسم 6: آراء الطلاب -->
    <section class="testimonials-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">ماذا يقول طلابنا عنا</h2>
                <p>انضم إلى آلاف الطلاب الراضين عن تجربتهم التعليمية معنا</p>
            </div>
            <div class="testimonials-slider">
                @foreach($testimonials as $testimonial)
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <div class="quote-icon"><i class="fas fa-quote-right"></i></div>
                            <p>"{{ $testimonial['comment'] }}"</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="{{ $testimonial['image'] }}" alt="{{ $testimonial['name'] }}">
                            <div class="author-info">
                                <h4>{{ $testimonial['name'] }}</h4>
                                <p>{{ $testimonial['course'] }}</p>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- قسم النشرة البريدية -->
    <section class="newsletter-section">
        <div class="container">
            <div class="newsletter-content">
                <h2>اشترك في نشرتنا البريدية</h2>
                <p>كن أول من يعرف عن الكورسات الجديدة والعروض الخاصة</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="بريدك الإلكتروني" required>
                    <button type="submit">اشترك الآن <i class="fas fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
    </section>
@endsection