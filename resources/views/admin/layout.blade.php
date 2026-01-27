<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Ensiklopedia Sastra Indonesia')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #7c3aed;
            --sidebar-width: 250px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--primary-color);
            padding: 2rem 0;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar-brand {
            color: white;
            text-align: center;
            padding: 0 1.5rem 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 2rem;
        }

        .sidebar-brand h5 {
            margin: 0;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
        }

        .sidebar-menu li {
            margin: 0;
        }

        .sidebar-menu a {
            display: block;
            padding: 1rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: white;
        }

        .sidebar-menu a i {
            width: 20px;
            margin-right: 10px;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        /* Topbar */
        .topbar {
            background: white;
            padding: 1.5rem 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar h2 {
            margin: 0;
            color: var(--primary-color);
            font-weight: 700;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .logout-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.3s;
        }

        .logout-btn:hover {
            background: #c82333;
            color: white;
        }

        /* Content */
        .content {
            padding: 2rem;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }

        .card-header {
            background: var(--primary-color);
            color: white;
            border-radius: 10px 10px 0 0;
            padding: 1.5rem;
            font-weight: 600;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Buttons */
        .btn-primary {
            background: var(--primary-color);
            border: none;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background: #6d28d9;
            transform: translateY(-2px);
        }

        .btn-sm {
            padding: 0.5rem 0.75rem;
            font-size: 0.85rem;
        }

        /* Table */
        .table {
            margin: 0;
        }

        .table thead {
            background: #f8f9fa;
        }

        .table thead th {
            border: none;
            color: #333;
            font-weight: 600;
            padding: 1rem;
        }

        .table tbody td {
            border-color: #eee;
            vertical-align: middle;
            padding: 1rem;
        }

        .table tbody tr:hover {
            background: #f8f9fa;
        }

        /* Forms */
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 0.8rem;
            transition: border-color 0.3s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
        }

        /* Alert */
        .alert {
            border: none;
            border-radius: 8px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }

        /* Badge */
        .badge {
            padding: 0.4rem 0.8rem;
            border-radius: 5px;
        }

        .badge-primary {
            background: var(--primary-color);
        }

        /* Stat Cards */
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0.5rem 0;
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
        }

        .stat-icon {
            font-size: 2rem;
            color: var(--primary-color);
            opacity: 0.2;
            margin-bottom: 0.5rem;
        }

        /* Image Preview */
        .image-preview {
            max-width: 200px;
            max-height: 200px;
            object-fit: contain;
            border-radius: 8px;
            margin: 1rem 0;
            background: #f8f9fa;
        }

        .image-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .image-item {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .image-item img {
            width: 100%;
            height: 150px;
            object-fit: contain;
            background: #f8f9fa;
        }

        .image-delete-btn {
            position: absolute;
            top: 0;
            right: 0;
            background: rgba(255, 0, 0, 0.8);
            color: white;
            border: none;
            padding: 0.5rem;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .image-item:hover .image-delete-btn {
            opacity: 1;
        }

        /* Responsive */
        @media (max-width: 768px) {
            :root {
                --sidebar-width: 0;
            }

            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .content {
                padding: 1rem;
            }
        }
    </style>
    @yield('extra-css')
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <img src="https://vicious-purple-krocduknct.edgeone.app/logo-logo%20template_badan%20Bahasa_20205-01.png"
                style="max-width: 50px; height: auto;">
            <h5>ADMIN</h5>
            <small style="opacity: 0.8;">Ensiklopedia Sastra</small>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="@if(request()->routeIs('admin.dashboard')) active @endif">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.contents.index') }}"
                    class="@if(request()->routeIs('admin.contents.*')) active @endif">
                    <i class="fas fa-file-alt"></i> Kelola Konten
                </a>
            </li>
            <li>
                <a href="{{ route('admin.categories.index') }}"
                    class="@if(request()->routeIs('admin.categories.*')) active @endif">
                    <i class="fas fa-folder"></i> Kelola Kategori
                </a>
            </li>
            <li>
                <a href="{{ route('home') }}" target="_blank">
                    <i class="fas fa-globe"></i> Lihat Website
                </a>
            </li>
            <li style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid rgba(255, 255, 255, 0.2);">
                <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="logout-btn" style="width: 100%; text-align: left; border-radius: 0;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <h2>@yield('page-title')</h2>
            <div class="user-menu">
                <span style="color: #666;">
                    <i class="fas fa-user-circle"></i> {{ Auth::user()->name ?? 'Admin' }}
                </span>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('extra-js')
</body>

</html>