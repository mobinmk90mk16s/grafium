<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;

    protected $table = 'blog_categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'icon',
    ];

    // رابطه با پست‌ها (یک دسته‌بندی چند پست دارد)
    public function posts()
    {
        return $this->hasMany(BlogPost::class, 'category_id');
    }

    // تعداد پست‌های این دسته‌بندی
    public function getPostsCountAttribute()
    {
        return $this->posts()->count();
    }
}