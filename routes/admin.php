<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminCourseController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AdminEnrollmentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\TrainerController;

// ✅ راوتات الأدمن
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // لوحة تحكم الأدمن
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // إدارة الكورسات
    Route::get('/courses', [AdminCourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/create', [AdminCourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [AdminCourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}/edit', [AdminCourseController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{course}', [AdminCourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [AdminCourseController::class, 'destroy'])->name('courses.destroy');

    // إدارة التسجيلات
    Route::prefix('enrollments')->name('enrollments.')->group(function () {
        Route::get('/', [AdminEnrollmentController::class, 'index'])->name('index');
        Route::get('/statistics', [AdminEnrollmentController::class, 'statistics'])->name('statistics');
        Route::put('/{enrollment}/status', [AdminEnrollmentController::class, 'updateStatus'])->name('update-status');
        Route::post('/bulk-update', [AdminEnrollmentController::class, 'bulkUpdateStatus'])->name('bulk-update');
        Route::delete('/{enrollment}', [AdminEnrollmentController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-delete', [AdminEnrollmentController::class, 'bulkDestroy'])->name('bulk-delete');
        Route::get('/export', [AdminEnrollmentController::class, 'export'])->name('export');
    });

    // إدارة فريق العمل
    Route::resource('team', TeamController::class)->names([
        'index' => 'team.index',
        'create' => 'team.create',
        'store' => 'team.store',
        'edit' => 'team.edit',
        'update' => 'team.update',
        'destroy' => 'team.destroy',
    ]);

    // إدارة التقييمات
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // إدارة الطلاب
    Route::get('/students', function () {
        $students = \App\Models\User::where('role', '!=', 'admin')->get();
        return view('admin.students.index', compact('students'));
    })->name('students.index');

    Route::get('/students/{student}', function ($id) {
        $student = \App\Models\User::findOrFail($id);
        return view('admin.students.show', compact('student'));
    })->name('students.show');

    // ✅ تقارير الأدمن
    Route::get('/reports/students', [AdminReportController::class, 'reportStudents'])->name('report.students');
    Route::get('/reports/courses', [AdminReportController::class, 'reportCourses'])->name('report.courses');
    Route::get('/reports/course-students', [AdminReportController::class, 'reportCourseStudents'])->name('report.course_students');

    // ✅ إدارة التصنيفات
    Route::resource('categories', CategoryController::class);

    // إدارة المدربين
Route::resource('trainers', TrainerController::class);
Route::post('trainers/{user}/approve', [TrainerController::class, 'approve'])->name('trainers.approve');
Route::post('trainers/{user}/reject', [TrainerController::class, 'reject'])->name('trainers.reject');
});