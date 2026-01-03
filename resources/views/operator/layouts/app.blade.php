<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - SWB</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    @stack('styles')
</head>
<body class="min-h-screen font-sans" style="background: linear-gradient(to bottom right, #eff6ff, #eef2ff);">
    
    {{-- ================= HEADER UTAMA (Logo & Profil) ================= --}}
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-3 sm:py-4">
            <div class="flex items-center justify-between">
                {{-- Logo --}}
                <div class="flex items-center space-x-2 sm:space-x-3">
                    <a href="/" class="inline-flex items-center gap-2">
                        <img src="{{ asset('assets/images/logo.png') }}" 
                             alt="SWB" 
                             class="h-8 sm:h-10 w-auto"
                             onerror="this.style.display='none'"> 
                        <span class="text-xl font-bold text-blue-600 hidden sm:block">SmartWaste</span>
                    </a>
                </div>

                {{-- Actions Kanan --}}
                <div class="flex items-center space-x-2 sm:space-x-4">
                    {{-- Tombol Notifikasi --}}
                    <a href="{{ route('operator.notifikasi') }}" class="relative p-2 hover:bg-gray-100 rounded-full transition text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        @if(isset($notificationCount) && $notificationCount > 0)
                            <span class="absolute top-1 right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">
                                {{ $notificationCount }}
                            </span>
                        @endif
                    </a>

                    {{-- Profil / Logout --}}
                    <div class="flex items-center gap-2">
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="flex items-center space-x-2 bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2 rounded-lg transition font-semibold text-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span class="hidden sm:inline">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- ================= KONTEN & NAVIGASI ================= --}}
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        
        {{-- 1. Kartu Selamat Datang --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-6 border border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                        Selamat Datang, Operator! <span class="text-3xl">👋</span>
                    </h1>
                    <p class="text-gray-600 mt-1">
                        Semangat bekerja hari ini! Pantau kondisi vacuum bin secara real-time.
                    </p>
                </div>
                <div class="bg-blue-50 px-5 py-2 rounded-xl border border-blue-100 text-blue-700 font-medium text-sm whitespace-nowrap">
                    📅 {{ now()->format('l, d F Y') }}
                </div>
            </div>
        </div>

        {{-- 2. Tab Navigasi (Menu Tombol) --}}
        <div class="bg-white rounded-2xl shadow-sm p-2 mb-8 overflow-x-auto border border-gray-100">
            <div class="flex space-x-2 min-w-max">
                
                {{-- Tombol Dashboard --}}
                <a href="{{ route('operator.dashboard') }}" 
                   class="flex items-center gap-2 px-6 py-3 rounded-xl font-semibold transition
                   {{ request()->routeIs('operator.dashboard') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    Overview
                </a>

                {{-- Tombol Vacuum Bins --}}
                <a href="{{ route('operator.vacuumbin') }}" 
                   class="flex items-center gap-2 px-6 py-3 rounded-xl font-semibold transition
                   {{ request()->routeIs('operator.vacuumbin') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Vacuum Bins
                </a>

                {{-- Tombol Notifikasi --}}
                <a href="{{ route('operator.notifikasi') }}" 
                   class="flex items-center gap-2 px-6 py-3 rounded-xl font-semibold transition
                   {{ request()->routeIs('operator.notifikasi') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    Notifikasi
                </a>

                {{-- Tombol Task Update --}}
                <a href="{{ route('operator.taskupdate') }}" 
                   class="flex items-center gap-2 px-6 py-3 rounded-xl font-semibold transition
                   {{ request()->routeIs('operator.taskupdate') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Task Update
                </a>

            </div>
        </div>
        
        {{-- 3. Area Konten Dinamis --}}
        @yield('content')

    </div>

    {{-- Script Global --}}
    @stack('scripts')
    
    <script>
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });
    </script>
    
    @stack('inline-scripts')

</body>
</html>