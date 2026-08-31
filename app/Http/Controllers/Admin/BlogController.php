<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\Admin;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * نمایش داشبورد بلاگ
     */
    public function index()
    {
        $stats = [
            'total' => BlogPost::count(),
            'published' => BlogPost::where('status', 'published')->count(),
            'draft' => BlogPost::where('status', 'draft')->count(),
            'pending' => BlogPost::where('status', 'pending')->count(),
            'archived' => BlogPost::where('status', 'archived')->count(),
            'total_comments' => BlogComment::count(),
            'pending_comments' => BlogComment::where('status', 'pending')->count(),
        ];

        $posts = BlogPost::with('category')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.blog.dashboard', compact('stats', 'posts'));
    }

    /**
     * نمایش لیست پست‌ها
     */
    public function posts()
    {
        $posts = BlogPost::with(['category', 'author'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'total' => BlogPost::count(),
            'published' => BlogPost::where('status', 'published')->count(),
            'draft' => BlogPost::where('status', 'draft')->count(),
            'pending' => BlogPost::where('status', 'pending')->count(),
            'archived' => BlogPost::where('status', 'archived')->count(),
            'total_comments' => BlogComment::count(),
            'pending_comments' => BlogComment::where('status', 'pending')->count(),
        ];

        return view('admin.blog.index', compact('posts', 'stats'));
    }

    /**
     * نمایش فرم ایجاد پست جدید
     */
    public function create()
    {
        $categories = BlogCategory::all();
        return view('admin.blog.create', compact('categories'));
    }

    /**
     * ذخیره پست جدید
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_posts',
            'summary' => 'nullable|string',
            'text' => 'required|string',
            'category_id' => 'nullable|exists:blog_categories,id',
            'tags' => 'nullable|string|max:255',
            'status' => 'required|in:draft,pending,published,archived',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $slug = $request->slug ?: Str::slug($request->title);
        $count = BlogPost::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        $post = BlogPost::create([
            'title' => $request->title,
            'slug' => $slug,
            'summary' => $request->summary,
            'text' => $request->text,
            'media' => $request->media,
            'tags' => $request->tags,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'author_id' => auth()->guard('admin')->id(),
            'is_featured' => $request->is_featured ?? false,
            'published_at' => $request->published_at ?? ($request->status == 'published' ? now() : null),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);

        return redirect()->route('admin.blog.posts')
            ->with('success', 'پست با موفقیت ایجاد شد.');
    }

    /**
     * نمایش فرم ویرایش پست
     */
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);
        $categories = BlogCategory::all();
        return view('admin.blog.edit', compact('post', 'categories'));
    }

    /**
     * به‌روزرسانی پست
     */
    public function update(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_posts,slug,' . $id,
            'summary' => 'nullable|string',
            'text' => 'required|string',
            'category_id' => 'nullable|exists:blog_categories,id',
            'tags' => 'nullable|string|max:255',
            'status' => 'required|in:draft,pending,published,archived',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $slug = $request->slug ?: Str::slug($request->title);
        $count = BlogPost::where('slug', $slug)->where('id', '!=', $id)->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        $post->update([
            'title' => $request->title,
            'slug' => $slug,
            'summary' => $request->summary,
            'text' => $request->text,
            'media' => $request->media,
            'tags' => $request->tags,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'is_featured' => $request->is_featured ?? false,
            'published_at' => $request->published_at ?? ($request->status == 'published' ? now() : null),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);

        return redirect()->route('admin.blog.posts')
            ->with('success', 'پست با موفقیت به‌روزرسانی شد.');
    }

    /**
     * حذف پست (انتقال به بایگانی)
     */
    public function destroy($id)
    {
        try {
            $post = BlogPost::findOrFail($id);
            $post->update(['status' => 'archived']);
            
            return redirect()->route('admin.blog.posts')
                ->with('success', 'پست با موفقیت به بایگانی منتقل شد.');
        } catch (\Exception $e) {
            return redirect()->route('admin.blog.posts')
                ->with('error', 'خطا در حذف پست: ' . $e->getMessage());
        }
    }

    /**
     * حذف فیزیکی پست
     */
    public function forceDelete($id)
    {
        try {
            $post = BlogPost::findOrFail($id);
            $post->delete();
            
            return redirect()->route('admin.blog.posts')
                ->with('success', 'پست با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return redirect()->route('admin.blog.posts')
                ->with('error', 'خطا در حذف فیزیکی پست: ' . $e->getMessage());
        }
    }

    /**
     * تغییر وضعیت پست
     */
    public function toggleStatus(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        $request->validate([
            'status' => 'required|in:draft,pending,published,archived',
        ]);

        $post->update([
            'status' => $request->status,
            'published_at' => $request->status == 'published' ? now() : $post->published_at,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'وضعیت پست با موفقیت تغییر کرد.'
        ]);
    }

    /**
     * تغییر وضعیت ویژه
     */
    public function toggleFeatured($id)
    {
        $post = BlogPost::findOrFail($id);
        $post->update(['is_featured' => !$post->is_featured]);

        return response()->json([
            'success' => true,
            'message' => 'وضعیت ویژه با موفقیت تغییر کرد.'
        ]);
    }

    // ============================================================
    // مدیریت دسته‌بندی‌ها
    // ============================================================

    /**
     * نمایش لیست دسته‌بندی‌ها
     */
    public function categories()
    {
        $categories = BlogCategory::withCount('posts')->get();
        return view('admin.blog.categories', compact('categories'));
    }

    /**
     * ذخیره دسته‌بندی جدید
     */
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:blog_categories',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:20',
            'icon' => 'nullable|string|max:50',
        ]);

        $slug = Str::slug($request->name);

        BlogCategory::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'color' => $request->color,
            'icon' => $request->icon,
        ]);

        return redirect()->route('admin.blog.categories.index')
            ->with('success', 'دسته‌بندی با موفقیت ایجاد شد.');
    }

    /**
     * به‌روزرسانی دسته‌بندی
     */
    public function updateCategory(Request $request, $id)
    {
        $category = BlogCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100|unique:blog_categories,name,' . $id,
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:20',
            'icon' => 'nullable|string|max:50',
        ]);

        $slug = Str::slug($request->name);

        $category->update([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'color' => $request->color,
            'icon' => $request->icon,
        ]);

        return redirect()->route('admin.blog.categories.index')
            ->with('success', 'دسته‌بندی با موفقیت به‌روزرسانی شد.');
    }

    /**
     * حذف دسته‌بندی
     */
    public function deleteCategory($id)
    {
        $category = BlogCategory::findOrFail($id);

        if ($category->posts()->count() > 0) {
            return back()->with('error', 'این دسته‌بندی دارای پست است و نمی‌توان آن را حذف کرد.');
        }

        $category->delete();

        return redirect()->route('admin.blog.categories.index')
            ->with('success', 'دسته‌بندی با موفقیت حذف شد.');
    }

    // ============================================================
    // مدیریت تگ‌ها
    // ============================================================

    /**
     * نمایش لیست تگ‌ها
     */
    public function tags()
    {
        $allTags = [];
        $posts = BlogPost::all();

        foreach ($posts as $post) {
            if ($post->tags) {
                $tags = explode(',', $post->tags);
                foreach ($tags as $tag) {
                    $tag = trim($tag);
                    if (!empty($tag)) {
                        if (isset($allTags[$tag])) {
                            $allTags[$tag]++;
                        } else {
                            $allTags[$tag] = 1;
                        }
                    }
                }
            }
        }

        arsort($allTags);

        return view('admin.blog.tags', compact('allTags'));
    }

    // ============================================================
    // مدیریت نظرات
    // ============================================================

    /**
     * نمایش لیست نظرات
     */
    public function comments()
    {
        $comments = BlogComment::with(['post', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'total' => BlogComment::count(),
            'pending' => BlogComment::where('status', 'pending')->count(),
            'approved' => BlogComment::where('status', 'approved')->count(),
            'spam' => BlogComment::where('status', 'spam')->count(),
            'trash' => BlogComment::where('status', 'trash')->count(),
        ];

        return view('admin.blog.comments', compact('comments', 'stats'));
    }

    /**
     * تایید نظر
     */
    public function approveComment($id)
    {
        $comment = BlogComment::findOrFail($id);
        $comment->update(['status' => 'approved']);

        return response()->json([
            'success' => true,
            'message' => 'نظر با موفقیت تایید شد.'
        ]);
    }

    /**
     * رد نظر
     */
    public function rejectComment($id)
    {
        $comment = BlogComment::findOrFail($id);
        $comment->update(['status' => 'spam']);

        return response()->json([
            'success' => true,
            'message' => 'نظر با موفقیت رد شد.'
        ]);
    }

    /**
     * حذف نظر
     */
    public function deleteComment($id)
    {
        $comment = BlogComment::findOrFail($id);
        $comment->update(['status' => 'trash']);

        return redirect()->route('admin.blog.comments.index')
            ->with('success', 'نظر با موفقیت حذف شد.');
    }

    /**
     * حذف فیزیکی نظر
     */
    public function forceDeleteComment($id)
    {
        $comment = BlogComment::findOrFail($id);
        $comment->delete();

        return redirect()->route('admin.blog.comments.index')
            ->with('success', 'نظر با موفقیت حذف شد.');
    }
}