<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen:false }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        .bg-primary {
            background: linear-gradient(135deg, #0891b2 0%, #3b82f6 100%);
        }
    </style>
</head>

<body class="bg-gray-100 antialiased">

<div class="flex min-h-screen">

    <!-- MOBILE OVERLAY -->
    <div x-show="sidebarOpen"
         x-transition.opacity
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/40 z-40 lg:hidden"></div>

    <!-- SIDEBAR -->
    <aside 
        class="fixed top-0 left-0 h-full w-72 bg-white shadow-xl border-r z-50
               transform transition-transform duration-300 lg:translate-x-0 flex flex-col"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

        <!-- BRAND -->
        <div class="px-6 py-5 border-b flex items-center gap-4">
            <img src="{{ asset('assets/images/logo.png') }}" class="h-12 w-auto">

            <div class="flex flex-col leading-tight">
                <span class="text-[1.15rem] font-bold text-cyan-700">Smart Waste</span>
                <span class="text-xs text-gray-500">Admin Console</span>
            </div>

            <button class="ml-auto lg:hidden text-gray-400 hover:text-gray-600 transition"
                    @click="sidebarOpen=false">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>

        <!-- NAVIGATION -->
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               @if(Request::is('admin/dashboard'))
                    bg-primary text-white shadow
               @else
                    text-gray-700 hover:bg-cyan-50 hover:text-cyan-700
               @endif">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                Dashboard
            </a>

            <a href="{{ route('admin.history') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               @if(Request::is('admin/history'))
                    bg-primary text-white shadow
               @else
                    text-gray-700 hover:bg-cyan-50 hover:text-cyan-700
               @endif">
                <i data-lucide="history" class="w-5 h-5"></i>
                History
            </a>

            <a href="{{ route('admin.settings') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               @if(Request::is('admin/settings'))
                    bg-primary text-white shadow
               @else
                    text-gray-700 hover:bg-cyan-50 hover:text-cyan-700
               @endif">
                <i data-lucide="settings" class="w-5 h-5"></i>
                Settings
            </a>

        </nav>

        <!-- FOOTER -->
        <div class="p-6 border-t">
            <p class="text-xs font-medium text-gray-500 text-center">
                SWB Team – Politeknik Batam
            </p>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 lg:ml-72 p-6 bg-gradient-to-br from-white via-blue-50 to-blue-100">

        <!-- MOBILE NAVBAR -->
        <div class="lg:hidden w-full bg-white shadow-sm flex items-center justify-between px-4 py-3 mb-6">

            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = true" class="p-2 rounded-md bg-gray-100">
                    <i data-lucide="menu" class="w-6 h-6 text-gray-700"></i>
                </button>
                <img src="{{ asset('assets/images/logo.png') }}" class="h-8 w-auto">
            </div>

            <div class="p-1.5 rounded-xl bg-blue-50">
                <i data-lucide="user" class="w-6 h-6 text-blue-600"></i>
            </div>
        </div>

        <!-- PAGE TITLE + ADMIN DROPDOWN -->
        <div class="hidden lg:flex items-center justify-between mb-10">

            <div>@yield('page_title')</div>

            <!-- ADMIN DROPDOWN -->
            <div x-data="{ open:false }" class="relative">
                <button @click="open = !open"
                    class="flex items-center gap-3 px-5 py-2 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow transition">

                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white">
                        <i data-lucide="user" class="w-4 h-4"></i>
                    </div>

                    <span class="font-medium text-gray-700">Admin</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500"></i>
                </button>

                <div x-show="open"
                     @click.away="open=false"
                     x-transition
                     class="absolute right-0 mt-2 w-44 bg-white border rounded-xl shadow-lg py-2">

                    <!-- REFRESH -->
                    <button onclick="location.reload()"
                        class="w-full px-4 py-2 text-left text-sm hover:bg-gray-100 flex items-center gap-2">
                        <i data-lucide="refresh-ccw" class="w-4 h-4"></i>
                        Refresh
                    </button>

                    <!-- LOGOUT -->
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="w-full px-4 py-2 text-left text-sm hover:bg-gray-100 flex items-center gap-2">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- PAGE CONTENT -->
        <div class="mt-4">
            @yield('content')
        </div>

    </main>
</div>

<script> lucide.createIcons(); </script>

</body>
</html>
