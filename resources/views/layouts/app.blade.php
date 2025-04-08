<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - @yield('title')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            height: 100vh;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            border-right: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-header {
            padding: 20px;
            background: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand-text h3 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .text-primary { color: #667eea; }
        .text-secondary { color: #6B7280; }

        .nav-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-item {
            margin: 5px 15px;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .nav-item a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #6B7280;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 15px;
            font-weight: 500;
            gap: 12px;
        }

        .nav-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            transition: all 0.3s ease;
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }

        .nav-item:hover {
            background: rgba(102, 126, 234, 0.1);
        }

        .nav-item:hover .nav-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: scale(1.1);
        }

        .nav-item.active {
            background: rgba(102, 126, 234, 0.1);
        }

        .nav-item.active a {
            color: #667eea;
        }

        .nav-item.active .nav-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .nav-divider {
            height: 1px;
            background: rgba(0, 0, 0, 0.1);
            margin: 10px 15px;
        }

        .nav-item.logout .nav-icon {
            background: rgba(229, 62, 62, 0.1);
            color: #e53e3e;
        }

        .nav-item.logout:hover {
            background: rgba(229, 62, 62, 0.1);
        }

        .nav-item.logout:hover a {
            color: #e53e3e;
        }

        .nav-item.logout:hover .nav-icon {
            background: #e53e3e;
            color: white;
        }

        /* Custom Scrollbar */
        .sidebar-nav::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(220, 38, 38, 0.2);
            border-radius: 3px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb:hover {
            background: rgba(220, 38, 38, 0.4);
        }

        /* Add margin to main content to prevent overlap with sidebar */
        .main-content {
            margin-left: 250px; /* Same as sidebar width */
            width: calc(100% - 250px);
            min-height: 100vh;
        }
        
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body class="bg-secondary">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen">
        @auth
        <!-- Sidebar -->
        <div class="hidden md:block fixed top-0 left-0 h-full">
            <div class="sidebar">
                <div class="sidebar-header">
                    <div class="brand-text">
                        <h3><span class="text-primary">C</span><span class="text-secondary">OM</span><span class="text-primary">PRELI</span></h3>
                    </div>
                </div>
                
                <nav class="sidebar-nav flex-1 px-3 py-4">
                    <ul class="nav-list">
                        <!-- Dashboard Link -->
                        <li class="nav-item {{ request()->routeIs('*.dashboard') ? 'active' : '' }}">
                            <a href="{{ Auth::user()->is_admin ? route('admin.dashboard') : route('employee.dashboard') }}">
                                <div class="nav-icon">
                                    <i class="fas fa-home"></i>
                                </div>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        @if(Auth::user()->is_admin)
                        <!-- Users Link -->
                        <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.users.index') }}">
                                <div class="nav-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <span>Users</span>
                            </a>
                        </li>

                        <!-- Employees Link -->
                        <li class="nav-item {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.employees.index') }}">
                                <div class="nav-icon">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <span>Employees</span>
                            </a>
                        </li>

                        <!-- Requests Link -->
                        <li class="nav-item {{ request()->routeIs('admin.requests.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.requests') }}">
                                <div class="nav-icon">
                                    <i class="fas fa-paper-plane"></i>
                                </div>
                                <span>Requests</span>
                            </a>
                        </li>

                        <!-- Reports Link -->
                        <li class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                            <a href="#">
                                <div class="nav-icon">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <span>Reports</span>
                            </a>
                        </li>
                        @endif
                    </ul>

                    <div class="nav-divider"></div>

                    <!-- Logout Section -->
                    <ul class="nav-list">
                        <li class="nav-item logout">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left">
                                    <div class="nav-icon">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </div>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Navigation -->
           <!-- Top Navigation -->
<div class="w-full px-6 py-4 bg-white shadow rounded-2xl mt-4 mx-4 flex items-center justify-between">
    <!-- Left: Page Title and Subtitle -->
    <div>
        <h1 class="text-lg font-semibold text-gray-800">Administrator Dashboard</h1>
        <p class="text-sm text-gray-500">Manage your website and users</p>
    </div>

    <!-- Right: Icons + User -->
    <div class="flex items-center space-x-4">
        <!-- Notification Icon -->
        <button class="relative text-gray-500 hover:text-purple-600 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <!-- Optional: Red dot -->
            <span class="absolute top-0 right-0 inline-block w-2 h-2 bg-red-500 rounded-full"></span>
        </button>

        <!-- User Profile -->
        <div class="flex items-center space-x-2 bg-purple-100 px-3 py-1.5 rounded-full">
            <div class="bg-purple-500 text-white rounded-full p-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5.121 17.804A13.937 13.937 0 0112 15c2.21 0 4.288.534 6.121 1.477M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</span>
        </div>
    </div>
</div>


            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-secondary">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    @if(session('status'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>

        <!-- Mobile sidebar -->
        <div x-show="sidebarOpen" 
             class="md:hidden fixed inset-0 z-40"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full">
            <div @click="sidebarOpen = false" class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>
            <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white">
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button @click="sidebarOpen = false" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <span class="sr-only">Close sidebar</span>
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <!-- Mobile sidebar content -->
                <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                    <div class="flex-shrink-0 flex items-center px-4">
                        <div class="brand-text">
                            <h3><span class="text-primary">C</span><span class="text-secondary">OM</span><span class="text-primary">PRELI</span></h3>
                        </div>
                    </div>
                    <nav class="mt-5 px-2 space-y-1">
                        <!-- Same navigation items as desktop sidebar -->
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Dashboard
                            </a>
                            <!-- Add other admin menu items here with the same styling -->
                        @else
                            <a href="{{ route('employee.dashboard') }}" class="sidebar-item {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}">
                                <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Dashboard
                            </a>
                        @endif
                    </nav>
                </div>
            </div>
        </div>
        @endauth

        @guest
            <div class="flex-1">
                @yield('content')
            </div>
        @endguest
    </div>

    @yield('scripts')
</body>
</html> 