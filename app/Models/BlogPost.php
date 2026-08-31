<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;

    protected $table = 'blog_posts';

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'text',
        'media',
        'tags',
        'status',
        'category_id',
        'author_id',
        'views',
        'is_featured',
        'published_at',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'views' => 'integer',
    ];

    // رابطه با دسته‌بندی
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    // رابطه با نویسنده (ادمین)
    public function author()
    {
        return $this->belongsTo(Admin::class, 'author_id');
    }

    // رابطه با نظرات
    public function comments()
    {
        return $this->hasMany(BlogComment::class, 'post_id');
    }

    // نظرات تایید شده
    public function approvedComments()
    {
        return $this->hasMany(BlogComment::class, 'post_id')->where('status', 'approved');
    }

    // اسکوپ: پست‌های منتشر شده
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    // اسکوپ: پست‌های ویژه
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // اسکوپ: پست‌های پیش‌نویس
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    // تگ‌ها را به آرایه تبدیل کن
    public function getTagsArrayAttribute()
    {
        return $this->tags ? explode(',', $this->tags) : [];
    }

    // افزایش بازدید
    public function incrementViews()
    {
        $this->increment('views');
    }
}