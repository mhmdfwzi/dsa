@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">إدارة الكورسات</h2>
        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> إضافة كورس جديد
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الصورة</th>
                            <th>اسم الكورس</th>
                            <th>التصنيف</th>
                            <th>المدرب</th>
                            <th>السعر</th>
                            <th>الطلاب</th>
                            <th>التقييم</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($courses as $course)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ $course->image_url }}" alt="{{ $course->title }}" 
                                         class="img-thumbnail" width="60" height="60">
                                </td>
                                <td>{{ $course->title }}</td>
                                <td>
                                    @if($course->category)
                                        <span class="badge bg-info">{{ $course->category->name }}</span>
                                    @else
                                        <span class="text-muted">بدون تصنيف</span>
                                    @endif
                                </td>
                                <td>
                                    @if($course->trainer)
                                        {{ $course->trainer->name }}
                                    @elseif($course->instructor_name)
                                        {{ $course->instructor_name }}
                                    @else
                                        <span class="text-muted">غير محدد</span>
                                    @endif
                                </td>
                                <td>{{ $course->formatted_price }}</td>
                                <td>{{ $course->students_count }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="text-warning me-1">
                                            <i class="fas fa-star"></i>
                                        </span>
                                        <span>{{ number_format($course->reviews_avg_rating, 1) }}</span>
                                        <small class="text-muted ms-1">({{ $course->reviews_count }})</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('courses.show', $course) }}" 
                                           class="btn btn-sm btn-outline-primary" target="_blank">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.courses.edit', $course) }}" 
                                           class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.courses.destroy', $course) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    onclick="return confirm('هل أنت متأكد من حذف هذا الكورس؟')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <i class="fas fa-book-open fa-2x text-muted mb-3"></i>
                                    <p class="text-muted">لا توجد كورسات حتى الآن</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $courses->links() }}
        </div>
    </div>
</div>
@endsection
