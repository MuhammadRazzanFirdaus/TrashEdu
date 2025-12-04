<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - TrashEdu</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-collapsed: 80px;
            --primary-green: #2e7d32;
            --light-green: #66bb6a;
            --pale-green: #e8f5e9;
            --dark-green: #1b5e20;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8fdf8;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-green), var(--dark-green));
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .sidebar-header {
            justify-content: center;
            padding: 1.5rem 0.5rem;
        }

        .logo {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 6px;
        }

        .brand-text {
            font-size: 1.3rem;
            font-weight: 700;
            transition: opacity 0.3s ease;
        }

        .sidebar.collapsed .brand-text {
            opacity: 0;
            width: 0;
        }

        /* ===== SIDEBAR MENU ===== */
        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-section {
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.6);
            padding: 0 1.5rem;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .section-title {
            opacity: 0;
            height: 0;
            margin: 0;
            padding: 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.9rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            border-left: 3px solid transparent;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: var(--light-green);
            padding-left: 1.8rem;
        }

        .menu-item.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border-left-color: var(--light-green);
            box-shadow: inset 0 0 20px rgba(255, 255, 255, 0.05);
        }

        .menu-item i {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .menu-item:hover i {
            transform: scale(1.1);
        }

        .menu-text {
            font-weight: 500;
            transition: opacity 0.3s ease;
            white-space: nowrap;
        }

        .sidebar.collapsed .menu-text {
            opacity: 0;
            width: 0;
        }

        .sidebar.collapsed .badge {
            display: none;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
        }

        .sidebar.collapsed~.main-content {
            margin-left: var(--sidebar-collapsed);
        }

        /* ===== TOP BAR ===== */
        .top-bar {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .toggle-sidebar {
            background: none;
            border: none;
            color: var(--primary-green);
            font-size: 1.3rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .toggle-sidebar:hover {
            background: var(--pale-green);
            transform: rotate(180deg);
        }

        .page-title h1 {
            color: var(--dark-green);
            font-weight: 700;
            margin: 0;
            font-size: 1.8rem;
            transition: all 0.3s ease;
        }

        .page-title .breadcrumb {
            margin: 0;
            font-size: 0.9rem;
            color: var(--light-green);
        }

        .breadcrumb-item.active {
            color: var(--primary-green);
            font-weight: 600;
        }

        .user-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* ===== USER PROFILE DROPDOWN ===== */
        .user-profile-dropdown {
            position: relative;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.5rem 1rem;
            background: var(--pale-green);
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }

        .user-profile:hover {
            background: #d1fae5;
            transform: translateY(-1px);
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-green);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1rem;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .user-name {
            font-weight: 600;
            color: var(--dark-green);
            font-size: 0.9rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--light-green);
            text-transform: capitalize;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }

        .dropdown-arrow {
            transition: transform 0.3s ease;
            color: var(--primary-green);
        }

        .user-profile.show .dropdown-arrow {
            transform: rotate(180deg);
        }

        /* Dropdown Menu */
        .user-dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.5rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(0, 0, 0, 0.1);
            min-width: 200px;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .user-dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #1a3c2a;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .dropdown-item:hover {
            background: rgba(34, 197, 94, 0.1);
            color: #166534;
        }

        .dropdown-item i {
            width: 16px;
            text-align: center;
            color: #22c55e;
        }

        .dropdown-item.logout-item:hover {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
        }

        .dropdown-item.logout-item:hover i {
            color: #dc2626;
        }

        /* ===== CONTENT AREA ===== */
        .content-area {
            padding: 2rem;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0 !important;
            }

            .top-bar {
                padding: 1rem;
            }

            .page-title h1 {
                font-size: 1.5rem;
            }

            .user-name {
                max-width: 120px;
            }

            .user-role {
                max-width: 120px;
            }
        }

        @media (max-width: 576px) {
            .user-name {
                max-width: 100px;
                font-size: 0.85rem;
            }

            .user-role {
                max-width: 100px;
                font-size: 0.7rem;
            }

            .user-profile {
                padding: 0.4rem 0.8rem;
            }

            .page-title h1 {
                font-size: 1.3rem;
            }
        }

        /* ===== SCROLLBAR ===== */
        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 2px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
    </style>
    @stack('style')
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <img src="{{ asset('images/logo.png') }}" alt="TrashEdu Logo">
                </div>
                <div class="brand-text">TrashEdu Admin</div>
            </div>

            <nav class="sidebar-menu">
                <!-- Main Section -->
                <div class="menu-section">
                    <div class="section-title">Main</div>
                    <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                        data-page-title="Dashboard Overview" data-breadcrumb="Dashboard" data-route-pattern="dashboard">
                        <i class="bi bi-speedometer2"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </div>

                <!-- Content Management -->
                <div class="menu-section">
                    <div class="section-title">Content Management</div>
                    <a href="{{ route('admin.users.index') }}" class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                        data-page-title="User Management" data-breadcrumb="Users" data-route-pattern="users">
                        <i class="bi bi-people"></i>
                        <span class="menu-text">Users</span>
                    </a>
                    <a href="{{ route('admin.articles.index') }}" class="menu-item {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}"
                        data-page-title="Article Management" data-breadcrumb="Articles" data-route-pattern="articles">
                        <i class="bi bi-journal-text"></i>
                        <span class="menu-text">Articles</span>
                    </a>
                    <a href="{{ route('admin.quizzes.index') }}" class="menu-item {{ request()->routeIs('admin.quizzes.*') && !request()->routeIs('admin.progress.*') ? 'active' : '' }}"
                        data-page-title="Quiz Management" data-breadcrumb="Quiz" data-route-pattern="quizzes">
                        <i class="bi bi-question-circle"></i>
                        <span class="menu-text">Quiz</span>
                    </a>
                </div>

                <!-- Analytics & Progress -->
                <div class="menu-section">
                    <div class="section-title">Analytics</div>
                    <a href="{{ route('admin.progress.index') }}" class="menu-item {{ request()->routeIs('admin.progress.*') ? 'active' : '' }}"
                        data-page-title="Progress Quiz" data-breadcrumb="Progress" data-route-pattern="progress">
                        <i class="bi bi-graph-up"></i>
                        <span class="menu-text">Progress Quiz</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="d-flex align-items-center gap-3">
                    <button class="toggle-sidebar">
                        <i class="bi bi-list"></i>
                    </button>
                    <div class="page-title">
                        <h1 id="pageTitle">Dashboard Overview</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb" id="pageBreadcrumb">
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="user-actions">

                    <!-- User Profile dengan Dropdown -->
                    <div class="user-profile-dropdown">
                        <button class="user-profile" id="userProfileDropdown">
                            <div class="avatar" id="userAvatar">
                                {{-- Ambil inisial dari nama user --}}
                                @auth
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                @else
                                    A
                                @endauth
                            </div>
                            <div class="user-info">
                                <div class="user-name" id="userName">
                                    {{ Auth::user()->name ?? 'Admin User' }}
                                </div>
                                <div class="user-role" id="userRole">
                                    {{-- Format role menjadi lebih readable --}}
                                    @auth
                                        @if(Auth::user()->role === 'admin')
                                            Administrator
                                        @elseif(Auth::user()->role === 'staff')
                                            Staff
                                        @else
                                            {{ ucfirst(Auth::user()->role) }}
                                        @endif
                                    @else
                                        Administrator
                                    @endauth
                                </div>
                            </div>
                            <i class="bi bi-chevron-down dropdown-arrow"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div class="user-dropdown-menu" id="userDropdownMenu">
                            <div class="dropdown-header px-3 py-2 text-muted small">
                                Signed in as<br>
                                <strong>{{ Auth::user()->email ?? 'admin@example.com' }}</strong>
                            </div>
                            <div class="dropdown-divider"></div>

                            <a href="#" class="dropdown-item">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="bi bi-gear"></i>
                                <span>Settings</span>
                            </a>
                            <div class="dropdown-divider"></div>

                            {{-- Logout Form --}}
                            <form method="GET" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item logout-item" onclick="handleLogout()">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="content-area">
                @yield('content')
                <!-- Content akan diisi oleh child templates -->
            </div>
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/47.1.0/ckeditor5.umd.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.querySelector('.toggle-sidebar');
            const sidebar = document.querySelector('.sidebar');
            const userProfileDropdown = document.getElementById('userProfileDropdown');
            const userDropdownMenu = document.getElementById('userDropdownMenu');
            const pageTitle = document.getElementById('pageTitle');
            const pageBreadcrumb = document.getElementById('pageBreadcrumb');

            // Toggle sidebar
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
            });

            // Toggle user dropdown
            userProfileDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
                userProfileDropdown.classList.toggle('show');
                userDropdownMenu.classList.toggle('show');
            });

            // Close dropdown ketika klik di luar
            document.addEventListener('click', function(e) {
                if (!userProfileDropdown.contains(e.target)) {
                    userProfileDropdown.classList.remove('show');
                    userDropdownMenu.classList.remove('show');
                }
            });

            // Dynamic Page Title berdasarkan menu yang aktif
            function updatePageTitle(menuItem) {
                const title = menuItem.getAttribute('data-page-title');
                const breadcrumb = menuItem.getAttribute('data-breadcrumb');

                if (title) {
                    pageTitle.textContent = title;
                    document.title = `${title} - TrashEdu Admin`;
                }

                if (breadcrumb) {
                    pageBreadcrumb.innerHTML = `<li class="breadcrumb-item active">${breadcrumb}</li>`;
                }
            }

            // Active menu item handling dengan update title
            const menuItems = document.querySelectorAll('.menu-item');
            menuItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    if (!this.classList.contains('active')) {
                        menuItems.forEach(i => i.classList.remove('active'));
                        this.classList.add('active');
                        updatePageTitle(this);
                    }
                });
            });

            // Set page title berdasarkan URL saat ini
            function setInitialPageTitle() {
                const currentPath = window.location.pathname;
                const menuItems = document.querySelectorAll('.menu-item');
                let currentMenuItem = null;

                menuItems.forEach(item => {
                    const routePattern = item.getAttribute('data-route-pattern');
                    if (routePattern && currentPath.includes(routePattern)) {
                        currentMenuItem = item;
                    }
                });

                // Fallback ke dashboard jika tidak ditemukan
                if (!currentMenuItem) {
                    currentMenuItem = document.querySelector('.menu-item[data-route-pattern="dashboard"]');
                }

                if (currentMenuItem) {
                    menuItems.forEach(i => i.classList.remove('active'));
                    currentMenuItem.classList.add('active');
                    updatePageTitle(currentMenuItem);
                }
            }

            // Mobile sidebar handling
            function handleResize() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('collapsed');
                }
            }

            // Initialize
            window.addEventListener('resize', handleResize);
            handleResize();
            setInitialPageTitle();
        });
    </script>
    @stack('script')
</body>
</html>
