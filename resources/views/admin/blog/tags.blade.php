@extends('admin.layouts.admin')

@section('title', 'مدیریت تگ‌ها | GRAFIUM')

@section('content')
<style>
    .table-wrap {
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #1a2f4a;
        background: #0f1f33;
    }
    .table-wrap table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .table-wrap thead { background: #0a1628; border-bottom: 1px solid #1a2f4a; }
    .table-wrap thead th {
        padding: 14px 16px; text-align: center; font-weight: 700; font-size: 12px;
        text-transform: uppercase; letter-spacing: 0.5px; color: #94a3b8;
        border-bottom: 1px solid #1a2f4a;
    }
    .table-wrap tbody td { padding: 12px 16px; border-bottom: 1px solid #132238; color: #cbd5e1; vertical-align: middle; text-align: center; }
    .table-wrap tbody tr { transition: background 0.15s; }
    .table-wrap tbody tr:hover { background: rgba(255, 255, 255, 0.02); }

    .badge-tag {
        background: rgba(167, 139, 250, 0.15);
        color: #a78bfa;
        border: 1px solid rgba(167, 139, 250, 0.2);
        padding: 4px 14px;
        border-radius: 9999px;
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
    }

    .btn-blue { background: #1a2f4a; color: #60a5fa; border: 1px solid #2a4a6a; padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
    .btn-blue:hover { background: #2a4a6a; border-color: #3a5a7a; }

    .btn-rose { background: rgba(244, 63, 94, 0.08); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.2); padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
    .btn-rose:hover { background: rgba(244, 63, 94, 0.15); }

    .avatar-icon { width: 36px; height: 36px; border-radius: 50%; background: #1a2f4a; display: flex; align-items: center; justify-content: center; color: #60a5fa; font-size: 16px; }

    @media (max-width: 768px) {
        .main-content { margin-right: 0 !important; padding: 16px !important; }
        .table-wrap { overflow-x: auto; }
        .table-wrap table { font-size: 11px; }
        .table-wrap thead th, .table-wrap tbody td { padding: 8px 6px; }
    }
</style>

<!-- ===== HEADER ===== -->
<div class="flex flex-wrap justify-between items-center pb-4 border-b border-[#1a2f4a] mb-6">
    <div>
        <div class="flex items-center gap-3">
            <i data-lucide="tag" class="w-6 h-6 text-amber-400"></i>
            <h1 class="text-2xl font-extrabold text-white">مدیریت تگ‌ها</h1>
        </div>
        <p class="text-sm text-[#475569] mt-0.5 mr-9">لیست تگ‌های استفاده شده در بلاگ</p>
    </div>
    <div class="flex items-center gap-4">
        <span class="text-sm text-[#64748b]">{{ Auth::guard('admin')->user()->name ?? 'ادمین' }}</span>
        <div class="avatar-icon"><i data-lucide="user-circle" class="w-5 h-5"></i></div>
    </div>
</div>

<!-- ===== TAGS TABLE ===== -->
<div class="table-wrap">
    <div class="overflow-x-auto">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>نام تگ</th>
                    <th>تعداد استفاده</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($allTags as $tag => $count)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <span class="badge-tag">#{{ $tag }}</span>
                    </td>
                    <td>{{ $count }}</td>
                    <td>
                        <div class="flex items-center gap-2 justify-center">
                            <a href="{{ route('admin.blog.posts') }}?tag={{ urlencode($tag) }}" class="text-blue-400 hover:text-blue-300 transition text-sm">
                                <i data-lucide="search" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-8 text-[#475569]">
                        <i data-lucide="tag" class="w-8 h-8 mx-auto text-[#475569] mb-2"></i>
                        <p>هیچ تگی یافت نشد</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    lucide.createIcons();
</script>
@endsection