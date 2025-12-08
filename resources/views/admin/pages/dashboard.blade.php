@extends('admin.layouts.app')

@section('title', 'Dashboard - Smart Waste Monitor')

{{-- TITLE UNTUK HEADER KANAN --}}
@section('page_title')
<div class="flex flex-col">
    <h1 class="text-3xl font-bold text-gray-800 leading-tight">
       Dashboard Monitoring
    </h1>
    <p class="text-gray-600 mt-1 text-base leading-snug">
   Last updated:10:42:17
    </p>
    </div>
@endsection

@section('content')
<div x-data="dashboardMonitor()" 
     class="min-h-screen px-4 sm:px-6 lg:px-8 py-6">

<!-- STATS CARDS -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

    <!-- Total Bins -->
    <div class="bg-white rounded-xl shadow-sm p-6 border hover:bg-blue-50 hover:border-blue-300 transition">
        <div class="flex items-center space-x-3 mb-3">
            <div class="bg-gray-100 p-2 rounded-lg">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Total Bins</p>
                <p class="text-3xl font-bold">5</p>
            </div>
        </div>
    </div>

    <!-- Full -->
    <div class="bg-white rounded-xl shadow-sm p-6 border hover:bg-blue-50 hover:border-blue-300 transition">
        <div class="flex items-center space-x-3 mb-3">
            <div class="bg-red-100 p-2 rounded-lg">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Full</p>
                <p class="text-3xl font-bold text-red-600">2</p>
            </div>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-red-600 h-2 rounded-full" style="width:40%"></div>
        </div>
    </div>

    <!-- Normal -->
    <div class="bg-white rounded-xl shadow-sm p-6 border hover:bg-blue-50 hover:border-blue-300 transition">
        <div class="flex items-center space-x-3 mb-3">
            <div class="bg-green-100 p-2 rounded-lg">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 0 018 18z"/>
                </svg>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Normal</p>
                <p class="text-3xl font-bold text-green-600">2</p>
            </div>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-green-600 h-2 rounded-full" style="width:80%"></div>
        </div>
    </div>

    <!-- Maintenance -->
    <div class="bg-white rounded-xl shadow-sm p-6 border hover:bg-blue-50 hover:border-blue-300 transition">
        <div class="flex items-center space-x-3 mb-3">
            <div class="bg-orange-100 p-2 rounded-lg">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Maintenance</p>
                <p class="text-3xl font-bold text-orange-600">1</p>
            </div>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-orange-600 h-2 rounded-full" style="width:20%"></div>
        </div>
    </div>

</div>

<!-- BIN LIST -->
<div class="bg-white rounded-xl shadow-sm border p-6">
    <h2 class="text-xl font-bold text-gray-900 mb-6">Smart Vacuum Trash Bins</h2>

    <div class="space-y-4">

        <!-- BIN 001 -->
        <a href="{{ route('bin.detail', '001') }}" class="block">
            <div class="bg-white border-2 border-gray-300 rounded-xl p-5 hover:bg-blue-50 hover:border-blue-300 transition cursor-pointer">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gray-100 p-3 rounded-lg">
                            <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold">Bin #001</h3>
                            <div class="flex items-center space-x-1 text-gray-600 text-sm mt-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>Main Street Park</span>
                            </div>
                        </div>
                        <div class="bg-red-100 text-red-700 px-4 py-1 rounded-full text-sm font-medium flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span>Full</span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-8">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Capacity</p>
                            <div class="flex items-center space-x-3">
                                <div class="w-48 bg-gray-300 h-3 rounded-full">
                                    <div class="bg-blue-600 h-3 rounded-full" style="width:85%"></div>
                                </div>
                                <span class="text-sm font-bold text-gray-700">85%</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                            <span class="text-lg font-bold text-blue-600">78%</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <!-- BIN 002 -->
        <a href="{{ route('bin.detail', '002') }}" class="block">
            <div class="bg-white border-2 border-gray-300 rounded-xl p-5 hover:bg-blue-50 hover:border-blue-300 transition cursor-pointer">

                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gray-100 p-3 rounded-lg">
                            <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold">Bin #002</h3>
                            <div class="flex items-center space-x-1 text-gray-600 text-sm mt-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 11a3 3 0 11-6 0 3 3"
                                    />
                                </svg>
                                <span>Central Market</span>
                            </div>
                        </div>

                        <div class="bg-green-100 text-green-700 px-4 py-1 rounded-full text-sm font-medium flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 0 018 18z"/>
                            </svg>
                            <span>Normal</span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-8">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Capacity</p>
                            <div class="flex items-center space-x-3">
                                <div class="w-48 bg-gray-300 h-3 rounded-full">
                                    <div class="bg-blue-600 h-3 rounded-full" style="width:65%"></div>
                                </div>
                                <span class="text-sm font-bold text-gray-700">65%</span>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                            <span class="text-lg font-bold text-blue-600">62%</span>
                        </div>
                    </div>

                </div>
            </div>
        </a>

    </div>
</div>

@endsection
