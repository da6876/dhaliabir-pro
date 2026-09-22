<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Simple Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontSize: {
                        'xs': ['0.75rem', { lineHeight: '1rem' }],
                        'sm': ['0.875rem', { lineHeight: '1.25rem' }],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 font-sans text-sm">
<div class="flex h-screen">

    <!-- Sidebar -->
    <!-- Sidebar -->
    <div id="sidebar" class="bg-white shadow-lg w-64 flex-shrink-0 transition-all duration-300">
        <div class="p-4">
            <h2 class="text-lg font-semibold text-gray-800">Dashboard</h2>
            <nav class="mt-4 space-y-1">
                <a href="{{ url('/') }}" class="block py-2 px-4 rounded {{ request()->is('/') ? 'bg-gray-200 text-gray-800 font-semibold' : 'text-gray-600 hover:bg-gray-200' }}">Home</a>
                <a href="{{ url('about') }}" class="block py-2 px-4 rounded {{ request()->is('about') ? 'bg-gray-200 text-gray-800 font-semibold' : 'text-gray-600 hover:bg-gray-200' }}">About</a>
                <a href="{{ url('resume') }}" class="block py-2 px-4 rounded {{ request()->is('resume') ? 'bg-gray-200 text-gray-800 font-semibold' : 'text-gray-600 hover:bg-gray-200' }}">Resume</a>
                <a href="{{ url('experience') }}" class="block py-2 px-4 rounded {{ request()->is('experience') ? 'bg-gray-200 text-gray-800 font-semibold' : 'text-gray-600 hover:bg-gray-200' }}">Experience</a>
                <a href="{{ url('education') }}" class="block py-2 px-4 rounded {{ request()->is('education') ? 'bg-gray-200 text-gray-800 font-semibold' : 'text-gray-600 hover:bg-gray-200' }}">Education</a>
                <a href="{{ url('services') }}" class="block py-2 px-4 rounded {{ request()->is('services*') ? 'bg-gray-200 text-gray-800 font-semibold' : 'text-gray-600 hover:bg-gray-200' }}">Services</a>
                <a href="{{ url('portfolio') }}" class="block py-2 px-4 rounded {{ request()->is('portfolio*') ? 'bg-gray-200 text-gray-800 font-semibold' : 'text-gray-600 hover:bg-gray-200' }}">Portfolio</a>

                <!-- User Config Parent -->
                <div x-data="{ open: {{ request()->is('users*') || request()->is('roles*') || request()->is('permissions*') ? 'true' : 'false' }} }" class="mt-2">
                    <button @click="open = !open"
                            class="w-full flex justify-between items-center py-2 px-4 rounded text-gray-600 hover:bg-gray-200 focus:outline-none">
                        <span>User Config</span>
                        <svg :class="{'rotate-90': open}" class="h-4 w-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <div x-show="open" class="mt-1 ml-4 space-y-1" x-transition>
                        <a href="{{ route('users.index') }}" class="block py-2 px-4 rounded {{ request()->is('users*') ? 'bg-gray-200 text-gray-800 font-semibold' : 'text-gray-600 hover:bg-gray-200' }}">Users</a>
                        <a href="{{ route('roles.index') }}" class="block py-2 px-4 rounded {{ request()->is('roles*') ? 'bg-gray-200 text-gray-800 font-semibold' : 'text-gray-600 hover:bg-gray-200' }}">Roles</a>
                        <a href="{{ route('permissions.index') }}" class="block py-2 px-4 rounded {{ request()->is('permissions*') ? 'bg-gray-200 text-gray-800 font-semibold' : 'text-gray-600 hover:bg-gray-200' }}">Permissions</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>



    <!-- Main Content -->
    <div class="flex-1 flex flex-col">

        <!-- Topbar -->
        <header class="bg-white shadow-sm p-4 flex justify-between items-center">
            <div class="flex items-center">
                <button id="sidebar-toggle" class="text-gray-600 hover:text-gray-800 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <h1 class="text-lg font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
            </div>

            <div class="relative">
                <button id="profile-dropdown" class="flex items-center text-gray-600 hover:text-gray-800">
                    <img src="https://via.placeholder.com/32" alt="Profile" class="w-8 h-8 rounded-full mr-2">
                    <span>{{ Auth::user()->name ?? 'John Doe' }}</span>
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="dropdown-menu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10 hidden">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                    <button id="toggle-sidebar" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Toggle Sidebar</button>
                    <form method="POST" action="#">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-6 overflow-auto">
            @yield('content')
        </main>

    </div>
</div>

<!-- JS -->
<script>
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const toggleSidebar = document.getElementById('toggle-sidebar');
    const profileDropdown = document.getElementById('profile-dropdown');
    const dropdownMenu = document.getElementById('dropdown-menu');

    function toggleSidebarVisibility() {
        sidebar.classList.toggle('hidden');
    }

    sidebarToggle?.addEventListener('click', toggleSidebarVisibility);
    toggleSidebar?.addEventListener('click', toggleSidebarVisibility);

    profileDropdown?.addEventListener('click', () => {
        dropdownMenu.classList.toggle('hidden');
    });

    document.addEventListener('click', (e) => {
        if (!profileDropdown.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });
</script>
<!-- Make sure you have Alpine.js included for x-data, x-show -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@stack('scripts')
</body>
</html>
