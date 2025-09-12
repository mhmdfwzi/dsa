@extends('frontend.layouts.app')

@section('title', $course->title . ' - أكاديمية المهارات الرقمية')

@section('content')
<section class="course-detail-section">
    <div class="container">
        <!-- مسار التنقل -->
        <nav class="breadcrumb-nav">
            <ol>
                <li><a href="{{ route('home') }}">الرئيسية</a></li>
                <li><a href="{{ route('courses.index') }}">الكورسات</a></li>
                <li><a href="{{ route('courses.byCategory', $course->category) }}">{{ $course->category->name ?? 'بدون تصنيف' }}</a></li>
                <li>{{ $course->title }}</li>
            </ol>
        </nav>

        <div class="course-detail-grid">
            <!-- المحتوى الرئيسي -->
            <div class="course-main-content">
                <!-- صورة الكورس والعنوان -->
                <div class="course-header">
                    <div class="course-image">
                        <img src="{{ $course->image_url }}" alt="{{ $course->title }}">
                        @if($course->isFree)
                        <div class="course-badge free">مجاني</div>
                        @else
                        <div class="course-badge paid">مدفوع</div>
                        @endif
                    </div>
                    
                    <div class="course-title-section">
                        <div class="course-category">{{ $course->category->name ?? 'بدون تصنيف' }}</div>
                        <h1>{{ $course->title }}</h1>
                        <p class="course-excerpt">{{ Str::limit(strip_tags($course->description), 200) }}</p>
                        
                        <div class="course-meta">
                            <div class="meta-item">
                                <i class="fas fa-user"></i>
                                <span>المدرب: {{ $course->trainer ? $course->trainer->name : $course->instructor_name }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-clock"></i>
                                <span>المدة: {{ $course->duration_text }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-layer-group"></i>
                                <span>المستوى: {{ $course->level_text }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-users"></i>
                                <span>{{ $course->students_count }} طالب مسجل</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-star"></i>
                                <span>{{ number_format($course->reviews_avg_rating, 1) }} ({{ $course->reviews_count }} تقييم)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- أزرار التسجيل -->
                <div class="enrollment-actions">
                    @auth
                        @if($isEnrolled)
                            @if($enrollmentStatus === 'approved')
                                <a href="#" class="cta-button success">
                                    <i class="fas fa-check-circle"></i> مسجل بالفعل
                                </a>
                                <a href="#" class="cta-button primary">
                                    <i class="fas fa-play-circle"></i> استمر في التعلم
                                </a>
                            @else
                                <a href="#" class="cta-button warning">
                                    <i class="fas fa-clock"></i> في انتظار الموافقة
                                </a>
                            @endif
                        @else
                            <form action="{{ route('courses.enroll', $course) }}" method="POST">
                                @csrf
                                <button type="submit" class="cta-button primary">
                                    <i class="fas fa-user-plus"></i> سجل في هذا الكورس
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="cta-button primary">
                            <i class="fas fa-sign-in-alt"></i> سجل الدخول للتسجيل في الكورس
                        </a>
                    @endauth
                    
                    <div class="course-price">
                        <span class="price">{{ $course->formatted_price }}</span>
                        @if(!$course->isFree)
                        <span class="price-note">شامل ضريبة القيمة المضافة</span>
                        @endif
                    </div>
                </div>

                <!-- وصف الكورس -->
                <div class="course-description-section">
                    <h2>وصف الكورس</h2>
                    <div class="description-content">
                        {!! $course->description !!}
                    </div>
                </div>

                <!-- ما سوف تتعلمه -->
                <div class="learning-outcomes-section">
                    <h2>ما سوف تتعلمه</h2>
                    <div class="outcomes-grid">
                        <div class="outcome-item">
                            <i class="fas fa-check-circle"></i>
                            <span>فهم أساسيات المجال بشكل متكامل</span>
                        </div>
                        <div class="outcome-item">
                            <i class="fas fa-check-circle"></i>
                            <span>تطبيق المهارات في مشاريع عملية</span>
                        </div>
                        <div class="outcome-item">
                            <i class="fas fa-check-circle"></i>
                            <span>اكتساب خبرة عملية قابلة للتطبيق</span>
                        </div>
                        <div class="outcome-item">
                            <i class="fas fa-check-circle"></i>
                            <span>بناء محفظة أعمال احترافية</span>
                        </div>
                    </div>
                </div>

                <!-- محتوى الكورس -->
                <div class="course-content-section">
                    <h2>محتوى الكورس</h2>
                    <div class="content-accordion">
                        <div class="accordion-item">
                            <div class="accordion-header">
                                <h3>القسم 1: المقدمة والأساسيات</h3>
                                <span>5 دروس • 45 دقيقة</span>
                            </div>
                            <div class="accordion-content">
                                <div class="lesson-item">
                                    <div class="lesson-info">
                                        <i class="fas fa-play-circle"></i>
                                        <span>مقدمة إلى الكورس</span>
                                    </div>
                                    <span class="lesson-duration">10:15</span>
                                </div>
                                <div class="lesson-item">
                                    <div class="lesson-info">
                                        <i class="fas fa-play-circle"></i>
                                        <span>تهيئة البيئة</span>
                                    </div>
                                    <span class="lesson-duration">15:30</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <div class="accordion-header">
                                <h3>القسم 2: المفاهيم المتقدمة</h3>
                                <span>8 دروس • 1 ساعة 20 دقيقة</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- التقييمات -->
                <div class="reviews-section">
                    <h2>تقييمات الطلاب</h2>
                    <div class="reviews-summary">
                        <div class="average-rating">
                            <span class="rating-number">{{ number_format($course->reviews_avg_rating, 1) }}</span>
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($course->reviews_avg_rating))
                                        <i class="fas fa-star"></i>
                                    @elseif($i - 0.5 <= $course->reviews_avg_rating)
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="total-reviews">{{ $course->reviews_count }} تقييم</span>
                        </div>
                        
                        <div class="rating-bars">
                            @for($i = 5; $i >= 1; $i--)
                                <div class="rating-bar">
                                    <span class="stars">{{ $i }} <i class="fas fa-star"></i></span>
                                    <div class="bar">
                                        <div class="fill" style="width: {{ rand(60, 100) }}%"></div>
                                    </div>
                                    <span class="percentage">{{ rand(60, 100) }}%</span>
                                </div>
                            @endfor
                        </div>
                    </div>
                    
                    <div class="reviews-list">
                        @if($course->reviews_count > 0)
                            @foreach($course->reviews->take(5) as $review)
                                <div class="review-item">
                                    <div class="reviewer-info">
                                        <img src="{{ $review->user->profile_photo_url }}" alt="{{ $review->user->name }}">
                                        <div class="reviewer-details">
                                            <h4>{{ $review->user->name }}</h4>
                                            <div class="review-meta">
                                                <div class="stars">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->rating)
                                                            <i class="fas fa-star"></i>
                                                        @else
                                                            <i class="far fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <span class="review-date">{{ $review->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="review-content">{{ $review->comment }}</p>
                                </div>
                            @endforeach
                        @else
                            <p class="no-reviews">لا توجد تقييمات لهذا الكورس بعد.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- الشريط الجانبي -->
            <div class="course-sidebar">
                <div class="sidebar-card">
                    <div class="course-price-card">
                        <div class="price">{{ $course->formatted_price }}</div>
                        @if(!$course->isFree)
                        <div class="price-note">شامل ضريبة القيمة المضافة</div>
                        @endif
                        
                        @auth
                            @if(!$isEnrolled)
                                <form action="{{ route('courses.enroll', $course) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="enroll-button">
                                        <i class="fas fa-shopping-cart"></i> سجل الآن
                                    </button>
                                </form>
                            @else
                                <a href="#" class="enroll-button enrolled">
                                    <i class="fas fa-check-circle"></i> مسجل بالفعل
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="enroll-button">
                                <i class="fas fa-sign-in-alt"></i> سجل الدخول للتسجيل
                            </a>
                        @endauth
                    </div>
                    
                    <div class="course-features">
                        <h3>مميزات الكورس</h3>
                        <ul>
                            <li>
                                <i class="fas fa-play-circle"></i>
                                <span>عدد الدروس: 30 درس</span>
                            </li>
                            <li>
                                <i class="fas fa-clock"></i>
                                <span>المدة: {{ $course->duration_text }}</span>
                            </li>
                            <li>
                                <i class="fas fa-certificate"></i>
                                <span>شهادة إتمام</span>
                            </li>
                            <li>
                                <i class="fas fa-infinity"></i>
                                <span>وصول مدى الحياة</span>
                            </li>
                            <li>
                                <i class="fas fa-mobile-alt"></i>
                                <span>متاح على جميع الأجهزة</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- المدرب -->
                <div class="sidebar-card instructor-card">
                    <h3>عن المدرب</h3>
                    <div class="instructor-info">
                        <img src="{{ $course->trainer ? $course->trainer->profile_photo_url : asset('assets/frontend/images/default-instructor.jpg') }}" 
                             alt="{{ $course->trainer ? $course->trainer->name : $course->instructor_name }}">
                        <div class="instructor-details">
                            <h4>{{ $course->trainer ? $course->trainer->name : $course->instructor_name }}</h4>
                            <p class="expertise">{{ $course->trainer ? $course->trainer->expertise : 'خبير في المجال' }}</p>
                            <div class="instructor-stats">
                                <div class="stat">
                                    <span class="number">{{ $course->trainer ? $course->trainer->taughtCourses()->count() : '5' }}</span>
                                    <span class="label">كورس</span>
                                </div>
                                <div class="stat">
                                    <span class="number">{{ $course->trainer ? $course->trainer->reviews()->count() : '120' }}</span>
                                    <span class="label">تقييم</span>
                                </div>
                                <div class="stat">
                                    <span class="number">{{ $course->trainer ? $course->trainer->taughtCourses()->withCount('students')->get()->sum('students_count') : '500' }}</span>
                                    <span class="label">طالب</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="instructor-bio">
                        {{ $course->trainer ? $course->trainer->bio : 'مدرب محترف بخبرة واسعة في المجال.' }}
                    </p>
                </div>

                <!-- الكورسات المقترحة -->
                <div class="sidebar-card">
                    <h3>كورسات مقترحة</h3>
                    <div class="suggested-courses">
                        @foreach($relatedCourses as $relatedCourse)
                            <div class="suggested-course-item">
                                <img src="{{ $relatedCourse->image_url }}" alt="{{ $relatedCourse->title }}">
                                <div class="suggested-course-info">
                                    <h4><a href="{{ route('courses.show', $relatedCourse) }}">{{ Str::limit($relatedCourse->title, 40) }}</a></h4>
                                    <div class="suggested-course-meta">
                                        <span class="price">{{ $relatedCourse->formatted_price }}</span>
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            {{ number_format($relatedCourse->reviews_avg_rating, 1) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // تفعيل الأكورديون لمحتوى الكورس
    const accordionHeaders = document.querySelectorAll('.accordion-header');
    
    accordionHeaders.forEach(header => {
        header.addEventListener('click', function() {
            this.parentElement.classList.toggle('active');
        });
    });
    
    // تفعيل عدادات الإحصائيات
    const counterElements = document.querySelectorAll('.stat .number');
    
    counterElements.forEach(element => {
        const target = parseInt(element.textContent);
        let current = 0;
        const duration = 2000;
        const increment = target / (duration / 16);
        
        const updateCounter = () => {
            current += increment;
            if (current < target) {
                element.textContent = Math.floor(current);
                requestAnimationFrame(updateCounter);
            } else {
                element.textContent = target;
            }
        };
        
        updateCounter();
    });
});
</script>
@endsection