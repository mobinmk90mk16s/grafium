@extends('admin.layouts.admin')

@section('title', 'ویرایش خدمت | GRAFIUM')

@section('content')
<style>
    .form-card {
        background: #0f1f33;
        border: 1px solid #1a2f4a;
        border-radius: 16px;
        padding: 28px;
        max-width: 800px;
        margin: 0 auto;
    }
    .form-group { margin-bottom: 20px; }
    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #94a3b8;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .input-dark {
        background: #0a1628;
        border: 1px solid #1a2f4a;
        border-radius: 10px;
        padding: 11px 14px;
        color: #e2e8f0;
        font-size: 13px;
        width: 100%;
        transition: border 0.2s;
        font-family: 'Vazirmatn', sans-serif;
    }
    .input-dark:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }
    .input-dark::placeholder { color: #475569; }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    /* ===== IMAGE UPLOAD ===== */
    .image-upload-wrapper {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .image-preview {
        width: 100%;
        height: 220px;
        border-radius: 14px;
        overflow: hidden;
        border: 2px dashed #1a2f4a;
        background: #0a1628;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        transition: all 0.3s;
    }
    .image-preview:hover {
        border-color: #3b82f6;
    }
    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .image-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        color: #475569;
        font-size: 13px;
        font-weight: 500;
    }
    .image-placeholder i {
        width: 40px;
        height: 40px;
        color: #334155;
    }

    .upload-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .upload-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 10px;
        background: rgba(59, 130, 246, 0.1);
        color: #60a5fa;
        border: 1px solid rgba(59, 130, 246, 0.3);
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s;
        font-family: 'Vazirmatn', sans-serif;
    }
    .upload-btn:hover {
        background: rgba(59, 130, 246, 0.2);
        border-color: #3b82f6;
    }

    .delete-image-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 10px;
        background: rgba(244, 63, 94, 0.1);
        color: #fb7185;
        border: 1px solid rgba(244, 63, 94, 0.3);
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s;
        font-family: 'Vazirmatn', sans-serif;
    }
    .delete-image-btn:hover {
        background: rgba(244, 63, 94, 0.2);
        border-color: #f43f5e;
    }

    /* ===== ICON PICKER ===== */
    .icon-picker {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(48px, 1fr));
        gap: 8px;
        padding: 12px;
        background: #0a1628;
        border: 1px solid #1a2f4a;
        border-radius: 10px;
        margin-top: 8px;
    }
    .icon-option {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        background: #0f1f33;
        border: 1px solid #1a2f4a;
        color: #94a3b8;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        transition: all 0.2s;
    }
    .icon-option:hover {
        border-color: #3b82f6;
        color: #60a5fa;
        transform: scale(1.05);
    }
    .icon-option.selected {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        border-color: #3b82f6;
        color: #fff;
        box-shadow: 0 6px 18px rgba(59, 130, 246, 0.35);
    }

    /* ===== BUTTONS ===== */
    .btn-emerald {
        background: rgba(52, 211, 153, 0.08);
        color: #34d399;
        border: 1px solid rgba(52, 211, 153, 0.2);
        padding: 11px 24px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.2s;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-family: 'Vazirmatn', sans-serif;
    }
    .btn-emerald:hover { background: rgba(52, 211, 153, 0.15); }

    .btn-rose {
        background: rgba(244, 63, 94, 0.08);
        color: #fb7185;
        border: 1px solid rgba(244, 63, 94, 0.2);
        padding: 11px 24px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.2s;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-family: 'Vazirmatn', sans-serif;
        text-decoration: none;
    }
    .btn-rose:hover { background: rgba(244, 63, 94, 0.15); }

    .avatar-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #1a2f4a;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #60a5fa;
        font-size: 16px;
    }

    .alert {
        padding: 12px 16px;
        border-radius: 10px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
    }
    .alert-success {
        background: rgba(52, 211, 153, 0.12);
        border: 1px solid rgba(52, 211, 153, 0.2);
        color: #34d399;
    }
    .alert-error {
        background: rgba(244, 63, 94, 0.12);
        border: 1px solid rgba(244, 63, 94, 0.2);
        color: #fb7185;
    }

    @media (max-width: 768px) {
        .main-content { margin-right: 0 !important; padding: 16px !important; }
        .form-card { padding: 18px; }
        .form-row { grid-template-columns: 1fr; }
    }
