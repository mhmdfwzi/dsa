@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">إدارة التسجيلات</h5>
                    <div class="card-tools">
                        <a href="{{ route('admin.enrollments.statistics') }}" class="btn btn-info">
                            <i class="fas fa-chart-bar"></i> الإحصائيات
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- فلترة التسجيلات -->
                    <form method="GET" class="row mb-4">
                        <div class="col-md-3">
                            <select name="status" class="form-control" onchange="this.form.submit()">
                                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>جميع الحالات</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>معلق</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>مفعل</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="course_id" class="form-control" onchange="this.form.submit()">
                                <option value="all">جميع الكورسات</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <!-- جدول التسجيلات -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th>الطالب</th>
                                    <th>الكورس</th>
                                    <th>الحالة</th>
                                    <th>تاريخ التسجيل</th>
                                    <th>تاريخ الإكمال</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($enrollments as $enrollment)
                                    <tr>
                                        <td>{{ $enrollment->user->name }}</td>
                                        <td>{{ $enrollment->course->title }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($enrollment->status == 'pending') badge-warning
                                                @elseif($enrollment->status == 'approved') badge-success
                                                @elseif($enrollment->status == 'completed') badge-info
                                                @else badge-danger
                                                @endif">
                                                {{ $enrollment->getStatusTextAttribute() }}
                                            </span>
                                        </td>
                                        <td>{{ $enrollment->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $enrollment->completed_at ? $enrollment->completed_at->format('Y-m-d') : '--' }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <form method="POST" action="{{ route('admin.enrollments.update-status', $enrollment) }}">
                                                    @csrf
                                                    <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                                                        <option value="pending" {{ $enrollment->status == 'pending' ? 'selected' : '' }}>معلق</option>
                                                        <option value="approved" {{ $enrollment->status == 'approved' ? 'selected' : '' }}>مفعل</option>
                                                        <option value="completed" {{ $enrollment->status == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                                        <option value="cancelled" {{ $enrollment->status == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                                                    </select>
                                                </form>
                                                <form method="POST" action="{{ route('admin.enrollments.destroy', $enrollment) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">لا توجد تسجيلات</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- التصفح -->
                    <div class="d-flex justify-content-center">
                        {{ $enrollments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection