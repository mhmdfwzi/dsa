@extends('frontend.layouts.app')

@section('title', $course->title . ' - أكاديمية المهارات الرقمية')

@section('content')
<!-- قسم رأس الكورس -->
<section class="course-header-section">
    <div class="container">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">الكورسات</a></li>
                @if($course->category)
                <li class="breadcrumb-item"><a href="{{ route('courses.byCategory', $course->category) }}">{{ $course->category->name }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $course->title }}</li>
            </ol>
        </nav>
        
        <div class="course-header-content">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="course-title">{{ $course->title }}</h1>
                    <p class="course-excerpt">{{ Str::limit($course->description, 150) }}</p>
                    
                    <div class="course-meta-info">
                        <div class="meta-item">
                            <i class="fas fa-users"></i>
                            <span>{{ $course->students_count }} طالب</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-star"></i>
                            <span>{{ number_format($course->reviews_avg_rating, 1) }} ({{ $course->reviews_count }} تقييم)</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-clock"></i>
                            <span>{{ $course->duration }} ساعة</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-signal"></i>
                            <span>{{ $course->level_text }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="course-image-wrapper">
                        <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="course-main-image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container course-detail-container">
    <div class="row">
        <!-- المحتوى الرئيسي -->
        <div class="col-lg-8">
            <!-- معلومات الكورس -->
            <div class="course-card">
                <div class="card-header">
                    <h3><i class="fas fa-info-circle me-2"></i>عن هذا الكورس</h3>
                </div>
                <div class="card-body">
                    <p class="course-description">{{ $course->description }}</p>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h4><i class="fas fa-trophy me-2"></i>ما سوف تتعلمه</h4>
                            <ul class="features-list">
                                <li><i class="fas fa-check"></i>مهارات الحاسب الآلي الأساسية</li>
                                <li><i class="fas fa-check"></i>معالجة النصوص باستخدام Word</li>
                                <li><i class="fas fa-check"></i>العروض التقديمية بـ Power Point</li>
                                <li><i class="fas fa-check"></i>الجداول الحسابية باستخدام Excel</li>
                                <li><i class="fas fa-check"></i>أساسيات قواعد البيانات بـ Access</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h4><i class="fas fa-tasks me-2"></i>متطلبات الكورس</h4>
                            <ul class="features-list">
                                <li><i class="fas fa-check-circle"></i>معرفة أساسية بالكمبيوتر</li>
                                <li><i class="fas fa-check-circle"></i>اتصال بالإنترنت</li>
                                <li><i class="fas fa-check-circle"></i>رغبة في التعلم</li>
                                <li><i class="fas fa-check-circle"></i>جهاز كمبيوتر شخصي</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- محتوى الكورس -->
            <div class="course-card">
                <div class="card-header">
                    <h3><i class="fas fa-play-circle me-2"></i>محتوى الكورس</h3>
                </div>
                <div class="card-body">
                    <div class="accordion course-accordion" id="courseAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#week1">
                                    الأسبوع الأول: أساسيات الحاسب الآلي
                                </button>
                            </h2>
                            <div id="week1" class="accordion-collapse collapse show" data-bs-parent="#courseAccordion">
                                <div class="accordion-body">
                                    <ul class="lesson-list">
                                        <li class="lesson-item">
                                            <span><i class="fas fa-play-circle"></i>مقدمة إلى أنظمة التشغيل</span>
                                            <span class="lesson-duration">25 دقيقة</span>
                                        </li>
                                        <li class="lesson-item">
                                            <span><i class="fas fa-play-circle"></i>إدارة الملفات والمجلدات</span>
                                            <span class="lesson-duration">30 دقيقة</span>
                                        </li>
                                        <li class="lesson-item">
                                            <span><i class="fas fa-play-circle"></i>الإعدادات الأساسية</span>
                                            <span class="lesson-duration">20 دقيقة</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#week2">
                                    الأسبوع الثاني: معالجة النصوص
                                </button>
                            </h2>
                            <div id="week2" class="accordion-collapse collapse" data-bs-parent="#courseAccordion">
                                <div class="accordion-body">
                                    <ul class="lesson-list">
                                        <li class="lesson-item">
                                            <span><i class="fas fa-play-circle"></i>أساسيات برنامج Word</span>
                                            <span class="lesson-duration">40 دقيقة</span>
                                        </li>
                                        <li class="lesson-item">
                                            <span><i class="fas fa-play-circle"></i>تنسيق النصوص والفقرات</span>
                                            <span class="lesson-duration">35 دقيقة</span>
                                        </li>
                                        <li class="lesson-item">
                                            <span><i class="fas fa-play-circle"></i>إنشاء الجداول والقوائم</span>
                                            <span class="lesson-duration">45 دقيقة</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- التسجيل في الكورس -->
            <div class="course-card">
                <div class="card-body text-center">
                    <h3 class="card-title">انضم إلى الكورس الآن وابدأ رحلة التعلم</h3>
                    <p class="card-text">سجل في هذا الكورس واحصل على فرصة لتعلم مهارات الحاسب الآلي الأساسية التي ستفتح لك آفاقاً جديدة في عالم التكنولوجيا</p>
                    
                    @auth
                        @if($isEnrolled)
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>
                                أنت مسجل في هذا الكورس بالفعل
                                @if($enrollmentStatus === 'pending')
                                    <span class="d-block mt-2">حالة التسجيل: في انتظار الموافقة</span>
                                @elseif($enrollmentStatus === 'approved')
                                    <span class="d-block mt-2">حالة التسجيل: تمت الموافقة</span>
                                @endif
                            </div>
                        @else
                            <form action="{{ route('courses.enroll', $course) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn enroll-btn">
                                    <i class="fas fa-user-graduate me-2"></i>سجل في الكورس الآن - {{ $course->formatted_price }}
                                </button>
                            </form>
                        @endif
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <a href="{{ route('login') }}" class="alert-link">سجل الدخول</a> لتتمكن من التسجيل في هذا الكورس
                        </div>
                    @endauth
                </div>
            </div>

            <!-- التقييمات -->
            <div class="course-card">
                <div class="card-header">
                    <h3><i class="fas fa-star me-2"></i>تقييمات الطلاب</h3>
                </div>
                <div class="card-body">
                    @if($course->reviews_count > 0)
                        <div class="row mb-4">
                            <div class="col-md-4 text-center">
                                <div class="average-rating">
                                    {{ number_format($course->reviews_avg_rating, 1) }}
                                </div>
                                <div class="rating-stars mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= round($course->reviews_avg_rating))
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <p>{{ $course->reviews_count }} تقييم</p>
                            </div>
                            <div class="col-md-8">
                                @for($i = 5; $i >= 1; $i--)
                                    @php
                                        $count = $course->reviews->where('rating', $i)->count();
                                        $percentage = $course->reviews_count > 0 ? ($count / $course->reviews_count) * 100 : 0;
                                    @endphp
                                    <div class="rating-bar-container">
                                        <div class="rating-label">{{ $i }} <i class="fas fa-star"></i></div>
                                        <div class="rating-bar">
                                            <div class="rating-progress" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <div class="rating-percentage">{{ number_format($percentage, 0) }}%</div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        
                        <div class="reviews-list">
                            @foreach($course->reviews as $review)
                                <div class="review-item">
                                    <div class="review-header">
                                        <div class="reviewer-info">
                                            <div class="reviewer-avatar">
                                                {{ substr($review->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <h6 class="reviewer-name">{{ $review->user->name }}</h6>
                                                <small class="review-date">{{ $review->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                        <div class="review-rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="review-content">{{ $review->comment }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-reviews">
                            <i class="fas fa-comment-slash"></i>
                            <p>لا توجد تقييمات لهذا الكورس بعد</p>
                        </div>
                    @endif
                    
                    <!-- نموذج إضافة تقييم -->
                    @auth
                        @if($isEnrolled && $enrollmentStatus === 'approved')
                            <div class="add-review-section">
                                <h4>أضف تقييمك</h4>
                                <form action="{{ route('courses.review', $course) }}" method="POST">
                                    @csrf
                                    <div class="rating-input">
                                        <label>التقييم</label>
                                        <div class="stars-container" id="ratingStars">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="far fa-star" data-value="{{ $i }}"></i>
                                            @endfor
                                        </div>
                                        <input type="hidden" name="rating" id="selectedRating" required>
                                    </div>
                                    <div class="review-form-group">
                                        <label for="comment">تعليقك</label>
                                        <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">إرسال التقييم</button>
                                </form>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <a href="{{ route('login') }}" class="alert-link">سجل الدخول</a> لإضافة تقييمك
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        <!-- الشريط الجانبي -->
        <div class="col-lg-4">
            <!-- معلومات التسجيل -->
            <div class="sidebar-card">
                <div class="card-header">
                    <h4>انضم إلى الكورس الآن</h4>
                </div>
                <div class="card-body">
                    <div class="course-price">{{ $course->formatted_price }}</div>
                    <ul class="course-features">
                        <li><i class="fas fa-video"></i>{{ $course->duration }} ساعة فيديو</li>
                        <li><i class="fas fa-file-alt"></i>15 مصدر قابل للتحميل</li>
                        <li><i class="fas fa-infinity"></i>وصول كامل مدى الحياة</li>
                        <li><i class="fas fa-mobile-alt"></i>وصول على الهاتف والتلفزيون</li>
                        <li><i class="fas fa-certificate"></i>شهادة إتمام</li>
                    </ul>
                    
                    @auth
                        @if($isEnrolled)
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>
                                أنت مسجل في هذا الكورس بالفعل
                            </div>
                        @else
                            <form action="{{ route('courses.enroll', $course) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn enroll-btn-sidebar">
                                    <i class="fas fa-shopping-cart me-2"></i>اشترك الآن
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn enroll-btn-sidebar">
                            <i class="fas fa-shopping-cart me-2"></i>اشترك الآن
                        </a>
                    @endauth
                    
                    <p class="guarantee-text">ضمان استرداد الأموال خلال 30 يوم</p>
                </div>
            </div>

            <!-- المدرب -->
            <div class="sidebar-card">
                <div class="card-header">
                    <h4>المدرب</h4>
                </div>
                <div class="card-body text-center">
                    @if($course->trainer)
                        <img src="{{ $course->trainer->profile_photo_url }}" alt="{{ $course->trainer->name }}" class="trainer-avatar">
                        <h5 class="trainer-name">{{ $course->trainer->name }}</h5>
                        <p class="trainer-expertise">{{ $course->trainer->expertise }}</p>
                        <div class="trainer-social">
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                        </div>
                        <p class="trainer-bio">{{ Str::limit($course->trainer->bio, 120) }}</p>
                        <a href="#" class="btn btn-outline-primary btn-sm">عرض جميع كورسات المدرب</a>
                    @elseif($course->instructor_name)
                        <div class="instructor-avatar">
                            {{ substr($course->instructor_name, 0, 1) }}
                        </div>
                        <h5 class="trainer-name">{{ $course->instructor_name }}</h5>
                        <p class="trainer-expertise">مدرب معتمد بخبرة واسعة في المجال</p>
                    @else
                        <div class="instructor-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <h5 class="trainer-name">مدرب محترف</h5>
                        <p class="trainer-expertise">مدرب معتمد بخبرة واسعة في المجال</p>
                    @endif
                </div>
            </div>

            <!-- الكورسات المرتبطة -->
            <div class="sidebar-card">
                <div class="card-header">
                    <h4>كورسات ذات صلة</h4>
                </div>
                <div class="card-body">
                    @foreach($relatedCourses as $relatedCourse)
                        <div class="related-course">
                            <img src="{{ $relatedCourse->image_url }}" alt="{{ $relatedCourse->title }}" class="related-course-image">
                            <div class="related-course-info">
                                <h6>{{ Str::limit($relatedCourse->title, 40) }}</h6>
                                <div class="related-course-meta">
                                    <span class="related-course-price">{{ $relatedCourse->formatted_price }}</span>
                                    <a href="{{ route('courses.show', $relatedCourse) }}" class="btn btn-sm btn-outline-primary">عرض</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // تفعيل نظام التقييم بالنجوم
        const stars = document.querySelectorAll('.stars-container .fa-star');
        const selectedRatingInput = document.getElementById('selectedRating');
        
        if (stars.length > 0 && selectedRatingInput) {
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');
                    selectedRatingInput.value = value;
                    
                    stars.forEach(s => {
                        if (s.getAttribute('data-value') <= value) {
                            s.classList.remove('far');
                            s.classList.add('fas');
                        } else {
                            s.classList.remove('fas');
                            s.classList.add('far');
                        }
                    });
                });
            });
        }
        
        // تأثيرات التمرير للبطاقات
        const cards = document.querySelectorAll('.course-card, .sidebar-card');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = 1;
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });
        
        cards.forEach(card => {
            card.style.opacity = 0;
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(card);
        });
    });
</script>
@endsection