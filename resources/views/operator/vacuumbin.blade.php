@extends('layouts.app')

@section('title', 'Vacuum Bins')

@section('content')

    {{-- Stats Cards --}}
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

    {{-- Vacuum Bins List --}}
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
@endsection

@push('scripts')
    <script>
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

        // Auto refresh setiap 30 detik
        setInterval(() => location.reload(), 30000);
    </script>
@endpush