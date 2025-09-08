<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Storage;

class TrainerController extends Controller
{
    public function index()
    {
        // استخدام النطاق الجديد للحصول على المدربين
        $trainers = User::trainers()->latest()->paginate(10);
        return view('admin.trainers.index', compact('trainers'));
    }

    public function create()
    {
        return view('admin.trainers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'bio' => ['nullable', 'string'],
            'expertise' => ['required', 'string'],
             'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'trainer',
            'bio' => $request->bio,
            'expertise' => $request->expertise,
            'email_verified_at' => now(),
            'is_approved' => $request->has('is_approved'), // إذا كان هناك checkbox للتفعيل المباشر
        ];

        // رفع صورة الملف الشخصي إذا وجدت
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $data['profile_photo_path'] = $path;
        }

        User::create($data);

        return redirect()->route('admin.trainers.index')
            ->with('success', 'تم إضافة المدرب بنجاح');
    }

    public function show(User $trainer)
    {
        // استخدام الدالة الجديدة للتحقق
        abort_unless($trainer->isTrainer(), 404);
        return view('admin.trainers.show', compact('trainer'));
    }

    public function edit(User $trainer)
    {
        abort_unless($trainer->isTrainer(), 404);
        return view('admin.trainers.edit', compact('trainer'));
    }

    public function update(Request $request, User $trainer)
    {
        abort_unless($trainer->isTrainer(), 404);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$trainer->id],
            'phone' => ['required', 'string', 'max:20', 'unique:users,phone,'.$trainer->id],
            'bio' => ['nullable', 'string'],
            'expertise' => ['required', 'string'],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->only('name', 'email', 'phone', 'bio', 'expertise');
        
        // رفع صورة الملف الشخصي إذا وجدت
        if ($request->hasFile('profile_photo')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($trainer->profile_photo_path) {
                Storage::disk('public')->delete($trainer->profile_photo_path);
            }
            
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $data['profile_photo_path'] = $path;
        }

        $trainer->update($data);

        return redirect()->route('admin.trainers.index')
            ->with('success', 'تم تحديث بيانات المدرب بنجاح');
    }

    public function destroy(User $trainer)
    {
        abort_unless($trainer->isTrainer(), 404);
        
        // حذف صورة الملف الشخصي إذا كانت موجودة
        if ($trainer->profile_photo_path) {
            Storage::disk('public')->delete($trainer->profile_photo_path);
        }
        
        $trainer->delete();

        return redirect()->route('admin.trainers.index')
            ->with('success', 'تم حذف المدرب بنجاح');
    }

    public function approve(User $trainer)
    {
        abort_unless($trainer->isTrainer(), 404);
        $trainer->update(['is_approved' => true]);

        return back()->with('success', 'تم تفعيل المدرب بنجاح');
    }

    public function reject(User $trainer)
    {
        abort_unless($trainer->isTrainer(), 404);
        $trainer->update(['is_approved' => false]);

        return back()->with('success', 'تم إلغاء تفعيل المدرب');
    }

    // دوال إضافية لإدارة المدربين
    
    public function pending()
    {
        // الحصول على المدربين غير المفعلين باستخدام النطاق الجديد
        $trainers = User::pendingTrainers()->latest()->paginate(10);
        return view('admin.trainers.pending', compact('trainers'));
    }

    public function approved()
    {
        // الحصول على المدربين المفعلين باستخدام النطاق الجديد
        $trainers = User::approvedTrainers()->latest()->paginate(10);
        return view('admin.trainers.approved', compact('trainers'));
    }
}