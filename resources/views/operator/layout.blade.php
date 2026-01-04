<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Operator') - SWB</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-50">

<!-- HEADER -->
<header class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-8 py-2 flex justify-between items-center">
        
        <!-- Logo + Brand -->
        <div class="flex items-center gap-3">
            <img 
                src="{{ asset('assets/images/logo.png') }}" 
                alt="SWB Logo" 
                class="h-12 w-auto object-contain"
            >
            <span class="text-sm text-gray-600 font-medium leading-none">
                Smartwaste Bin
            </span>
        </div>

        <!-- Right Side -->
        <div class="flex items-center gap-5">

            <!-- Notification -->
            <a href="{{ route('operator.notifikasi') }}" class="relative group">
    <div class="p-2 rounded-md bg-blue-100 hover:bg-blue-200 transition">
        <svg class="w-5 h-5 text-blue-600"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11
                                 a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341
                                 C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5
                                 m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>

                @if(isset($pendingTasks) && $pendingTasks > 0)
                <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center
                             rounded-full bg-red-500 text-[9px] font-bold text-white
                             border-2 border-white">
                    {{ $pendingTasks }}
                </span>
                @endif
            </a>

            <!-- Divider -->
            <div class="h-7 w-px bg-gray-300"></div>

            <!-- Profile -->
            <div class="relative" x-data="{ open: false }" @click.away="open = false">
               <button @click="open = !open" class="flex items-center gap-2">
    
    <div class="w-9 h-9 rounded-full bg-blue-100
            flex items-center justify-center text-blue-600
            ring-1 ring-blue-200 shadow-sm">

        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-5 h-5"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M5.121 17.804A13.937 13.937 0 0112 15
                     c2.5 0 4.847.655 6.879 1.804
                     M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
    </div>

    <span class="hidden sm:block text-sm font-medium text-gray-700">
        {{ session('user')['username'] ?? 'Operator' }}
    </span>
</button>


                <!-- Dropdown -->
                <div x-show="open"
                     x-transition
                     class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl
                            border border-gray-100 overflow-hidden z-50"
                     style="display: none;">

                    <div class="px-4 py-3 bg-gray-50 border-b">
                        <p class="text-sm font-semibold text-gray-800 truncate">
                            {{ session('user')['username'] ?? 'Operator' }}
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ ucfirst(session('user')['role'] ?? 'operator') }}
                        </p>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="p-1">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-3 px-3 py-2
                                       text-sm font-medium text-red-600
                                       hover:bg-red-50 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1
                                         a3 3 0 01-3 3H6a3 3 0 01-3-3V7
                                         a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- MAIN CONTENT -->
<!-- MAIN -->
<main class="max-w-7xl mx-auto px-6 py-8 space-y-6">

    {{-- ================= WELCOME SECTION ================= --}}
    @isset($pendingTasks)
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-blue-200">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">
                    Selamat Pagi, Operator! 👋
                </h1>
                <p class="text-gray-600 mt-2">
                    Semangat bekerja hari ini! Anda memiliki
                    <span class="font-semibold text-gray-900">
                        {{ $pendingTasks }} task
                    </span>
                    yang perlu diselesaikan
                </p>
            </div>

            <div class="px-5 py-2 border-2 border-blue-500 text-blue-600 rounded-full font-medium">
                {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
            </div>
        </div>
    </div>
    @endisset

    {{-- ================= NAVIGATION TABS ================= --}}
    <div class="bg-white rounded-2xl shadow-sm px-6 py-3">
        @php
            $activeTab = 'bg-blue-100 text-blue-700 shadow-sm';
            $normalTab = 'text-gray-700 hover:bg-blue-100 hover:text-blue-700';
        @endphp

        <div class="grid grid-cols-4 gap-4">
            <a href="{{ route('operator.dashboard') }}"
               class="flex items-center justify-center gap-3 py-3 rounded-full font-medium transition
               {{ request()->routeIs('operator.dashboard') ? $activeTab : $normalTab }}">
                🏠 Overview
            </a>

            <a href="{{ route('operator.vacuumbin') }}"
               class="flex items-center justify-center gap-3 py-3 rounded-full font-medium transition
               {{ request()->routeIs('operator.vacuumbin') ? $activeTab : $normalTab }}">
                🗑️ Vacuum Bins
            </a>

            <a href="{{ route('operator.notifikasi') }}"
               class="flex items-center justify-center gap-3 py-3 rounded-full font-medium transition
               {{ request()->routeIs('operator.notifikasi') ? $activeTab : $normalTab }}">
                🔔 Notifikasi
            </a>

            <a href="{{ route('operator.taskupdate') }}"
               class="flex items-center justify-center gap-3 py-3 rounded-full font-medium transition
               {{ request()->routeIs('operator.taskupdate') ? $activeTab : $normalTab }}">
                ✅ Task Update
            </a>
        </div>
    </div>

    {{-- ================= PAGE CONTENT ================= --}}
       @yield('content')

</main>

{{-- TEMPAT MASUK SCRIPT DARI @push --}}
@stack('scripts')

</body>
</html>
