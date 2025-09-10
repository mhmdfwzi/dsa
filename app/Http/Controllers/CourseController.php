<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * عرض كل الكورسات للطالب أو الزائر مع إمكانية التصفية حسب التصنيف
     */
    public function index(Request $request)
    {
        $query = Course::withCount(['students', 'reviews'])
                      ->withAvg('reviews', 'rating');
        
        // التصفية حسب التصنيف إذا تم تحديده
        if ($request->has('category') && $request->category != 'all') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        // البحث إذا تم تقديمه
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }
        
        // التصنيف حسب الأحدث أو الأعلى تقييماً
        $sort = $request->get('sort', 'latest');
        if ($sort === 'rating') {
            $query->orderByDesc('reviews_avg_rating');
        } else {
            $query->latest();
        }
        
        $courses = $query->paginate(12);
        $categories = Category::all();
        
        return view('courses.index', compact('courses', 'categories'));
    }

    /**
     * عرض تفاصيل كورس واحد
     */
    public function show(Course $course)
    {
        // تحميل التقييمات مع مستخدميها والطلاب والمعلومات الإضافية
        $course->load([
            'reviews.user', 
            'students',
            'enrollments',
            'category',
            'trainer'
        ]);
        
        // تحميل متوسط التقييم وعدد التقييمات
        $course->loadAvg('reviews', 'rating');
        $course->loadCount('reviews');
        
        // الحصول على الكورسات المرتبطة (نفس التصنيف أو نفس المدرب)
        $relatedCourses = Course::where('id', '!=', $course->id)
            ->where(function($query) use ($course) {
                // نفس التصنيف
                if ($course->category_id) {
                    $query->where('category_id', $course->category_id);
                }
                
                // أو نفس المدرب
                if ($course->trainer_id) {
                    $query->orWhere('trainer_id', $course->trainer_id);
                }
                
                // أو عشوائية إذا لم يكن هناك تصنيف أو مدرب
                if (!$course->category_id && !$course->trainer_id) {
                    $query->inRandomOrder();
                }
            })
            ->withCount(['students', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->take(4)
            ->get();

        // التحقق إذا كان المستخدم مسجلاً في هذا الكورس
        $isEnrolled = false;
        $enrollmentStatus = null;
        
        if (Auth::check()) {
            $enrollment = Enrollment::where('user_id', Auth::id())
                                  ->where('course_id', $course->id)
                                  ->first();
            
            if ($enrollment) {
                $isEnrolled = in_array($enrollment->status, ['pending', 'approved']);
                $enrollmentStatus = $enrollment->status;
            }
        }

        return view('frontend.courses.show', compact('course', 'relatedCourses', 'isEnrolled', 'enrollmentStatus'));
    }

    /**
     * تسجيل الطالب في الكورس
     */
    public function enroll(Course $course)
    {
        $user = Auth::user();

        // التحقق المباشر من دور المستخدم (بدون استخدام isStudent())
        if ($user->role !== 'student') {
            return back()->with('error', 'يجب أن تكون طالباً للتسجيل في الكورسات');
        }

        // التحقق إذا كان مسجل بالفعل ونشط
        $existingEnrollment = Enrollment::where('user_id', $user->id)
                                      ->where('course_id', $course->id)
                                      ->whereIn('status', ['pending', 'approved'])
                                      ->first();

        if ($existingEnrollment) {
            $statusText = $existingEnrollment->status === 'approved' ? 'مسجل' : 'في انتظار الموافقة';
            return back()->with('info', "أنت بالفعل $statusText في هذا الكورس");
        }

        // التحقق إذا كان الكورس مجاني أو مدفوع
        if ($course->price > 0) {
            // هنا يمكن إضافة منطق الدفع
            return back()->with('info', 'هذا الكورس مدفوع، سيتم توجيهك إلى صفحة الدفع قريباً');
        }

        // إنشاء تسجيل جديد للكورس المجاني
        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => $course->requires_approval ? 'pending' : 'approved',
        ]);

        $message = $course->requires_approval 
            ? 'تم تسجيلك في الكورس بنجاح، في انتظار الموافقة' 
            : 'تم تسجيلك في الكورس بنجاح';

        return back()->with('success', $message);
    }

    /**
     * عرض الكورسات حسب التصنيف
     */
    public function byCategory(Category $category)
    {
        $courses = Course::where('category_id', $category->id)
                        ->withCount(['students', 'reviews'])
                        ->withAvg('reviews', 'rating')
                        ->latest()
                        ->paginate(12);
        
        $categories = Category::all();
        
        return view('courses.index', compact('courses', 'categories', 'category'));
    }

    /**
     * البحث في الكورسات
     */
    public function search(Request $request)
    {
        $query = Course::withCount(['students', 'reviews'])
                      ->withAvg('reviews', 'rating');
        
        if ($request->has('q') && !empty($request->q)) {
            $searchTerm = $request->q;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('category', function($q) use ($searchTerm) {
                      $q->where('name', 'like', '%' . $searchTerm . '%');
                  });
            });
        }
        
        if ($request->has('category') && $request->category != 'all') {
            $query->where('category_id', $request->category);
        }
        
        $courses = $query->latest()->paginate(12);
        $categories = Category::all();
        
        return view('courses.index', compact('courses', 'categories'));
    }

}