<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use App\Models\Category;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminCourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['category', 'trainer'])
                        ->withCount(['students', 'reviews'])
                        ->withAvg('reviews', 'rating')
                        ->latest()
                        ->paginate(10);
        
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $categories = Category::all();
        $trainers = User::where('role', 'trainer')->where('is_approved', true)->get();
        
        return view('admin.courses.create', compact('categories', 'trainers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'trainer_id' => 'nullable|exists:users,id',
            'instructor_name' => 'nullable|string|max:255',
            'duration' => 'nullable|integer|min:1',
            'level' => 'nullable|in:beginner,intermediate,advanced',
            'requires_approval' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        // إذا لم يتم تحديد مدرب، استخدم instructor_name
        if (empty($data['trainer_id']) && empty($data['instructor_name'])) {
            return back()->withErrors(['instructor_name' => 'يجب تحديد مدرب أو إدخال اسم المدرب']);
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        // تحويل requires_approval إلى boolean
        $data['requires_approval'] = $request->has('requires_approval');

        Course::create($data);
        
        return redirect()->route('admin.courses.index')
            ->with('success', 'تم إضافة الكورس بنجاح');
    }

    public function edit(Course $course)
    {
        $categories = Category::all();
        $trainers = User::where('role', 'trainer')->where('is_approved', true)->get();
        
        return view('admin.courses.edit', compact('course', 'categories', 'trainers'));
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'trainer_id' => 'nullable|exists:users,id',
            'instructor_name' => 'nullable|string|max:255',
            'duration' => 'nullable|integer|min:1',
            'level' => 'nullable|in:beginner,intermediate,advanced',
            'requires_approval' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        // إذا لم يتم تحديد مدرب، استخدم instructor_name
        if (empty($data['trainer_id']) && empty($data['instructor_name'])) {
            return back()->withErrors(['instructor_name' => 'يجب تحديد مدرب أو إدخال اسم المدرب']);
        }

        if ($request->hasFile('image')) {
            if ($course->image) {
                Storage::disk('public')->delete($course->image);
            }
            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        // تحويل requires_approval إلى boolean
        $data['requires_approval'] = $request->has('requires_approval');

        $course->update($data);
        
        return redirect()->route('admin.courses.index')
            ->with('success', 'تم تعديل الكورس بنجاح');
    }

    public function destroy(Course $course)
    {
        if ($course->image) {
            Storage::disk('public')->delete($course->image);
        }
        
        $course->delete();
        
        return redirect()->route('admin.courses.index')
            ->with('success', 'تم حذف الكورس بنجاح');
    }

    public function dashboard()
    {
        $coursesCount = Course::count();
        $studentsCount = User::where('role', 'student')->count();
        $enrollmentsCount = Enrollment::count();

        $topCourses = Course::withCount('students')
            ->orderByDesc('students_count')
            ->take(5)
            ->get();

        $averageRatings = DB::table('reviews')
            ->select('course_id', DB::raw('ROUND(AVG(rating), 2) as avg_rating'))
            ->groupBy('course_id')
            ->get()
            ->keyBy('course_id');

        $latestCourses = Course::latest()->take(5)->withCount('students')->get();

        $enrollmentsByDate = Enrollment::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartLabels = $enrollmentsByDate->pluck('date')->map(fn($d) => Carbon::parse($d)->format('d M'))->toArray();
        $chartData = $enrollmentsByDate->pluck('count')->toArray();

        return view('admin.dashboard', compact(
            'coursesCount',
            'studentsCount',
            'enrollmentsCount',
            'topCourses',
            'averageRatings',
            'latestCourses',
            'chartLabels',
            'chartData'
        ));
    }
}