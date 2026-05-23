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
<body class="bg-[#f5f5f5] antialiased">

<header class="bg-white border-b border-green-100 shadow-sm sticky top-0 z-[100]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="h-10 lg:h-12 w-auto">
            <span class="text-[#1F4D1F] font-bold italic hidden sm:block uppercase">Smartwaste Bin</span>
        </div>

        <div class="flex items-center gap-6">
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center gap-3 focus:outline-none">
                    <div class="w-10 h-10 rounded-xl bg-[#1F4D1F] flex items-center justify-center text-white">
                        <i data-lucide="user" class="w-5 h-5"></i>
                    </div>
                    <div class="hidden sm:block text-left">
                        <p class="text-xs font-bold text-[#1F4D1F]">{{ session('user')['username'] ?? 'Operator' }}</p>
                        <p class="text-[10px] text-slate-400 font-medium uppercase">Operator Lapangan</p>
                    </div>
                </button>
                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-3 w-48 bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden" style="display: none;">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="w-full flex items-center gap-3 px-4 py-3 text-sm font-bold text-red-500 hover:bg-red-50">
                            <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col items-center">
    
    <div class="bg-white rounded-2xl p-2 shadow-sm border border-slate-100 flex justify-center items-center gap-2 mb-8 w-full max-w-4xl overflow-x-auto">
        <a href="{{ route('operator.dashboard') }}" class="flex items-center gap-3 px-6 py-3 {{ request()->routeIs('operator.dashboard') ? 'bg-[#1F4D1F] text-white shadow-md' : 'text-slate-500 hover:bg-green-50' }} rounded-xl font-bold transition-all whitespace-nowrap">
            <i data-lucide="home" class="w-5 h-5"></i>
            <span>Overview</span>
        </a>
        <a href="{{ route('operator.vacuumbin') }}" class="flex items-center gap-3 px-6 py-3 {{ request()->routeIs('operator.vacuumbin') ? 'bg-[#1F4D1F] text-white shadow-md' : 'text-slate-500 hover:bg-green-50' }} rounded-xl font-bold transition-all whitespace-nowrap">
            <i data-lucide="trash-2" class="w-5 h-5"></i>
            <span>Vacuum Bins</span>
        </a>
        <a href="{{ route('operator.notifikasi') }}" class="flex items-center gap-3 px-6 py-3 {{ request()->routeIs('operator.notifikasi') ? 'bg-[#1F4D1F] text-white shadow-md' : 'text-slate-500 hover:bg-green-50' }} rounded-xl font-bold transition-all whitespace-nowrap">
            <i data-lucide="bell" class="w-5 h-5"></i>
            <span>Notifikasi</span>
        </a>
        <a href="{{ route('operator.taskupdate') }}" class="flex items-center gap-3 px-6 py-3 {{ request()->routeIs('operator.taskupdate') ? 'bg-[#1F4D1F] text-white shadow-md' : 'text-slate-500 hover:bg-green-50' }} rounded-xl font-bold transition-all whitespace-nowrap">
            <i data-lucide="check-square" class="w-5 h-5"></i>
            <span>Task Update</span>
        </a>
    </div>

    <div class="w-full flex flex-col items-center">
        @yield('content')
    </div>
</main>

<script>lucide.createIcons();</script>
</body>
</html>