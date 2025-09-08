<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>أكاديمية المهارات الرقمية - الكورسات المتاحة</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --secondary: #7c3aed;
            --light: #f5f3ff;
            --dark: #1e1b4b;
            --success: #10b981;
            --warning: #f59e0b;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Tajawal', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f0f4ff 0%, #fdf2ff 100%);
            color: #334155;
            min-height: 100vh;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        /* تحسين الهيدر */
        .header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 3rem 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .header::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%23ffffff' fill-opacity='0.1' d='M0,128L48,117.3C96,107,192,85,288,112C384,139,480,213,576,224C672,235,768,181,864,160C960,139,1056,149,1152,165.3C1248,181,1344,203,1392,213.3L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z'%3E%3C/path%3E%3C/svg%3E");
            background-size: cover;
            background-position: center;
        }
        
        .header-content {
            position: relative;
            z-index: 2;
        }
        
        .header h1 {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .header p {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        /* تحسين التنبيهات */
        .alert {
            padding: 1rem;
            border-radius: 0.75rem;
            margin: 1.5rem auto;
            max-width: 800px;
            text-align: center;
            font-weight: 500;
        }
        
        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        
        /* تحسين شبكة الكورسات */
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
            padding: 2rem 0;
        }
        
        .course-card {
            background: white;
            border-radius: 1.2rem;
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .course-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .course-image {
            height: 200px;
            width: 100%;
            object-fit: cover;
        }
        
        .course-content {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .course-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.75rem;
        }
        
        .course-description {
            color: #64748b;
            margin-bottom: 1.5rem;
            line-height: 1.6;
            flex-grow: 1;
        }
        
        .course-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .course-rating {
            color: var(--warning);
            font-weight: 500;
        }
        
        .course-price {
            color: var(--primary);
            font-weight: 700;
            font-size: 1.2rem;
        }
        
        .course-actions {
            display: flex;
            justify-content: space-between;
            gap: 0.75rem;
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 500;
            text-align: center;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            border: none;
            font-size: 1rem;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
        }
        
        .btn-success {
            background-color: var(--success);
            color: white;
        }
        
        .btn-success:hover {
            background-color: #0da271;
        }
        
        .btn-disabled {
            background-color: #cbd5e1;
            color: #64748b;
            cursor: not-allowed;
        }
        
        .btn-outline {
            background-color: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
        }
        
        .btn-outline:hover {
            background-color: var(--primary);
            color: white;
        }
        
        /* حالة عدم وجود كورسات */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            grid-column: 1 / -1;
        }
        
        .empty-state i {
            font-size: 4rem;
            color: #cbd5e1;
            margin-bottom: 1.5rem;
        }
        
        .empty-state p {
            font-size: 1.2rem;
            color: #64748b;
        }
        
        /* الفلاتر والبحث */
        .filters {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            margin: 1.5rem 0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .filter-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--dark);
        }
        
        .filter-options {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        .filter-option {
            background: var(--light);
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .filter-option:hover, .filter-option.active {
            background: var(--primary);
            color: white;
        }
        
        /* التذييل */
        .footer {
            background: var(--dark);
            color: white;
            padding: 3rem 0;
            margin-top: 4rem;
            text-align: center;
        }
        
        /* التكيف مع الشاشات الصغيرة */
        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }
            
            .courses-grid {
                grid-template-columns: 1fr;
            }
            
            .course-actions {
                flex-direction: column;
            }
            
            .filter-options {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- الهيدر -->
    <header class="header">
        <div class="container header-content">
            <h1>أكاديمية المهارات الرقمية</h1>
            <p>استكشف أفضل الدورات التدريبية لتطوير مهاراتك</p>
        </div>
    </header>

    <div class="container">
        <!-- تنبيه -->
        @if(session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <!-- فلاتر الكورسات -->
        <div class="filters">
            <h3 class="filter-title">تصفية الكورسات</h3>
            <div class="filter-options">
                <div class="filter-option active">جميع الكورسات</div>
                <div class="filter-option">التصميم</div>
                <div class="filter-option">البرمجة</div>
                <div class="filter-option">التسويق</div>
                <div class="filter-option">المجانية</div>
            </div>
        </div>

        <!-- شبكة الكورسات -->
        <div class="courses-grid">
            @forelse($courses as $course)
                <div class="course-card">
                    <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="course-image">
                    <div class="course-content">
                        <h3 class="course-title">{{ $course->title }}</h3>
                        <p class="course-description">{{ Str::limit($course->description, 120) }}</p>
                        <div class="course-meta">
                            <div class="course-rating">⭐ {{ number_format($course->average_rating, 1) }} ({{ $course->ratings_count }} تقييم)</div>
                            <div class="course-price">{{ number_format($course->price, 2) }} ج.م</div>
                        </div>
                        <div class="course-actions">
                            <a href="{{ route('courses.show', $course->id) }}" class="btn btn-primary">عرض التفاصيل</a>
                            
                            @auth
                                @if(auth()->user()->enrolledCourses->contains($course->id))
                                    <button class="btn btn-disabled" disabled>تم التسجيل</button>
                                @else
                                    <form action="{{ route('courses.enroll', $course->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success">سجل الآن</button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline">سجل الدخول</a>
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-book-open"></i>
                    <p>لا توجد كورسات متاحة حالياً. تحقق لاحقًا!</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- الفوتر -->
    <footer class="footer">
        <div class="container">
            <p>© 2023 أكاديمية المهارات الرقمية. جميع الحقوق محفوظة.</p>
        </div>
    </footer>

    <script>
        // كود JavaScript بسيط لإضافة التفاعل مع الفلاتر
        document.addEventListener('DOMContentLoaded', function() {
            const filterOptions = document.querySelectorAll('.filter-option');
            
            filterOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // إزالة النشاط من جميع الخيارات
                    filterOptions.forEach(opt => opt.classList.remove('active'));
                    
                    // إضافة النشاط للخيار المحدد
                    this.classList.add('active');
                    
                    // هنا يمكن إضافة كود تصفية الكورسات حسب الخيار
                    console.log('تم اختيار: ' + this.textContent);
                    
                    // يمكنك إضافة AJAX request هنا لتصفية الكورسات دون إعادة تحميل الصفحة
                });
            });
        });
    </script>
</body>
</html>