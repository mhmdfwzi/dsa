<nav id="sidebar" class="bg-dark text-white vh-100 position-fixed" style="width: 250px;">
    <div class="p-3">
        <h4 class="text-center">{{ config('app.name') }}</h4>
        <hr>
        
        <ul class="list-unstyled">
            <li class="mb-2">
                <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none p-2 d-block rounded {{ request()->routeIs('admin.dashboard') ? 'bg-primary' : '' }}">
                    <i class="fas fa-tachometer-alt me-2"></i> لوحة التحكم
                </a>
            </li>
            
            <li class="mb-2">
                <a href="{{ route('admin.courses.index') }}" class="text-white text-decoration-none p-2 d-block rounded {{ request()->routeIs('admin.courses.*') ? 'bg-primary' : '' }}">
                    <i class="fas fa-book me-2"></i> إدارة الكورسات
                </a>
            </li>
            
            <li class="mb-2">
                <a href="{{ route('admin.categories.index') }}" class="text-white text-decoration-none p-2 d-block rounded {{ request()->routeIs('admin.categories.*') ? 'bg-primary' : '' }}">
                    <i class="fas fa-tags me-2"></i> التصنيفات
                </a>
            </li>
            
            <li class="mb-2">
                <a href="{{ route('admin.enrollments.index') }}" class="text-white text-decoration-none p-2 d-block rounded {{ request()->routeIs('admin.enrollments.*') ? 'bg-primary' : '' }}">
                    <i class="fas fa-user-graduate me-2"></i> إدارة التسجيلات
                </a>
            </li>
            
<li class="mb-2">
    <a href="{{ route('admin.trainers.index') }}" 
       class="text-white text-decoration-none p-2 d-block rounded {{ request()->routeIs('admin.trainers.*') ? 'bg-primary' : '' }}">
        <i class="fas fa-chalkboard-teacher me-2"></i> المدربين
    </a>
</li>
            <li class="mb-2">
                <a href="{{ route('admin.reviews.index') }}" class="text-white text-decoration-none p-2 d-block rounded {{ request()->routeIs('admin.reviews.*') ? 'bg-primary' : '' }}">
                    <i class="fas fa-star me-2"></i> التقييمات
                </a>
            </li>
            
            <li class="mb-2">
                <a href="{{ route('admin.report.students') }}" class="text-white text-decoration-none p-2 d-block rounded {{ request()->routeIs('admin.report.*') ? 'bg-primary' : '' }}">
                    <i class="fas fa-chart-bar me-2"></i> التقارير
                </a>
            </li>
            
            <li class="mb-2">
                <a href="{{ route('home') }}" class="text-white text-decoration-none p-2 d-block rounded">
                    <i class="fas fa-home me-2"></i> العودة للموقع
                </a>
            </li>
        </ul>
    </div>
</nav>