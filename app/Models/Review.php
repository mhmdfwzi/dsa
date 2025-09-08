<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
 public function user()
{
    return $this->belongsTo(User::class);
}
 public function course()
{
    return $this->belongsTo(Course::class);
}

 protected $fillable = ['user_id', 'course_id', 'rating', 'comment'];
 protected $casts = [
     'rating' => 'integer',
     'created_at' => 'datetime',
     'updated_at' => 'datetime',
 ];
 public function getFormattedRatingAttribute()
{
    return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
}
 public function getFormattedCommentAttribute()
{
    return nl2br(e($this->comment));
 }
 public function getFormattedCreatedAtAttribute()
{
    return $this->created_at->format('d M Y, H:i');
 }
 public function getFormattedUserNameAttribute()
{
    return $this->user ? $this->user->name : 'مستخدم محذوف';
 }
 public function getUserAvatarUrlAttribute()
{
    return $this->user ? $this->user->avatar_url : asset('images/default-avatar.png');
 }
 protected $appends = ['formatted_rating', 'formatted_comment', 'formatted_created_at', 'formatted_user_name', 'user_avatar_url'];
}
