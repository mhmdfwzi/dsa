<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\HomeController;

// ✅ الصفحة الرئيسية
Route::get('/', [CourseController::class, 'index'])->name('home');

// ✅ صفحات المصادقة
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// ✅ عرض تفاصيل كورس
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');

// ✅ تسجيل الطالب في كورس
Route::post('/courses/{course}/enroll', [CourseController::class, 'enroll'])
    ->middleware('auth')
    ->name('courses.enroll');

// ✅ تقييم كورس
Route::post('/courses/{course}/review', [ReviewController::class, 'store'])
    ->middleware('auth')
    ->name('courses.review');

// ✅ صفحة فريق العمل (frontend فقط)
Route::get('/team', function () {
    return view('team.index');
})->name('team.index');

// ✅ صفحة داشبورد الطالب أو الأدمن
Route::get('/dashboard', function () {
    if (Auth::check() && Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

// ✅ إعدادات الحساب (للطالب)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/category/{category}', [CourseController::class, 'byCategory'])->name('courses.byCategory');