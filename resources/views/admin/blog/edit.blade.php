@extends('admin.layouts.admin')

@section('title', 'ویرایش پست | GRAFIUM')

@section('content')
<style>
    .form-card {
        background: #0f1f33; border: 1px solid #1a2f4a; border-radius: 16px; padding: 28px;
        max-width: 900px; margin: 0 auto;
    }
    .form-group { margin-bottom: 18px; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; color: #94a3b8; margin-bottom: 5px; }

    .input-dark {
        background: #0a1628; border: 1px solid #1a2f4a; border-radius: 8px; padding: 10px 14px;
        color: #e2e8f0; font-size: 13px; width: 100%; transition: border 0.2s; font-family: 'Vazirmatn', sans-serif;
    }
    .input-dark:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
    .input-dark::placeholder { color: #475569; }

    .btn-emerald { background: rgba(52, 211, 153, 0.08); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.2); padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
    .btn-emerald:hover { background: rgba(52, 211, 153, 0.15); }

    .btn-rose { background: rgba(244, 63, 94, 0.08); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.2); padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
    .btn-rose:hover { background: rgba(244, 63, 94, 0.15); }

    .toast-container {
        position: fixed; bottom: 24px; left: 24px; z-index: 9999;
        display: flex; flex-direction: column; gap: 8px;
    }
    .toast-item {
        padding: 14px 20px; border-radius: 12px; min-width: 300px; max-width: 450px;
        backdrop-filter: blur(8px); box-shadow: 0 8px 32px rgba(0,0,0,0.5);
        animation: slideIn 0.4s ease forwards;
        display: flex; align-items: center; gap: 12px;
        border: 1px solid rgba(255,255,255,0.06);
    }
    .toast-item.hiding { animation: slideOut 0.3s ease forwards; }
    @keyframes slideIn { from { opacity: 0; transform: translateX(100px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes slideOut { from { opacity: 1; transform: translateX(0); } to { opacity: 0; transform: translateX(100px); } }

    .toast-success { background: rgba(52, 211, 153, 0.15); border-color: rgba(52, 211, 153, 0.3); color: #34d399; }
    .toast-error { background: rgba(244, 63, 94, 0.15); border-color: rgba(244, 63, 94, 0.3); color: #fb7185; }
    .toast-info { background: rgba(59, 130, 246, 0.15); border-color: rgba(59, 130, 246, 0.3); color: #60a5fa; }

    .avatar-icon { width: 36px; height: 36px; border-radius: 50%; background: #1a2f4a; display: flex; align-items: center; justify-content: center; color: #60a5fa; font-size: 16px; }

    @media (max-width: 768px) {
        .main-content { margin-right: 0 !important; padding: 16px !important; }
        .form-card { padding: 16px; }
    }
</style>

<!-- ===== HEADER ===== -->
<div class="flex flex-wrap justify-between items-center pb-4 border-b border-[#1a2f4a] mb-6">
    <div>
        <div class="flex items-center gap-3">
            <i data-lucide="pencil" class="w-6 h-6 text-blue-400"></i>
            <h1 class="text-2xl font-extrabold text-white">ویرایش پست</h1>
        </div>
        <p class="text-sm text-[#475569] mt-0.5 mr-9">ویرایش پست "{{ $post->title }}"</p>
    </div>
    <div class="flex items-center gap-4">
        <span class="text-sm text-[#64748b]">{{ Auth::guard('admin')->user()->name ?? 'ادمین' }}</span>
        <div class="avatar-icon"><i data-lucide="user-circle" class="w-5 h-5"></i></div>
    </div>
</div>

<!-- ===== FORM ===== -->
<div class="form-card">
    <form action="{{ route('admin.blog.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <div class="form-group lg:col-span-2">
                <label>عنوان پست</label>
                <input type="text" name="title" class="input-dark" value="{{ old('title', $post->title) }}" required />
            </div>

            <div class="form-group">
                <label>لینک یکتا (اسلاگ)</label>
                <input type="text" name="slug" class="input-dark" value="{{ old('slug', $post->slug) }}" placeholder="خالی بگذارید تا خودکار تولید شود" />
            </div>

            <div class="form-group">
                <label>دسته‌بندی</label>
                <select name="category_id" class="input-dark">
                    <option value="">بدون دسته‌بندی</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group lg:col-span-2">
                <label>خلاصه پست</label>
                <textarea name="summary" class="input-dark" rows="2">{{ old('summary', $post->summary) }}</textarea>
            </div>

            <div class="form-group lg:col-span-2">
                <label>متن کامل پست</label>
                <textarea name="text" class="input-dark" rows="10" required>{{ old('text', $post->text) }}</textarea>
            </div>

            <div class="form-group">
                <label>تگ‌ها (با کاما جدا کنید)</label>
                <input type="text" name="tags" class="input-dark" value="{{ old('tags', $post->tags) }}" placeholder="مثال: لاراول, PHP, آموزش" />
            </div>

            <div class="form-group">
                <label>تصویر شاخص</label>
                <input type="file" name="media" class="input-dark" accept="image/*" />
                @if($post->media)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $post->media) }}" alt="{{ $post->title }}" class="w-20 h-20 rounded-lg object-cover" />
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label>وضعیت</label>
                <select name="status" class="input-dark">
                    <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>پیش‌نویس</option>
                    <option value="pending" {{ old('status', $post->status) == 'pending' ? 'selected' : '' }}>در انتظار</option>
                    <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>منتشر شده</option>
                    <option value="archived" {{ old('status', $post->status) == 'archived' ? 'selected' : '' }}>بایگانی</option>
                </select>
            </div>

            <div class="form-group">
                <label>پست ویژه</label>
                <select name="is_featured" class="input-dark">
                    <option value="0" {{ old('is_featured', $post->is_featured) == 0 ? 'selected' : '' }}>خیر</option>
                    <option value="1" {{ old('is_featured', $post->is_featured) == 1 ? 'selected' : '' }}>بله</option>
                </select>
            </div>

            <div class="form-group">
                <label>تاریخ انتشار</label>
                <input type="datetime-local" name="published_at" class="input-dark" value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}" />
            </div>

            <div class="form-group lg:col-span-2">
                <label>عنوان سئو (Meta Title)</label>
                <input type="text" name="meta_title" class="input-dark" value="{{ old('meta_title', $post->meta_title) }}" placeholder="عنوان سئو" />
            </div>

            <div class="form-group lg:col-span-2">
                <label>توضیحات سئو (Meta Description)</label>
                <textarea name="meta_description" class="input-dark" rows="2">{{ old('meta_description', $post->meta_description) }}</textarea>
            </div>
        </div>

        <div class="flex gap-3 mt-4 pt-4 border-t border-[#1a2f4a]">
            <button type="submit" class="btn-emerald">
                <i data-lucide="save" class="w-4 h-4"></i> ذخیره تغییرات
            </button>
            <a href="{{ route('admin.blog.posts') }}" class="btn-rose">
                <i data-lucide="x" class="w-4 h-4"></i> انصراف
            </a>
        </div>

        @if($errors->any())
            <div class="mt-4 p-3 bg-rose-500/10 border border-rose-500/20 rounded-lg text-rose-400 text-sm">
                <ul class="list-disc pr-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>
</div>

<script>
    lucide.createIcons();

    function showToast(message, type = 'info', duration = 3000) {
        const container = document.getElementById('toastContainer');
        const toast = document.createElement('div');
        toast.className = `toast-item toast-${type}`;
        const icons = { success: 'check-circle', error: 'alert-circle', warning: 'alert-triangle', info: 'info' };
        toast.innerHTML = `
            <i data-lucide="${icons[type] || 'info'}" class="w-5 h-5 flex-shrink-0"></i>
            <span class="text-sm font-medium">${message}</span>
        `;
        container.appendChild(toast);
        lucide.createIcons();
        setTimeout(() => { toast.classList.add('hiding'); setTimeout(() => toast.remove(), 300); }, duration);
    }
</script>
@endsection