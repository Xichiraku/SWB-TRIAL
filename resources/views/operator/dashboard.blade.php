@extends('layouts.app')

@section('title', 'Dashboard Operator')

@section('content')
    {{-- Status Homebase Section --}}
    <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm p-4 sm:p-6 lg:p-8 mb-4 sm:mb-6 lg:mb-8">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4 sm:mb-6 flex items-center">
            <svg class="w-5 h-5 sm:w-6 sm:h-6 lg:w-7 lg:h-7 mr-2 sm:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span class="text-lg sm:text-xl lg:text-2xl">Status Homebase</span>
        </h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
            @foreach($homebases as $homebase)
            <div class="border-2 border-gray-200 rounded-xl p-4 sm:p-6 hover:border-blue-300 transition">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 sm:mb-6 space-y-3 sm:space-y-0">
                    <div class="flex-1">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800">{{ $homebase->name }}</h3>
                        <p class="text-xs sm:text-sm text-gray-500 flex items-center mt-1">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $homebase->location }}
                        </p>
                    </div>
                    <div class="flex items-center {{ $homebase->status === 'online' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} px-3 py-1.5 sm:px-4 sm:py-2 rounded-lg font-semibold text-sm sm:text-base self-start sm:self-auto">
                        <span class="w-2 h-2 {{ $homebase->status === 'online' ? 'bg-green-500' : 'bg-red-500' }} rounded-full mr-2"></span>
                        {{ ucfirst($homebase->status) }}
                    </div>
                </div>
                
                <div class="border-t-2 border-gray-100 pt-4">
                    <div class="grid grid-cols-2 gap-3 sm:gap-4">
                        <div>
                            <p class="text-xs sm:text-sm text-gray-500 mb-1">Vacuum Assigned</p>
                            <p class="text-2xl sm:text-3xl font-bold text-gray-800">{{ $homebase->vacuum_assigned }}</p>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm text-gray-500 mb-1">Active</p>
                            <p class="text-2xl sm:text-3xl font-bold text-green-600">{{ $homebase->active_vacuums }}</p>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm text-gray-500 mb-1">Temperature</p>
                            <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ $homebase->temperature }}°C</p>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm text-gray-500 mb-1">Power</p>
                            <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ $homebase->power_status }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Peringatan Penting Section --}}
    @if(isset($peringatans) && $peringatans->count() > 0)
    <div class="bg-red-50 border-2 border-red-200 rounded-xl sm:rounded-2xl p-4 sm:p-6 lg:p-8">
        <div class="flex items-center mb-4 sm:mb-6">
            <div class="bg-red-100 p-2 sm:p-3 rounded-full mr-3 sm:mr-4">
                <svg class="w-6 h-6 sm:w-8 sm:h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h2 class="text-xl sm:text-2xl font-bold text-red-700">Peringatan Penting</h2>
        </div>

        <div class="space-y-3 sm:space-y-4">
            @foreach($peringatans as $peringatan)
            <div class="bg-white rounded-xl p-4 sm:p-6 border-l-4 {{ $peringatan->border_color ?? 'border-red-500' }}">
                <div class="flex flex-col sm:flex-row sm:items-start space-y-3 sm:space-y-0">
                    <div class="bg-red-100 p-2 rounded-lg mr-0 sm:mr-4 self-start">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-base sm:text-lg font-bold text-gray-800 mb-2">{{ $peringatan->title }}</h3>
                        <p class="text-sm sm:text-base text-gray-600">{{ $peringatan->message }}</p>
                    </div>
                    <button onclick="resolvePeringatan('{{ $peringatan->id }}')" 
                            class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-4 px-4 py-2 bg-green-500 text-white text-sm sm:text-base rounded-lg hover:bg-green-600 transition font-semibold whitespace-nowrap">
                        Selesai
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
@endsection

@push('inline-scripts')
    // Auto reload setiap 30 detik
    setInterval(() => location.reload(), 30000);

    // Function untuk resolve peringatan
    function resolvePeringatan(peringatanId) {
        if (confirm('Apakah Anda yakin masalah ini sudah diselesaikan?')) {
            $.ajax({
                url: `/peringatan/${peringatanId}/resolve`,
                type: 'PUT',
                success: (response) => {
                    if (response.success) {
                        alert('Peringatan berhasil diselesaikan!');
                        location.reload();
                    }
                },
                error: (xhr, status, error) => {
                    alert('Terjadi kesalahan: ' + error);
                }
            });
        }
    }
@endpush