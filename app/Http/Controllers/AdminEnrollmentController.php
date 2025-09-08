<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminEnrollmentController extends Controller
{
    /**
     * عرض جميع التسجيلات مع إمكانية التصفية والبحث
     */
    public function index(Request $request)
    {
        $query = Enrollment::with(['user', 'course']);
        
        // التصفية حسب الحالة
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        
        // التصفية حسب الكورس
        if ($request->has('course_id') && $request->course_id != 'all') {
            $query->where('course_id', $request->course_id);
        }
        
        // البحث حسب اسم الطالب
        if ($request->has('search') && !empty($request->search)) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
        
        // التصفية حسب التاريخ
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        // الترتيب
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        $enrollments = $query->paginate(20);
        $courses = Course::all();
        $statuses = ['pending', 'approved', 'completed', 'cancelled'];
        
        return view('admin.enrollments.index', compact('enrollments', 'courses', 'statuses'));
    }

    /**
     * تحديث حالة التسجيل
     */
    public function updateStatus(Request $request, Enrollment $enrollment)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,completed,cancelled',
        ]);
        
        $oldStatus = $enrollment->status;
        $data = ['status' => $request->status];
        
        // إذا تم الإكمال، نضيف تاريخ الإكمال
        if ($request->status === 'completed') {
            $data['completed_at'] = now();
        } elseif ($oldStatus === 'completed' && $request->status !== 'completed') {
            $data['completed_at'] = null;
        }
        
        $enrollment->update($data);
        
        // إشعار بنجاح العملية
        $statusText = $this->getStatusText($request->status);
        
        return back()->with('success', "تم تحديث حالة التسجيل إلى '$statusText' بنجاح");
    }

    /**
     * تحديث حالة متعددة للتسجيلات
     */
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'enrollment_ids' => 'required|array',
            'enrollment_ids.*' => 'exists:enrollments,id',
            'status' => 'required|in:pending,approved,completed,cancelled',
        ]);
        
        $data = ['status' => $request->status];
        
        if ($request->status === 'completed') {
            $data['completed_at'] = now();
        }
        
        Enrollment::whereIn('id', $request->enrollment_ids)->update($data);
        
        $statusText = $this->getStatusText($request->status);
        
        return back()->with('success', "تم تحديث حالة " . count($request->enrollment_ids) . " تسجيل إلى '$statusText' بنجاح");
    }

    /**
     * عرض إحصائيات التسجيلات
     */
    public function statistics()
    {
        // إحصائيات الحالات
        $stats = DB::table('enrollments')
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');
        
        $totalEnrollments = array_sum($stats->toArray());
        
        // التسجيلات الحديثة
        $recentEnrollments = Enrollment::with(['user', 'course'])
            ->latest()
            ->take(10)
            ->get();
        
        // إحصائيات التسجيلات خلال الشهر
        $monthlyStats = DB::table('enrollments')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        // أفضل الكورسات حسب عدد التسجيلات
        $topCourses = Course::withCount('enrollments')
            ->orderByDesc('enrollments_count')
            ->take(5)
            ->get();
        
        return view('admin.enrollments.statistics', compact(
            'stats', 
            'totalEnrollments', 
            'recentEnrollments',
            'monthlyStats',
            'topCourses'
        ));
    }

    /**
     * تصدير البيانات إلى Excel
     */
    public function export(Request $request)
    {
        $query = Enrollment::with(['user', 'course']);
        
        // تطبيق نفس عوامل التصفية مثل index
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('course_id') && $request->course_id != 'all') {
            $query->where('course_id', $request->course_id);
        }
        
        $enrollments = $query->get();
        
        // هنا يمكنك إضافة كود التصدير إلى Excel
        // سأتركه كدالة قابلة للتطوير لاحقاً
        
        return back()->with('info', 'سيتم إضافة ميزة التصدير قريباً');
    }

    /**
     * حذف التسجيل
     */
    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        
        return back()->with('success', 'تم حذف التسجيل بنجاح');
    }

    /**
     * حذف متعدد للتسجيلات
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'enrollment_ids' => 'required|array',
            'enrollment_ids.*' => 'exists:enrollments,id',
        ]);
        
        Enrollment::whereIn('id', $request->enrollment_ids)->delete();
        
        return back()->with('success', 'تم حذف ' . count($request->enrollment_ids) . ' تسجيل بنجاح');
    }

    /**
     * دالة مساعدة للحصول على نص الحالة
     */
    private function getStatusText($status)
    {
        $statuses = [
            'pending' => 'معلق',
            'approved' => 'مفعل',
            'completed' => 'مكتمل',
            'cancelled' => 'ملغي',
        ];
        
        return $statuses[$status] ?? $status;
    }
}