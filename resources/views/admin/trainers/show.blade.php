@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center py-3">
        <h2 class="fw-bold mb-0">تفاصيل المدرب</h2>
        <div>
            <a href="{{ route('admin.trainers.edit', $trainer->id) }}" class="btn btn-primary me-2">
                <i class="fas fa-edit me-2"></i> تعديل
            </a>
            <a href="{{ route('admin.trainers.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> رجوع للقائمة
            </a>
        </div>
    </div>

    <div class="row">
        <!-- العمود الأول: المعلومات الأساسية - تم التعديل -->
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100 border-0">
                <div class="card-header bg-primary text-white py-3 text-center" style="border-radius: 0.5rem 0.5rem 0 0;">
                    <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i>المعلومات الشخصية</h5>
                </div>
                <div class="card-body text-center">
                    <!-- صورة المدرب -->
                    <div class="mb-4 position-relative">
                        @if($trainer->profile_photo_path)
                            <img src="{{ asset('storage/' . $trainer->profile_photo_path) }}" 
                                 alt="صورة المدرب" 
                                 class="img-fluid rounded-circle shadow" 
                                 style="width: 180px; height: 180px; object-fit: cover; border: 5px solid #e9ecef;">
                        @else
                            <div class="rounded-circle bg-gradient-primary d-flex align-items-center justify-content-center mx-auto" 
                                 style="width: 180px; height: 180px; background: linear-gradient(135deg, #4e73df, #224abe);">
                                <i class="fas fa-user fa-4x text-white"></i>
                            </div>
                        @endif
                        <!-- حالة التفعيل داخل الصورة -->
                        <span class="position-absolute bottom-0 start-50 translate-middle badge {{ $trainer->is_approved ? 'bg-success' : 'bg-warning' }} p-2" style="font-size: 0.75rem;">
                            <i class="fas {{ $trainer->is_approved ? 'fa-check-circle' : 'fa-clock' }} me-1"></i>
                            {{ $trainer->is_approved ? 'مفعل' : 'بانتظار التفعيل' }}
                        </span>
                    </div>
                    
                    <!-- الاسم -->
                    <h3 class="fw-bold text-primary mb-2">{{ $trainer->name }}</h3>
                    
                    <!-- التخصص -->
                    <div class="d-flex align-items-center justify-content-center mb-4">
                        <span class="bg-light-primary text-primary p-2 rounded-circle me-2">
                            <i class="fas fa-graduation-cap"></i>
                        </span>
                        <span class="text-dark fw-medium">{{ $trainer->expertise }}</span>
                    </div>
                    
                    <!-- معلومات الاتصال -->
                    <div class="bg-light rounded-3 p-3 mb-3">
                        <div class="d-flex align-items-center mb-3 p-2 bg-white rounded-3 shadow-sm">
                            <div class="bg-primary p-3 rounded-circle me-3">
                                <i class="fas fa-envelope text-white"></i>
                            </div>
                            <div class="text-start">
                                <small class="text-muted d-block">البريد الإلكتروني</small>
                                <a href="mailto:{{ $trainer->email }}" class="text-dark fw-medium text-decoration-none">{{ $trainer->email }}</a>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center p-2 bg-white rounded-3 shadow-sm">
                            <div class="bg-primary p-3 rounded-circle me-3">
                                <i class="fas fa-phone text-white"></i>
                            </div>
                            <div class="text-start">
                                <small class="text-muted d-block">رقم الهاتف</small>
                                <a href="tel:{{ $trainer->phone }}" class="text-dark fw-medium text-decoration-none">{{ $trainer->phone }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- العمود الثاني: التفاصيل الإضافية - لم يتغير -->
        <div class="col-md-8">
            <!-- نبذة عن المدرب -->
            <div class="card shadow mb-4">
                <div class="card-header bg-info text-white py-3">
                    <h5 class="mb-0">نبذة عن المدرب</h5>
                </div>
                <div class="card-body">
                    @if($trainer->bio)
                        <div class="bg-light p-4 rounded">
                           {!! nl2br(strip_tags($trainer->bio, '<strong><em><p><ul><ol><li><a>')) !!}
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-info-circle fa-2x mb-2"></i>
                            <p>لا توجد نبذة عن هذا المدرب</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- إحصائيات المدرب -->
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card shadow border-0 bg-gradient-primary text-white">
                        <div class="card-body text-center py-4">
                            <i class="fas fa-book-open fa-3x mb-3"></i>
                            <h2 class="fw-bold">{{ $trainer->taughtCourses->count() }}</h2>
                            <p class="mb-0">الكورسات المقدمة</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4">
                    <div class="card shadow border-0 bg-gradient-success text-white">
                        <div class="card-body text-center py-4">
                            <i class="fas fa-users fa-3x mb-3"></i>
                            <h2 class="fw-bold">
                                {{ $trainer->taughtCourses->sum(function($course) {
                                    return $course->students->count();
                                }) }}
                            </h2>
                            <p class="mb-0">الطلاب المسجلين</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- الكورسات التي يقدمها المدرب -->
            <div class="card shadow">
                <div class="card-header bg-warning text-dark py-3">
                    <h5 class="mb-0">الكورسات التي يقدمها</h5>
                </div>
                <div class="card-body">
                    @if($trainer->taughtCourses->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>اسم الكورس</th>
                                        <th>السعر</th>
                                        <th>عدد الطلاب</th>
                                        <th>التقييم</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($trainer->taughtCourses as $course)
                                        <tr>
                                            <td>{{ $course->title }}</td>
                                            <td>
                                                <span class="badge bg-success">{{ $course->formatted_price }}</span>
                                            </td>
                                            <td>{{ $course->students->count() }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="text-warning me-1">
                                                        <i class="fas fa-star"></i>
                                                    </span>
                                                    <span>{{ number_format($course->average_rating, 1) }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.courses.show', $course->id) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-book-open fa-2x mb-2"></i>
                            <p>لا يوجد كورسات لهذا المدرب بعد</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(45deg, #4e73df, #224abe);
    }
    
    .bg-gradient-success {
        background: linear-gradient(45deg, #1cc88a, #13855c);
    }
    
    .card {
        border: none;
        border-radius: 0.5rem;
    }
    
    .card-header {
        border-radius: 0.5rem 0.5rem 0 0 !important;
        border: none;
    }
    
    .badge {
        font-size: 0.85rem;
    }
    
    .bg-light-primary {
        background-color: rgba(78, 115, 223, 0.15) !important;
    }
</style>
@endsection