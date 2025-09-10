<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Review;
use App\Models\Enrollment;
use App\Models\User;
use App\Models\Category;

class Course extends Model
{
    protected $fillable = [
        'title', 
        'description', 
        'price', 
        'image', 
        'instructor_name',
        'trainer_id',
        'category_id',
        'requires_approval',
        'duration',
        'level'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'requires_approval' => 'boolean',
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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments')->withTimestamps();
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

    public function getActiveStudentsCountAttribute()
    {
        return $this->enrollments()->whereIn('status', ['pending', 'approved'])->count();
    }

    public function getDurationTextAttribute()
    {
        if (!$this->duration) return 'غير محدد';
        
        return $this->duration . ' ساعة';
    }

    public function getLevelTextAttribute()
    {
        $levels = [
            'beginner' => 'مبتدئ',
            'intermediate' => 'متوسط',
            'advanced' => 'متقدم'
        ];
        
        return $levels[$this->level] ?? 'غير محدد';
    }
}