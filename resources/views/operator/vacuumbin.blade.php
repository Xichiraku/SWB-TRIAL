<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vacuum Bins - SWB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-50 min-h-screen">
    
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-3 sm:py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2 sm:space-x-3">
                    <a href="/" class="inline-flex items-center">
                        <img src="{{ asset('assets/images/logo_swb.png') }}" 
                            alt="eSWB Logo" 
                            class="max-h-10 sm:max-h-12 w-auto">
                    </a>
                </div>
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <div class="relative">
                        <button class="relative p-2 hover:bg-gray-100 rounded-full transition">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            @if($fullCapacity + $lowBattery > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-semibold">{{ $fullCapacity + $lowBattery }}</span>
                            @endif
                        </button>
                    </div>
                    <button class="p-2 hover:bg-gray-100 rounded-full transition">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
        
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm p-4 sm:p-6 lg:p-8 mb-4 sm:mb-6 lg:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                <div>
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 mb-1 sm:mb-2 flex items-center">
                        Selamat {{ $greeting }}, Operator! 
                        <span class="ml-2 sm:ml-3 text-2xl sm:text-3xl lg:text-4xl">👋</span>
                    </h1>
                    <p class="text-sm sm:text-base lg:text-lg text-gray-600">
                        Kelola dan monitor semua vacuum bins di sini
                    </p>
                </div>
                <div class="bg-blue-50 px-4 py-2 sm:px-6 sm:py-3 rounded-lg sm:rounded-xl border-2 border-blue-200 self-start sm:self-auto">
                    <p class="text-xs sm:text-sm text-gray-600 font-medium whitespace-nowrap">{{ $currentDate }}</p>
                </div>
            </div>
        </div>

                <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm p-2 mb-4 sm:mb-6 lg:mb-8 overflow-x-auto">
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2 min-w-max lg:min-w-0">
                        <a href="{{ route('operator.dashboard') }}" class="flex items-center justify-center space-x-2 text-gray-600 hover:bg-gray-50 px-4 py-3 sm:px-6 sm:py-4 rounded-xl font-semibold transition whitespace-nowrap">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span class="text-sm sm:text-base">Overview</span>
                        </a>
                        <a href="{{ route('operator.vacuumbin') }}" class="flex items-center justify-center space-x-2 bg-blue-100 text-blue-700 px-4 py-3 sm:px-6 sm:py-4 rounded-xl font-semibold transition whitespace-nowrap">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            <span class="text-sm sm:text-base">Vacuum Bins</span>
                        </a>
                        <button class="flex items-center justify-center space-x-2 text-gray-600 px-4 py-3 sm:px-6 sm:py-4 rounded-xl font-semibold hover:bg-gray-50 transition whitespace-nowrap">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span class="text-sm sm:text-base">Notifikasi</span>
                        </button>
                        <button class="flex items-center justify-center space-x-2 text-gray-600 px-4 py-3 sm:px-6 sm:py-4 rounded-xl font-semibold hover:bg-gray-50 transition whitespace-nowrap">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm sm:text-base">Task Update</span>
                        </button>
                    </div>
                </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl p-4 sm:p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-500 mb-1">Total Vacuum</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-800">{{ $totalVacuums }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-4 sm:p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-500 mb-1">Aktif</p>
                        <p class="text-2xl sm:text-3xl font-bold text-green-600">{{ $activeVacuums }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-4 sm:p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-500 mb-1">Kapasitas Penuh</p>
                        <p class="text-2xl sm:text-3xl font-bold text-red-600">{{ $fullCapacity }}</p>
                    </div>
                    <div class="bg-red-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-4 sm:p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-500 mb-1">Baterai Rendah</p>
                        <p class="text-2xl sm:text-3xl font-bold text-yellow-600">{{ $lowBattery }}</p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm p-4 sm:p-6 lg:p-8">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4 sm:mb-6 flex items-center">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 lg:w-7 lg:h-7 mr-2 sm:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                <span class="text-lg sm:text-xl lg:text-2xl">Daftar Vacuum Bins</span>
            </h2>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                @foreach($vacuums as $vacuum)
                <div class="border-2 {{ $vacuum->capacity >= 90 ? 'border-red-300' : 'border-gray-200' }} rounded-xl p-4 sm:p-6 hover:border-blue-300 transition">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="bg-blue-100 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">{{ $vacuum->homebase->name ?? 'Unknown' }}</h3>
                                <p class="text-sm text-gray-500 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $vacuum->homebase->location ?? 'Unknown' }}
                                </p>
                            </div>
                        </div>
                        <div class="px-3 py-1 rounded-lg text-sm font-semibold {{ $vacuum->capacity >= 90 ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700' }}">
                            {{ $vacuum->capacity >= 90 ? 'Full' : 'Normal' }}
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm text-gray-600">Kapasitas Sampah</p>
                                <p class="text-sm font-bold {{ $vacuum->capacity >= 90 ? 'text-red-600' : 'text-gray-800' }}">{{ $vacuum->capacity }}%</p>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                @php
                                    $capacityWidth = $vacuum->capacity;
                                    if ($vacuum->capacity >= 90) {
                                        $capacityColor = 'bg-red-500';
                                    } elseif ($vacuum->capacity >= 70) {
                                        $capacityColor = 'bg-yellow-500';
                                    } else {
                                        $capacityColor = 'bg-blue-500';
                                    }
                                @endphp
                                <div class="h-3 rounded-full transition-all {{ $capacityColor }}" style="width: {{ $capacityWidth }}%"></div>
                            </div>
                            @if($vacuum->capacity >= 90)
                            <p class="text-xs text-red-600 mt-1 font-semibold">Segera Kosongkan!</p>
                            @endif
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm text-gray-600">Baterai Solar</p>
                                <p class="text-sm font-bold {{ $vacuum->battery_level <= 30 ? 'text-red-600' : 'text-gray-800' }}">{{ $vacuum->battery_level }}%</p>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                @php
                                    $batteryWidth = $vacuum->battery_level;
                                    if ($vacuum->battery_level <= 20) {
                                        $batteryColor = 'bg-red-500';
                                    } elseif ($vacuum->battery_level <= 40) {
                                        $batteryColor = 'bg-yellow-500';
                                    } else {
                                        $batteryColor = 'bg-green-500';
                                    }
                                @endphp
                                <div class="h-3 rounded-full transition-all {{ $batteryColor }}" style="width: {{ $batteryWidth }}%"></div>
                            </div>
                            @if($vacuum->battery_level <= 30)
                            <p class="text-xs text-blue-600 mt-1">Baterai rendah - periksa panel solar</p>
                            @endif
                        </div>

                        <div class="border-t pt-4 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">ID Vacuum:</span>
                                <span class="font-semibold">{{ $vacuum->code }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Update Terakhir:</span>
                                <span class="font-semibold">{{ $vacuum->updated_at->format('Y-m-d H:i') }}</span>
                            </div>
                            <div class="flex justify-between text-sm items-center">
                                <span class="text-gray-600">Koneksi:</span>
                                <span class="flex items-center text-green-600 font-semibold">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                    </svg>
                                    Online
                                </span>
                            </div>
                        </div>

                        @if($vacuum->capacity >= 90)
                        <button onclick="emptyVacuum('{{ $vacuum->id }}')" class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 rounded-lg transition">
                            Kosongkan Vacuum
                        </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    <script>
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });

        function emptyVacuum(vacuumId) {
            if (confirm('Apakah vacuum sudah dikosongkan?')) {
                $.ajax({
                    url: `/vacuum/${vacuumId}/empty`,
                    type: 'PUT',
                    success: (response) => {
                        if (response.success) {
                            alert('Vacuum berhasil dikosongkan!');
                            location.reload();
                        }
                    },
                    error: (xhr, status, error) => {
                        alert('Terjadi kesalahan: ' + error);
                    }
                });
            }
        }

        setInterval(() => location.reload(), 30000);
    </script>

</body>
</html>