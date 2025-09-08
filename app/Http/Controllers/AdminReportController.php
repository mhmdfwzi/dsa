<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    /**
     * عرض تقرير بجميع الطلاب
     */
    public function reportStudents()
    {
        $students = User::where('role', 'student')
                        ->withCount('courses') // عدد الكورسات المسجل بها الطالب
                        ->get();

        return view('admin.reports.students', compact('students'));
    }

    /**
     * عرض تقرير بجميع الكورسات وعدد الطلاب المسجلين في كل كورس
     */
    public function reportCourses()
    {
        $courses = Course::withCount('students')->get();

        return view('admin.reports.courses', compact('courses'));
    }

    /**
     * عرض تقرير الطلاب في كورس معين يتم اختياره من القائمة
     */
    public function reportCourseStudents(Request $request)
    {
        $courses = Course::all(); // علشان نظهرهم في القائمة المنسدلة
        $selectedCourse = null;
        $students = collect(); // نبدأ بمجموعة فاضية

        if ($request->has('course_id')) {
            $selectedCourse = Course::with('students')->find($request->course_id);

            if ($selectedCourse) {
                $students = $selectedCourse->students;
            } else {
                // ممكن نرجع برسالة لو الكورس مش موجود
                return redirect()->back()->with('error', 'لم يتم العثور على الكورس المحدد.');
            }
        }

        return view('admin.reports.course_students', compact('courses', 'students', 'selectedCourse'));
    }
    
}
