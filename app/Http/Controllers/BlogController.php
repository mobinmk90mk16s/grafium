<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Models\BlogCategory;

class BlogController extends Controller
{
    /**
     * نمایش لیست مقالات
     */
    public function index()
    {
        $posts = BlogPost::with(['category', 'author'])
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = BlogCategory::all();

        return view('blog', compact('posts', 'categories'));
    }

    /**
     * نمایش یک مقاله
     */
    public function show($id)
    {
        $post = BlogPost::with(['category', 'author', 'comments'])
            ->where('status', 'published')
            ->findOrFail($id);

        // افزایش بازدید
        $post->increment('views');

        // مقالات مرتبط
        $relatedPosts = BlogPost::where('status', 'published')
            ->where('id', '!=', $id)
            ->where('category_id', $post->category_id)
            ->limit(3)
            ->get();

        return view('blog-post', compact('post', 'relatedPosts'));
    }

    /**
     * جستجو در مقالات
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        $posts = BlogPost::with(['category', 'author'])
            ->where('status', 'published')
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('summary', 'LIKE', "%{$query}%")
                  ->orWhere('text', 'LIKE', "%{$query}%")
                  ->orWhere('tags', 'LIKE', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = BlogCategory::all();

        return view('blog', compact('posts', 'categories', 'query'));
    }

    public function category($slug)
    {
        $category = BlogCategory::where('slug', $slug)->firstOrFail();

        $posts = BlogPost::with(['category', 'author'])
            ->where('status', 'published')
            ->where('category_id', $category->id)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = BlogCategory::all();

        return view('blog', compact('posts', 'categories', 'category'));
    }
}