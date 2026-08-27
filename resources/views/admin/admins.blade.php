<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدیریت مدیران | GRAFIUM</title>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Vazirmatn', sans-serif;
            background: #0a1628;
            color: #fff;
            min-height: 100vh;
        }
        .sidebar {
            position: fixed;
            right: 0;
            top: 0;
            width: 260px;
            height: 100vh;
            background: #132238;
            border-left: 1px solid #1a2f4a;
            padding: 30px 20px;
            overflow-y: auto;
        }
        .sidebar .logo { text-align: center; margin-bottom: 30px; }
        .sidebar .logo h2 { color: #d4a373; font-size: 22px; }
        .sidebar .logo p { color: #64748b; font-size: 13px; }
        .sidebar nav ul { list-style: none; }
        .sidebar nav ul li { margin-bottom: 4px; }
        .sidebar nav ul li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 10px;
            color: #94a3b8;
            text-decoration: none;
            transition: 0.3s;
            font-size: 14px;
        }
        .sidebar nav ul li a i { width: 20px; color: #d4a373; }
        .sidebar nav ul li a:hover { background: rgba(212, 163, 115, 0.08); color: #fff; }
        .sidebar nav ul li a.active { background: rgba(212, 163, 115, 0.12); color: #d4a373; }
        .sidebar nav ul li .logout-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 10px;
            color: #ef4444;
            text-decoration: none;
            transition: 0.3s;
            font-size: 14px;
            background: none;
            border: none;
            width: 100%;
            cursor: pointer;
            font-family: 'Vazirmatn', sans-serif;
        }
        .sidebar nav ul li .logout-btn i { width: 20px; color: #ef4444; }
        .sidebar nav ul li .logout-btn:hover { background: rgba(239, 68, 68, 0.08); }
        .main-content {
            margin-right: 260px;
            padding: 30px 40px;
        }
        .header-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #1a2f4a;
            margin-bottom: 30px;
        }
        .header-bar h1 { font-size: 24px; color: #d4a373; }
        .header-bar .user-info { display: flex; align-items: center; gap: 12px; }
        .header-bar .user-info span { color: #94a3b8; font-size: 14px; }
        .table-wrap { overflow-x: auto; background: #132238; border-radius: 12px; border: 1px solid #1a2f4a; padding: 20px; }
        .table-wrap table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .table-wrap thead { border-bottom: 2px solid #1a2f4a; }
        .table-wrap th { padding: 12px 16px; text-align: right; color: #94a3b8; font-weight: 600; }
        .table-wrap td { padding: 12px 16px; border-bottom: 1px solid #1a2f4a; }
        .table-wrap tr:hover td { background: rgba(212, 163, 115, 0.03); }
        .badge {
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-active { background: #dcfce7; color: #166534; }
        .badge-inactive { background: #fee2e2; color: #991b1b; }
        .badge-super_admin { background: #dbeafe; color: #1e40af; }
        .badge-manager { background: #fef3c7; color: #92400e; }
        .badge-support { background: #f3e8ff; color: #6b21a8; }
        .btn {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
            border: none;
            cursor: pointer;
        }
        .btn-sm { padding: 4px 12px; font-size: 12px; }
        .btn-gold { background: #d4a373; color: #0a1628; }
        .btn-gold:hover { background: #b8874a; }
        .btn-danger { background: #ef4444; color: #fff; }
        .btn-danger:hover { background: #dc2626; }
        .btn-info { background: #3b82f6; color: #fff; }
        .btn-info:hover { background: #2563eb; }
        .btn-success { background: #22c55e; color: #fff; }
        .btn-success:hover { background: #16a34a; }
        .actions { display: flex; gap: 8px; flex-wrap: wrap; }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 12px;
        }
        .alert {
            padding: 12px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .alert-success { background: #dcfce7; color: #166534; }
        .alert-danger { background: #fee2e2; color: #991b1b; }
        .form-box {
            background: #132238;
            padding: 25px;
            border-radius: 12px;
            border: 1px solid #1a2f4a;
            margin-bottom: 30px;
        }
        .form-box h3 { color: #d4a373; margin-bottom: 16px; }
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }
        .form-group { margin-bottom: 0; }
        .form-group label {
            display: block;
            color: #c8c8d4;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 4px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px 14px;
            border: 2px solid #1a2f4a;
            border-radius: 8px;
            background: #0a1628;
            color: #fff;
            font-size: 14px;
            transition: 0.3s;
            font-family: 'Vazirmatn', sans-serif;
        }
        .form-group input:focus, .form-group select:focus {
            border-color: #d4a373;
            outline: none;
            box-shadow: 0 0 0 3px rgba(212, 163, 115, 0.1);
        }
        .form-group input::placeholder { color: #64748b; }
        .form-group select option { background: #132238; color: #fff; }
        .form-actions { margin-top: 16px; display: flex; gap: 10px; }
        @media (max-width: 768px) {
            .sidebar { width: 100%; height: auto; position: relative; border-left: none; border-bottom: 1px solid #1a2f4a; }
            .main-content { margin-right: 0; padding: 20px; }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="logo">
            <h2>🏛️ GRAFIUM</h2>
            <p>پنل مدیریت</p>
        </div>
        <nav>
            <ul>
                <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> داشبورد</a></li>
                <li><a href="{{ route('admin.admins.index') }}" class="active"><i class="fas fa-users-cog"></i> مدیریت مدیران</a></li>
                <li><a href="#"><i class="fas fa-users"></i> کاربران</a></li>
                <li><a href="#"><i class="fas fa-chair"></i> میزها</a></li>
                <li><a href="#"><i class="fas fa-calendar-check"></i> رزروها</a></li>
                <li><a href="#"><i class="fas fa-file-invoice"></i> فاکتورها</a></li>
                <li>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="fas fa-sign-out-alt"></i> خروج از پنل
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </aside>

    <main class="main-content">
        <div class="header-bar">
            <h1>👑 مدیریت مدیران</h1>
            <div class="user-info">
                <span>{{ Auth::guard('admin')->user()->name ?? 'ادمین' }}</span>
                <i class="fas fa-user-circle" style="font-size:32px;color:#d4a373;"></i>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="list-style:none;padding:0;">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- ====== فرم افزودن مدیر جدید ====== -->
        <div class="form-box">
            <h3>➕ افزودن مدیر جدید</h3>
            <form method="POST" action="{{ route('admin.admins.store') }}">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label>نام کامل</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="علی محمدی" required>
                    </div>

                    <div class="form-group">
                        <label>ایمیل</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@example.com" required>
                    </div>

                    <div class="form-group">
                        <label>شماره تماس</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="09123456789">
                    </div>

                    <div class="form-group">
                        <label>رمز عبور</label>
                        <input type="password" name="password" placeholder="حداقل ۸ کاراکتر" required>
                    </div>

                    <div class="form-group">
                        <label>نقش کاربری</label>
                        <select name="role" required>
                            <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>مدیر اصلی</option>
                            <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>مدیر</option>
                            <option value="support" {{ old('role') == 'support' ? 'selected' : '' }}>پشتیبان</option>
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-gold">
                        <i class="fas fa-save"></i> ذخیره مدیر
                    </button>
                </div>
            </form>
        </div>

        <!-- ====== لیست مدیران ====== -->
        <div class="top-bar">
            <h3 style="color:#94a3b8;">📋 لیست مدیران سیستم</h3>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>نام</th>
                        <th>ایمیل</th>
                        <th>نقش</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $admin)
                    <tr>
                        <td><strong>{{ $admin->name }}</strong></td>
                        <td>{{ $admin->email }}</td>
                        <td>
                            <span class="badge badge-{{ $admin->role }}">
                                @switch($admin->role)
                                    @case('super_admin') مدیر اصلی @break
                                    @case('manager') مدیر @break
                                    @case('support') پشتیبان @break
                                    @default {{ $admin->role }}
                                @endswitch
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-{{ $admin->is_active ? 'active' : 'inactive' }}">
                                {{ $admin->is_active ? 'فعال' : 'غیرفعال' }}
                            </span>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.admins.edit', $admin->id) }}" class="btn btn-gold btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($admin->id != Auth::guard('admin')->id())
                                <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('آیا از حذف این مدیر اطمینان دارید؟')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:40px 0;color:#64748b;">
                            <i class="fas fa-users-slash" style="font-size:24px;display:block;margin-bottom:8px;"></i>
                            هیچ مدیری در سیستم یافت نشد.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>