<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Operator') - SWB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-[#f0f4f0] antialiased">

<div x-data="{ sidebarOpen: false }" class="flex min-h-screen">

    {{-- ===== OVERLAY (mobile) ===== --}}
    <div
        x-show="sidebarOpen"
        @click="sidebarOpen = false"
        x-transition.opacity
        class="fixed inset-0 bg-black/40 z-20 lg:hidden"
        style="display:none;"
    ></div>

    {{-- ===== SIDEBAR ===== --}}
    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed top-0 left-0 h-screen w-64 bg-[#1F4D1F] z-30 flex flex-col transition-transform duration-300 ease-in-out overflow-y-auto
               lg:translate-x-0 lg:fixed lg:top-0 lg:left-0 lg:h-screen lg:w-64"
    >
        {{-- Logo --}}
        <div class="flex items-center gap-3 px-6 py-5 border-b border-white/10">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="h-10 w-auto brightness-0 invert">
            <span class="text-white font-bold italic uppercase text-sm leading-tight">Smart Waste Bin</span>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-6 space-y-1">

            <p class="text-white/40 text-[10px] font-bold uppercase px-3 mb-3 tracking-widest">Menu</p>

            <a href="{{ route('operator.dashboard') }}"
               class="flex items-center gap-3 px-3 py-3 rounded-xl font-semibold text-sm transition-all
                      {{ request()->routeIs('operator.dashboard') ? 'bg-white text-[#1F4D1F]' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="home" class="w-5 h-5 shrink-0"></i>
                <span>Dashboard</span>
            </a>


            <a href="{{ route('operator.notifikasi') }}"
               class="flex items-center gap-3 px-3 py-3 rounded-xl font-semibold text-sm transition-all
                      {{ request()->routeIs('operator.notifikasi') ? 'bg-white text-[#1F4D1F]' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="bell" class="w-5 h-5 shrink-0"></i>
                <span>Notifikasi</span>
            </a>

            <a href="{{ route('operator.taskupdate') }}"
               class="flex items-center gap-3 px-3 py-3 rounded-xl font-semibold text-sm transition-all
                      {{ request()->routeIs('operator.taskupdate') ? 'bg-white text-[#1F4D1F]' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="check-square" class="w-5 h-5 shrink-0"></i>
                <span>Task Update</span>
            </a>

        </nav>

        {{-- User + Logout --}}
        <div class="px-4 py-4 border-t border-white/10">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
                    <i data-lucide="user" class="w-4 h-4 text-white"></i>
                </div>
                <div class="overflow-hidden">
                    <p class="text-white text-xs font-bold truncate">{{ session('user')['username'] ?? 'Operator' }}</p>
                    <p class="text-white/40 text-[10px] font-medium uppercase">Operator Lapangan</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-xl bg-white/10 hover:bg-red-500/80 text-white text-xs font-bold transition-all">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- ===== MAIN AREA ===== --}}
    <div class="flex-1 flex flex-col min-w-0 lg:ml-64">

        {{-- Topbar (mobile hamburger + page title) --}}
        <header class="bg-white border-b border-green-100 shadow-sm sticky top-0 z-10 flex items-center gap-4 px-4 sm:px-6 py-3 lg:hidden">
            <button @click="sidebarOpen = true" class="text-[#1F4D1F]">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
            <div class="flex items-center gap-2">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="h-8 w-auto">
                <span class="text-[#1F4D1F] font-bold italic text-sm uppercase">Smartwaste Bin</span>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 p-6 lg:p-8">
            @yield('content')
        </main>

    </div>
</div>

<script>lucide.createIcons();</script>
</body>
</html>