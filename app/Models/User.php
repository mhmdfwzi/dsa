<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Review;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * الخصائص اللي ممكن نملأها بالـ mass assignment
     */
    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'phone',
        'remember_token',
        'last_login_at',
        'last_login_ip',
        'role',
        'bio',
        'expertise',
        'is_approved',
        'profile_photo_path'
    ];

    // إضافة قاعدة للتحقق من رقم الهاتف إذا لزم الأمر
    public static $rules = [
        'phone' => 'sometimes|required|string|max:15|unique:users',
    ];

    /**
     * الخصائص اللي لازم تتخفي لما يتحول المودل لـ JSON
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * تحويل بعض الخصائص تلقائيًا
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_approved' => 'boolean',
    ];

    /**
     * علاقة المستخدم بالـ Enrollment
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * دالة للحصول على التسجيلات النشطة فقط
     */
    public function activeEnrollments()
    {
        return $this->enrollments()->whereIn('status', ['pending', 'approved']);
    }

    /**
     * علاقة المستخدم بالكورسات عن طريق Enrollment (كطالب)
     */
    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'enrollments')->withTimestamps();
    }

    /**
     * علاقة المستخدم بالدورات التي أنشأها (كمدرب)
     */
    public function taughtCourses()
    {
        return $this->hasMany(Course::class, 'trainer_id');
    }

    /**
     * علاقة المستخدم بالدورات التي أنشأها (كمشرف)
     */
    public function supervisedCourses()
    {
        return $this->hasMany(Course::class, 'created_by');
    }

    /**
     * علاقة المستخدم بالتقييمات
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * التحقق إذا كان المستخدم مدربًا
     */
    public function isTrainer()
    {
        return $this->role === 'trainer';
    }

    /**
     * التحقق إذا كان المستخدم أدمن
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * الحصول على صورة الملف الشخصي
     */
    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo_path 
            ? asset('storage/'.$this->profile_photo_path) 
            : asset('images/default-avatar.png');
    }

    /**
     * نطاق الاستعلام للمدربين فقط
     */
    public function scopeTrainers($query)
    {
        return $query->where('role', 'trainer');
    }

    /**
     * نطاق الاستعلام للطلاب فقط
     */
    public function scopeStudents($query)
    {
        return $query->where('role', 'student');
    }

    /**
     * نطاق الاستعلام للمدربين المفعلين
     */
    public function scopeApprovedTrainers($query)
    {
        return $query->where('role', 'trainer')->where('is_approved', true);
    }

    /**
     * نطاق الاستعلام للمدربين غير المفعلين
     */
    public function scopePendingTrainers($query)
    {
        return $query->where('role', 'trainer')->where('is_approved', false);
    }
}