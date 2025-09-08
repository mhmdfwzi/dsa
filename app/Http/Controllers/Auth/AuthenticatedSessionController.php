<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        // التحقق من صحة البيانات المدخلة
        $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required'],
        ], [
            'email.required' => 'يجب إدخال البريد الإلكتروني أو رقم الهاتف',
            'password.required' => 'يجب إدخال كلمة المرور',
        ]);

        // تحديد نوع البيانات المدخلة (بريد إلكتروني أو رقم هاتف)
        $credentials = $request->only('email', 'password');
        $field = filter_var($credentials['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        
        // إعداد بيانات الاعتماد للمصادقة
        $authData = [
            $field => $credentials['email'],
            'password' => $credentials['password']
        ];

        // محاولة المصادقة
        if (Auth::attempt($authData, $request->boolean('remember'))) {
            // ✅ تحديث بيانات آخر تسجيل دخول باستخدام DB facade
            $user = Auth::user();
            
            DB::table('users')
                ->where('id', $user->id)
                ->update([
                    'last_login_at' => Carbon::now(),
                    'last_login_ip' => $request->ip()
                ]);

            $request->session()->regenerate();

            // ✅ توجيه المستخدم حسب كونه أدمن أو طالب
            if ($user->role === 'admin') {
                return redirect('/admin/dashboard');
            }
            return redirect('/dashboard');
        }

        // إذا فشلت المصادقة
        throw ValidationException::withMessages([
            'email' => 'بيانات الدخول غير صحيحة.',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}