</style>

<!-- ===== HEADER ===== -->
<div class="flex flex-wrap justify-between items-center pb-4 border-b border-[#1a2f4a] mb-6">
    <div>
        <div class="flex items-center gap-3">
            <i data-lucide="edit-3" class="w-6 h-6 text-blue-400"></i>
            <h1 class="text-2xl font-extrabold text-white">ویرایش خدمت</h1>
        </div>
        <p class="text-sm text-[#475569] mt-0.5 mr-9">ویرایش اطلاعات خدمت {{ $service->title }}</p>
    </div>
    <div class="flex items-center gap-4">
        <span class="text-sm text-[#64748b]">{{ Auth::guard('admin')->user()->name ?? 'ادمین' }}</span>
        <div class="avatar-icon"><i data-lucide="user-circle" class="w-5 h-5"></i></div>
    </div>
</div>

<!-- ===== ALERTS ===== -->
@if(session('success'))
    <div class="alert alert-success">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-error">
        <i data-lucide="alert-circle" class="w-5 h-5"></i>
        <div>
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    </div>
@endif

<!-- ===== FORM ===== -->
<div class="form-card">
    <form action="{{ route('admin.services.update', $service->id) }}" method="POST" enctype="multipart/form-data" id="serviceForm">
        @csrf
        @method('PUT')

        <!-- ===== IMAGE UPLOAD ===== -->
        <div class="form-group">
            <label>
                <i data-lucide="image" class="w-4 h-4"></i>
                عکس خدمت
                <span style="color:#475569;font-weight:400;">(اختیاری - حداکثر ۲ مگابایت)</span>
            </label>

            <div class="image-upload-wrapper">
                <!-- Preview -->
                <div class="image-preview" id="imagePreview">
                    @if($service->image && \Storage::disk('public')->exists($service->image))
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" />
                    @else
                        <div class="image-placeholder">
                            <i data-lucide="image" class="w-10 h-10"></i>
                            <span>عکسی انتخاب نشده</span>
                        </div>
                    @endif
                </div>

                <!-- Actions -->
                <div class="upload-actions">
                    <label for="imageInput" class="upload-btn">
                        <i data-lucide="upload" class="w-4 h-4"></i>
                        {{ $service->image ? 'تغییر عکس' : 'انتخاب عکس' }}
                        <input type="file" id="imageInput" name="image" accept="image/*" style="display:none;" />
                    </label>

                    @if($service->image)
                        <button type="button" class="delete-image-btn" onclick="deleteImage()">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                            حذف عکس
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- ===== TITLE & TYPE ===== -->
        <div class="form-row">
            <div class="form-group">
                <label>
                    <i data-lucide="type" class="w-4 h-4"></i>
                    عنوان خدمت
                </label>
                <input type="text" name="title" class="input-dark" value="{{ old('title', $service->title) }}" required />
            </div>

            <div class="form-group">
                <label>
                    <i data-lucide="tag" class="w-4 h-4"></i>
                    نوع خدمت
                </label>
                <select name="type" class="input-dark" required>
                    <option value="shift" {{ old('type', $service->type) == 'shift' ? 'selected' : '' }}>شیفتی</option>
                    <option value="hourly" {{ old('type', $service->type) == 'hourly' ? 'selected' : '' }}>ساعتی</option>
                </select>
            </div>
        </div>

        <!-- ===== STATUS & PRICE ===== -->
        <div class="form-row">
            <div class="form-group">
                <label>
                    <i data-lucide="activity" class="w-4 h-4"></i>
                    وضعیت
                </label>
                <select name="status" class="input-dark" required>
                    <option value="active" {{ old('status', $service->status) == 'active' ? 'selected' : '' }}>فعال</option>
                    <option value="inactive" {{ old('status', $service->status) == 'inactive' ? 'selected' : '' }}>غیرفعال</option>
                </select>
            </div>

            <div class="form-group">
                <label>
                    <i data-lucide="dollar-sign" class="w-4 h-4"></i>
                    قیمت پایه (تومان)
                </label>
                <input type="number" name="price" class="input-dark" value="{{ old('price', $service->price) }}" min="0" required />
            </div>
        </div>

        <!-- ===== PLACE ===== -->
        <div class="form-group">
            <label>
                <i data-lucide="map-pin" class="w-4 h-4"></i>
                مکان
            </label>
            <input type="text" name="place" class="input-dark" value="{{ old('place', $service->place) }}" placeholder="مثلاً: سالن اصلی" />
        </div>

        <!-- ===== DESCRIPTION ===== -->
        <div class="form-group">
            <label>
                <i data-lucide="file-text" class="w-4 h-4"></i>
                توضیحات
            </label>
            <textarea name="description" class="input-dark" rows="4" placeholder="توضیحات کامل خدمت...">{{ old('description', $service->description) }}</textarea>
        </div>

        <!-- ===== ICON PICKER ===== -->
        <div class="form-group">
            <label>
                <i data-lucide="star" class="w-4 h-4"></i>
                آیکون خدمت
                <span style="color:#475569;font-weight:400;">(روی عکس نمایش داده می‌شود)</span>
            </label>
            <input type="hidden" name="icon" id="iconInput" value="{{ old('icon', $service->icon) }}" />

            <div class="icon-picker" id="iconPicker">
                @php
                    $icons = [
                        'fa-desktop', 'fa-crown', 'fa-shield-alt', 'fa-microchip',
                        'fa-camera-retro', 'fa-door-open', 'fa-print', 'fa-coffee',
                        'fa-paint-brush', 'fa-camera', 'fa-video', 'fa-couch',
                        'fa-users', 'fa-concierge-bell', 'fa-laptop-code', 'fa-wifi',
                    ];
                @endphp
                @foreach($icons as $icon)
                    <div class="icon-option {{ $service->icon == $icon ? 'selected' : '' }}"
                         data-icon="{{ $icon }}"
                         onclick="selectIcon('{{ $icon }}')">
                        <i class="fas {{ $icon }}"></i>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- ===== CONFIG (JSON) ===== -->
        <div class="form-group">
            <label>
                <i data-lucide="settings" class="w-4 h-4"></i>
                تنظیمات پیشرفته (JSON)
                <span style="color:#475569;font-weight:400;">(اختیاری)</span>
            </label>
            <textarea name="config" class="input-dark" rows="3" placeholder='{"key": "value"}' dir="ltr" style="font-family: monospace;">{{ old('config', $service->config ? json_encode($service->config, JSON_UNESCAPED_UNICODE) : '') }}</textarea>
        </div>

        <!-- ===== ACTIONS ===== -->
        <div class="flex gap-3 mt-6 pt-6 border-t border-[#1a2f4a]">
            <button type="submit" class="btn-emerald">
                <i data-lucide="save" class="w-4 h-4"></i> ذخیره تغییرات
            </button>
            <a href="{{ route('admin.services.index') }}" class="btn-rose">
                <i data-lucide="x" class="w-4 h-4"></i> انصراف
            </a>
        </div>
    </form>
</div>

<script>
    lucide.createIcons();

    // ============================================================
    // IMAGE PREVIEW
    // ============================================================
    document.getElementById('imageInput')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        if (file.size > 2 * 1024 * 1024) {
            alert('حجم عکس نباید بیشتر از ۲ مگابایت باشه.');
            this.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById('imagePreview').innerHTML = 
                `<img src="${event.target.result}" alt="پیش‌نمایش" />`;
        };
        reader.readAsDataURL(file);
    });

    // ============================================================
    // DELETE IMAGE
    // ============================================================
    async function deleteImage() {
        if (!confirm('آیا از حذف عکس اطمینان دارید؟')) return;

        try {
            const res = await fetch('{{ route("admin.services.delete-image", $service->id) }}', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            });
            const data = await res.json();
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'خطا در حذف');
            }
        } catch (err) {
            alert('خطا در ارتباط با سرور');
        }
    }

    // ============================================================
    // ICON PICKER
    // ============================================================
    function selectIcon(icon) {
        document.querySelectorAll('.icon-option').forEach(el => el.classList.remove('selected'));
        document.querySelector(`.icon-option[data-icon="${icon}"]`)?.classList.add('selected');
        document.getElementById('iconInput').value = icon;
    }
</script>
@endsection