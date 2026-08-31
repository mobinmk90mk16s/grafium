<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    use HasFactory;

    protected $table = 'blog_comments';

    protected $fillable = [
        'post_id',
        'user_id',
        'content',
        'status',
        'parent_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // رابطه با پست
    public function post()
    {
        return $this->belongsTo(BlogPost::class, 'post_id');
    }

    // رابطه با کاربر
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // رابطه با نظر والد
    public function parent()
    {
        return $this->belongsTo(BlogComment::class, 'parent_id');
    }

    // رابطه با پاسخ‌ها
    public function replies()
    {
        return $this->hasMany(BlogComment::class, 'parent_id');
    }

    // اسکوپ: نظرات تایید شده
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // اسکوپ: نظرات در انتظار
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}