<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Review;
use App\Models\Enrollment;
use App\Models\User;

class Course extends Model
{
    protected $fillable = ['title', 'description', 'price', 'image'];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // العلاقات
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    public function trainer()
{
    return $this->belongsTo(User::class, 'trainer_id');
}

    // دالة للحصول على عدد الطلاب النشطين
public function getActiveStudentsCountAttribute()
{
    return $this->enrollments()->whereIn('status', ['pending', 'approved'])->count();
}

    // Accessors
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }

    public function getIsFreeAttribute()
    {
        return $this->price == 0;
    }

    public function getFormattedPriceAttribute()
    {
        return $this->isFree ? 'مجاني' : number_format($this->price, 2) . ' جنيه';
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/default-course.png');
    }

    public function getFormattedTitleAttribute()
    {
        return ucfirst($this->title);
    }

    public function getFormattedDescriptionAttribute()
    {
        return nl2br(e($this->description));
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }
    public function students()
{
    return $this->belongsToMany(User::class, 'enrollments')->withTimestamps();
}
}
