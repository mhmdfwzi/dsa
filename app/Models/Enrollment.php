<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrollment extends Model
{
    // الحقول التي يمكن تعبئتها بشكل جماعي
    protected $fillable = ['user_id', 'course_id', 'status', 'completed_at'];

    // تحويل أنواع البيانات
    protected $casts = [
        'completed_at' => 'datetime',
    ];

    // العلاقة مع نموذج User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // العلاقة مع نموذج Course
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    // 📋 دوال مساعدة للتحقق من الحالة
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    // 📋 دوال لتغيير الحالة
    public function markAsApproved(): void
    {
        $this->update(['status' => 'approved']);
    }

    public function markAsCompleted(): void
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    public function markAsCancelled(): void
    {
        $this->update(['status' => 'cancelled']);
    }

    // 📋 دالة للحصول على الحالة كـ نص مقروء
    public function getStatusTextAttribute(): string
    {
        return match($this->status) {
            'pending' => 'معلق',
            'approved' => 'مفعل',
            'completed' => 'مكتمل',
            'cancelled' => 'ملغي',
            default => 'غير معروف',
        };
    }

    // 📋 دالة للتحقق إذا كان التسجيل نشط
    public function isActive(): bool
    {
        return in_array($this->status, ['pending', 'approved']);
    }
}