@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center py-3">
        <h2 class="fw-bold mb-0">لوحة تحكم الأدمن</h2>
        <div>
            <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>إضافة كورس جديد
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <!-- إحصائيات سريعة -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                عدد الكورسات</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Course::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                عدد الطلاب</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\User::where('role', 'student')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                عدد التسجيلات</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Enrollment::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                عدد المدربين</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\User::where('role', 'trainer')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Recent Data -->
    <div class="row">
        <!-- Courses Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">عدد الطلاب في كل كورس</h6>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="allCoursesChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">آخر الكورسات المضافة</h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach(\App\Models\Course::latest()->take(5)->get() as $course)
                        <div class="list-group-item d-flex align-items-center">
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">{{ $course->title }}</h6>
                                <small class="text-muted">{{ $course->created_at->diffForHumans() }}</small>
                            </div>
                            <span class="badge bg-primary rounded-pill">{{ $course->students_count }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">إجراءات سريعة</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary mb-2">
                            <i class="fas fa-plus me-2"></i>إضافة كورس جديد
                        </a>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-success mb-2">
                            <i class="fas fa-tag me-2"></i>إضافة تصنيف جديد
                        </a>
                        <a href="#" class="btn btn-warning mb-2">
                            <i class="fas fa-user-plus me-2"></i>إضافة مدرب جديد
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Bar Chart
        const ctx = document.getElementById('allCoursesChart').getContext('2d');
        const courses = @json(\App\Models\Course::withCount('students')->get());
        
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: courses.map(course => course.title),
                datasets: [{
                    label: 'عدد الطلاب',
                    data: courses.map(course => course.students_count),
                    backgroundColor: 'rgba(78, 115, 223, 0.7)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'عدد الطلاب'
                        }
                    }
                }
            }
        });

        // Sidebar Toggle
        $('#sidebarToggle').click(function() {
            $('#sidebar').toggleClass('collapsed');
            $('.content').toggleClass('expanded');
        });
    });
</script>
@endsection