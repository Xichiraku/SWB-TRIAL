<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen:false }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script src="https://unpkg.com/lucide@latest"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        .sidebar-active {
            background: linear-gradient(to right, #1F4D1F, #9AD18B);
            color: white !important;
        }

        .green-shadow {
            box-shadow: 0 0 15px rgba(144, 238, 144, 0.4), 0 0 30px rgba(144, 238, 144, 0.2);
        }

        /* Smooth Hide Scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #9AD18B;
            border-radius: 10px;
        }
    </style>
    @yield('head')
</head>

<body class="bg-[#f5f5f5] antialiased">

<div class="flex min-h-screen relative">

    <div x-show="sidebarOpen"
         x-transition:enter="transition opacity-ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition opacity-ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/50 z-[60] lg:hidden">
    </div>

    <aside
        class="fixed top-0 left-0 h-full w-[280px] bg-[#f8f8f8] border-r border-[#9AD18B] z-[70]
               transform transition-transform duration-300 ease-in-out
               lg:translate-x-0 flex flex-col"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

        <div class="h-[100px] lg:h-[125px] border-b border-[#9AD18B] px-6 flex items-center shrink-0">
            <div class="flex items-center gap-3 w-full">
                <img src="{{ asset('assets/images/logo.png') }}" class="h-12 lg:h-16 w-auto">
                <div class="leading-tight">
                    <h1 class="text-[18px] lg:text-[20px] font-bold text-[#264626]">Smart Waste</h1>
                    <p class="text-xs lg:text-sm text-[#3d3d3d]">Admin Console</p>
                </div>
                <button class="ml-auto lg:hidden p-2 rounded-lg hover:bg-gray-200" @click="sidebarOpen=false">
                    <i data-lucide="x" class="w-6 h-6 text-gray-700"></i>
                </button>
            </div>
        </div>

        <nav class="flex-1 px-4 lg:px-6 py-6 overflow-y-auto space-y-2">
            
            @php
                $menus = [
                    ['route' => 'admin.dashboard', 'name' => 'Dashboard', 'icon' => 'layout-dashboard', 'pattern' => 'admin/dashboard'],
                    ['route' => 'admin.history', 'name' => 'Activity Log', 'icon' => 'history', 'pattern' => 'admin/history*'],
                    ['route' => 'admin.report', 'name' => 'Report', 'icon' => 'bar-chart-3', 'pattern' => 'admin/report*'],
                    ['route' => 'admin.settings', 'name' => 'Settings', 'icon' => 'settings', 'pattern' => 'admin/settings*'],
                ];
            @endphp

            @foreach($menus as $menu)
            <a href="{{ route($menu['route']) }}"
               class="flex items-center gap-4 px-5 py-3 lg:py-4 rounded-2xl text-[16px] lg:text-[18px] font-medium transition-all duration-300
               {{ Request::is($menu['pattern']) ? 'sidebar-active shadow-md' : 'text-[#263326] hover:bg-[#dff3d7]' }}">
                <i data-lucide="{{ $menu['icon'] }}" class="w-6 h-6 lg:w-7 lg:h-7"></i>
                <span>{{ $menu['name'] }}</span>
            </a>
            @endforeach

        </nav>

        <div class="p-6 border-t border-[#9AD18B] bg-[#f2f2f2]">
            <p class="text-xs text-[#3f3f3f] text-center font-medium">
                SWB Team - Politeknik Batam
            </p>
        </div>

    </aside>

    <main class="flex-1 w-full lg:ml-[280px] min-w-0 flex flex-col">

        <header class="h-[100px] lg:h-[125px] bg-[#f8f8f8] border-b border-[#9AD18B] px-4 lg:px-8 flex items-center justify-between sticky top-0 z-40">
            
            <div class="flex items-center gap-3 lg:gap-4 overflow-hidden">
                <button @click="sidebarOpen=true" class="lg:hidden p-2 rounded-lg bg-[#dff3d7] hover:bg-[#c9e7bc] transition shrink-0">
                    <i data-lucide="menu" class="w-6 h-6 text-[#264626]"></i>
                </button>

                <div class="truncate">
                    <h2 class="text-[20px] lg:text-[28px] font-extrabold text-[#1F3527] truncate">
                        @yield('header_title', 'Dashboard')
                    </h2>
                    <div class="text-[12px] lg:text-[16px] text-[#4a4a4a] flex items-center gap-2">
                        <i data-lucide="clock" class="w-3 h-3 lg:w-4 lg:h-4"></i>
                        <span id="liveClock">00:00:00</span>
                    </div>
                </div>
            </div>

            <div x-data="{ open:false }" class="relative shrink-0">
                <button @click="open = !open"
                        class="bg-[#9AD18B] hover:bg-[#89c97a] transition px-3 py-2 lg:px-5 lg:py-3 rounded-xl flex items-center gap-2 lg:gap-3 border border-green-600/10">
                    <div class="bg-white/30 p-1 rounded-full hidden sm:block">
                        <i data-lucide="user" class="w-5 h-5 lg:w-6 lg:h-6 text-black"></i>
                    </div>
                    <span class="text-[14px] lg:text-[16px] font-bold text-black">Admin</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                </button>

                <div x-show="open"
                     @click.away="open=false"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-2xl border border-gray-100 py-2 z-50 overflow-hidden">
                    
                    <div class="px-4 py-2 border-b border-gray-50 mb-1">
                        <p class="text-[10px] uppercase tracking-wider text-gray-400 font-bold">Administrator</p>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-4 py-3 text-left hover:bg-red-50 flex items-center gap-3 text-red-600 font-semibold transition-colors">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <div class="p-4 lg:p-8 flex-1">
            <div class="max-w-[1600px] mx-auto">
                @yield('content')
            </div>
        </div>

    </main>

</div>

<script>
    // Initialize Lucide Icons
    lucide.createIcons();

    // Responsive Live Clock
    function updateClock() {
        const now = new Date();
        const time = now.toLocaleTimeString('id-ID', { 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit',
            hour12: false 
        });
        const el = document.getElementById('liveClock');
        if(el) el.innerText = time;
    }

    setInterval(updateClock, 1000);
    updateClock();

    // Auto-close sidebar on window resize if needed
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) {
            // Sidebar is always visible on desktop via CSS, 
            // but we reset the Alpine state for consistency
            // sidebarOpen = false; 
        }
    });
</script>

</body>
</html>