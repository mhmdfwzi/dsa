<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // جلب التصنيفات مع عدد الكورسات في كل تصنيف
        $categories = Category::withCount('courses')->get();
        
        // جلب الكورسات الشائعة (الأكثر طلاباً)
        $popularCourses = Course::withCount(['students', 'reviews'])
                              ->withAvg('reviews', 'rating')
                              ->orderByDesc('students_count')
                              ->take(6)
                              ->get();
        
        // جلب المدربين المميزين
        $featuredTrainers = User::where('role', 'trainer')
                              ->where('is_approved', true)
                              ->inRandomOrder()
                              ->take(4)
                              ->get();
        
        // الإحصائيات
        $coursesCount = Course::count();
        $studentsCount = User::where('role', 'student')->count();
        $trainersCount = User::where('role', 'trainer')->where('is_approved', true)->count();
        $hoursCount = Course::sum('duration') ?? 1000;
    $instructors = User::where('is_trainer', true)->take(6)->get(); // ✅ هنا التعديل        
        // آراء الطلاب (بيانات تجريبية - يمكن استبدالها ببيانات حقيقية لاحقاً)
        $testimonials = [
            [
                'name' => 'محمد أحمد',
                'course' => 'تدريب المرحلة الابتدائية',
                'comment' => 'كورس رائع ومفيد جداً، شرح المدرب واضح وسلس، والتمارين التطبيقية ساعدتني كثيراً في فهم المحتوى.',
                'image' => asset('images/testimonials/user1.jpg')
            ],
            [
                'name' => 'سارة عبدالله',
                'course' => 'كورس Excel متقدم',
                'comment' => 'تجربة تعليمية ممتازة، المحتوى غني ومتنوع، وأنصح الجميع بهذا الكورس خاصة للمبتدئين.',
                'image' => asset('images/testimonials/user2.jpg')
            ],
            [
                'name' => 'أحمد علي',
                'course' => 'كورس PowerPoint إحترافي',
                'comment' => 'المدرب محترف جداً والمحتوى شامل، استفدت كثيراً من التطبيقات العملية في عملي.',
                'image' => asset('images/testimonials/user3.jpg')
            ]
        ];
        
        return view('frontend.index', compact(
            'categories',
            'popularCourses',
            'featuredTrainers',
            'coursesCount',
            'studentsCount',
            'trainersCount',
            'hoursCount',
            'testimonials',
            'instructors' // ✅ هنا التعديل
        ));
    }
}