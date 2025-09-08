@extends('frontend.layouts.app')

@section('title', $course->title)

@section('content')
<div class="course-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">الرئيسية</a></li>
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">الكورسات</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">{{ $course->title }}</li>
            </ol>
        </nav>
        
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-4 fw-bold">{{ $course->title }}</h1>
                <p class="lead">{{ Str::limit($course->description, 150) }}</p>
                
                <div class="d-flex flex-wrap gap-3 mb-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-users me-2"></i>
                        <span>{{ $course->students->count() }} طالب</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-star me-2 rating-star"></i>
                        <span>{{ number_format($course->reviews->avg('rating'), 1) }} ({{ $course->reviews->count() }} تقييم)</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-clock me-2"></i>
                        <span>10 ساعات</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="img-fluid rounded shadow" style="max-height: 200px;">
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <!-- المحتوى الرئيسي -->
        <div class="col-lg-8">
            <!-- معلومات الكورس -->
            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="card-title">عن هذا الكورس</h3>
                    <p class="card-text">{{ $course->description }}</p>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>ما سوف تتعلمه</h5>
                            <ul>
                                <li>مهارة أساسية في المجال</li>
                                <li>تقنيات متقدمة للتطبيق</li>
                                <li>أفضل الممارسات المهنية</li>
                                <li>مشاريع عملية تطبيقية</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>متطلبات الكورس</h5>
                            <ul>
                                <li>معرفة أساسية بالكمبيوتر</li>
                                <li>اتصال بالإنترنت</li>
                                <li>رغبة في التعلم</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- التسجيل في الكورس -->
            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="card-title">انضم إلى الكورس</h3>
                    @auth
                        @if(auth()->user()->enrollments->where('course_id', $course->id)->whereIn('status', ['pending', 'approved'])->count())
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>
                                أنت مسجل في هذا الكورس بالفعل
                            </div>
                        @else
                            <form action="{{ route('courses.enroll', $course) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-user-graduate me-2"></i>
                                    سجل في الكورس الآن
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
            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="card-title">تقييمات الطلاب</h3>
                    
                    @if($course->reviews->count() > 0)
                        <div class="row mb-4">
                            <div class="col-md-4 text-center">
                                <div class="display-4 fw-bold text-warning">
                                    {{ number_format($course->reviews->avg('rating'), 1) }}
                                </div>
                                <div class="rating mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= round($course->reviews->avg('rating')))
                                            <i class="fas fa-star rating-star"></i>
                                        @else
                                            <i class="far fa-star rating-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <p>{{ $course->reviews->count() }} تقييم</p>
                            </div>
                            <div class="col-md-8">
                                @for($i = 5; $i >= 1; $i--)
                                    @php
                                        $count = $course->reviews->where('rating', $i)->count();
                                        $percentage = $course->reviews->count() > 0 ? ($count / $course->reviews->count()) * 100 : 0;
                                    @endphp
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="me-2" style="width: 30px;">{{ $i }} <i class="fas fa-star"></i></div>
                                        <div class="progress flex-grow-1" style="height: 10px;">
                                            <div class="progress-bar bg-warning" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <div class="ms-2" style="width: 40px;">{{ number_format($percentage, 0) }}%</div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        
                        <div class="reviews-list">
                            @foreach($course->reviews as $review)
                                <div class="review-item border-bottom pb-3 mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                                {{ substr($review->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $review->user->name }}</h6>
                                                <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                        <div class="rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fas fa-star rating-star"></i>
                                                @else
                                                    <i class="far fa-star rating-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="mb-0">{{ $review->comment }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-comment-slash fa-3x text-muted mb-3"></i>
                            <p class="text-muted">لا توجد تقييمات لهذا الكورس بعد</p>
                        </div>
                    @endif
                    
                    <!-- نموذج إضافة تقييم -->
                    @auth
                        @if(auth()->user()->enrollments->where('course_id', $course->id)->where('status', 'approved')->count())
                            <div class="mt-4">
                                <h4>أضف تقييمك</h4>
                                <form action="{{ route('courses.review', $course) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="rating" class="form-label">التقييم</label>
                                        <select class="form-select" id="rating" name="rating" required>
                                            <option value="">اختر التقييم...</option>
                                            <option value="5">5 نجوم - ممتاز</option>
                                            <option value="4">4 نجوم - جيد جداً</option>
                                            <option value="3">3 نجوم - جيد</option>
                                            <option value="2">2 نجوم - مقبول</option>
                                            <option value="1">1 نجوم - ضعيف</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="comment" class="form-label">تعليقك</label>
                                        <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">إرسال التقييم</button>
                                </form>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info mt-4">
                            <i class="fas fa-info-circle me-2"></i>
                            <a href="{{ route('login') }}" class="alert-link">سجل الدخول</a> لإضافة تقييمك
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        <!-- الشريط الجانبي -->
        <div class="col-lg-4">
            <!-- الكورسات المرتبطة -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">كورسات ذات صلة</h5>
                </div>
                <div class="card-body">
                    @php
                        $relatedCourses = App\Models\Course::where('id', '!=', $course->id)
                            ->inRandomOrder()
                            ->limit(3)
                            ->get();
                    @endphp
                    
                    @foreach($relatedCourses as $relatedCourse)
                        <div class="related-course-card card mb-3">
                            <img src="{{ $relatedCourse->image_url }}" class="card-img-top" alt="{{ $relatedCourse->title }}" style="height: 120px; object-fit: cover;">
                            <div class="card-body">
                                <h6 class="card-title">{{ Str::limit($relatedCourse->title, 40) }}</h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-primary fw-bold">{{ $relatedCourse->formatted_price }}</span>
                                    <a href="{{ route('courses.show', $relatedCourse) }}" class="btn btn-sm btn-outline-primary">عرض</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- معلومات المدرب -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">معلومات المدرب</h5>
                </div>
                <div class="card-body text-center">
                    <div class="avatar bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                        {{ substr($course->instructor_name ?? 'مدرب', 0, 1) }}
                    </div>
                    <h5>{{ $course->instructor_name ?? 'مدرب محترف' }}</h5>
                    <p class="text-muted">مدرب معتمد بخبرة واسعة في المجال</p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="#" class="text-dark"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-dark"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-dark"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>

            <!-- إحصائيات الكورس -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">إحصائيات الكورس</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>عدد الطلاب:</span>
                        <strong>{{ $course->students->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>عدد التقييمات:</span>
                        <strong>{{ $course->reviews->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>المدة:</span>
                        <strong>10 ساعات</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>المستوى:</span>
                        <strong>مبتدئ - متوسط</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // أي سكريبتات إضافية يمكن إضافتها هنا
    });
</script>
@endsection