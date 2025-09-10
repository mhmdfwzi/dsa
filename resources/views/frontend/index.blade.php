@extends('frontend.layouts.app')

@section('title', 'أكاديمية المهارات الرقمية - المنصة التعليمية الرائدة')

@section('content')
<!-- قسم البطل -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="hero-title">طور مهاراتك الرقمية لمستقبل أفضل</h1>
                <p class="hero-subtitle">انضم إلى آلاف الطلاب الذين يطورون مهاراتهم الرقمية ويحققون أهدافهم المهنية من خلال دوراتنا المتخصصة</p>
                <div class="hero-actions">
                    <a href="{{ route('courses.index') }}" class="btn btn-primary">استكشف الكورسات</a>
                    <a href="#about" class="btn btn-outline-primary">تعرف علينا</a>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('assets/frontend/images/hero-image.png') }}" alt="طلاب يتعلمون" class="hero-image">
            </div>
        </div>
    </div>
</section>

<!-- قسم الإحصائيات -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="stat-number">{{ $coursesCount }}</div>
                    <div class="stat-text">كورس تعليمي</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-number">{{ $studentsCount }}</div>
                    <div class="stat-text">طالب مسجل</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="stat-number">{{ $trainersCount }}</div>
                    <div class="stat-text">مدرب محترف</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-number">{{ $hoursCount }}</div>
                    <div class="stat-text">ساعة تعليم</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- قسم الكورسات الشائعة -->
<section class="courses-section" id="courses">
    <div class="container">
        <h2 class="section-title">الكورسات الشائعة</h2>
        
        <div class="row">
            @foreach($popularCourses as $course)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="course-card">
                    <div class="course-image-container">
                        <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="course-image">
                        <span class="course-badge">{{ $course->category->name ?? 'عام' }}</span>
                    </div>
                    <div class="course-content">
                        <h3 class="course-title">{{ $course->title }}</h3>
                        <p class="course-description">{{ Str::limit($course->description, 100) }}</p>
                        
                        <div class="course-meta">
                            <div class="course-rating">
                                <i class="fas fa-star"></i> {{ number_format($course->reviews_avg_rating, 1) }} ({{ $course->reviews_count }} تقييم)
                            </div>
                            <div class="course-price">{{ $course->formatted_price }}</div>
                        </div>
                        
                        <div class="course-actions">
                            <a href="{{ route('courses.show', $course) }}" class="btn btn-primary">عرض التفاصيل</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('courses.index') }}" class="btn btn-outline-primary">عرض جميع الكورسات</a>
        </div>
    </div>
</section>

<!-- قسم التصنيفات -->
<section class="categories-section">
    <div class="container">
        <h2 class="section-title">التصنيفات</h2>
        
        <div class="row">
            @foreach($categories as $category)
            <div class="col-lg-3 col-md-4 col-6 mb-4">
                <a href="{{ route('courses.byCategory', $category) }}" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h3 class="category-title">{{ $category->name }}</h3>
                    <p class="category-count">{{ $category->courses_count }} كورس</p>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- قسم المدربين -->
<section class="trainers-section">
    <div class="container">
        <h2 class="section-title">مدربونا المتميزون</h2>
        
        <div class="row">
            @foreach($featuredTrainers as $trainer)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="trainer-card">
                    <div class="trainer-image-container">
                        <img src="{{ $trainer->profile_photo_url }}" alt="{{ $trainer->name }}" class="trainer-image">
                    </div>
                    <div class="trainer-content">
                        <h3 class="trainer-name">{{ $trainer->name }}</h3>
                        <p class="trainer-expertise">{{ $trainer->expertise }}</p>
                        <p class="trainer-bio">{{ Str::limit($trainer->bio, 100) }}</p>
                        
                        <div class="trainer-social">
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- قسم آراء العملاء -->
<section class="testimonials-section">
    <div class="container">
        <h2 class="section-title">آراء طلابنا</h2>
        
        <div class="row">
            @foreach($testimonials as $testimonial)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <div class="testimonial-text">"{{ $testimonial['comment'] }}"</div>
                    </div>
                    <div class="testimonial-author">
                        <img src="{{ $testimonial['image'] }}" alt="{{ $testimonial['name'] }}" class="author-image">
                        <div class="author-info">
                            <h4 class="author-name">{{ $testimonial['name'] }}</h4>
                            <p class="author-course">{{ $testimonial['course'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection