<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminCourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        Course::create($data);
        return redirect()->route('admin.courses.index')->with('success', 'تم إضافة الكورس بنجاح');
    }

    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($course->image) {
                Storage::disk('public')->delete($course->image);
            }
            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        $course->update($data);
        return redirect()->route('admin.courses.index')->with('success', 'تم تعديل الكورس بنجاح');
    }

    // ✅ دالة لوحة التحكم الجديدة
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
