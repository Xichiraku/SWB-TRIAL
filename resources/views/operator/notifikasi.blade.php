@extends('operator.layout')

@section('title', 'Notifikasi')

@section('content')
   
    <!-- Notifikasi Section -->
    <div class="bg-white rounded-xl shadow-md p-5 sm:p-6 lg:p-8">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-6">Notifikasi Dari Admin</h2>

        <div class="space-y-4">
            @forelse($notifikasis as $notif)
            <div class="bg-white border border-gray-200 rounded-xl p-4 sm:p-5 relative hover:shadow-lg hover:bg-gray-50 transition-shadow transition-colors duration-200 cursor-pointer">
                <div class="flex items-start justify-between">
                    <div class="flex items-start gap-4">
                        <!-- Icon berdasarkan type -->
                        <div class="
                            @if($notif->type === 'critical') bg-red-100
                            @elseif($notif->type === 'warning') bg-yellow-100
                            @elseif($notif->type === 'info') bg-blue-100
                            @else bg-green-100
                            @endif
                            p-3 rounded-full">
                            <i class="fas 
                                @if($notif->type === 'critical') fa-exclamation-triangle text-red-600
                                @elseif($notif->type === 'warning') fa-exclamation-circle text-yellow-600
                                @elseif($notif->type === 'info') fa-info-circle text-blue-600
                                @else fa-check-circle text-green-600
                                @endif
                                text-xl"></i>
                        </div>
                        
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <h3 class="text-lg font-bold text-gray-800">{{ $notif->title }}</h3>
                                
                                @if($notif->is_new)
                                <span class="bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">Baru</span>
                                @endif
                            </div>
                            
                            <p class="text-sm text-gray-600 mb-2">
                                Dari {{ $notif->source }} <span class="font-medium">{{ $notif->datetime }}</span>
                            </p>
                            
                            <p class="text-gray-700">
                                {{ $notif->message }}
                            </p>
                        </div>
                    </div>
                    
                    @if($notif->has_check)
                    <button class="text-gray-400 hover:text-green-600 transition">
                        <i class="fas fa-check-circle text-2xl"></i>
                    </button>
                    @endif
                </div>
            </div>
            @empty
            <!-- Kalau gak ada notifikasi -->
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-8 text-center">
                <div class="bg-gray-200 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-bell-slash text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Tidak Ada Notifikasi</h3>
                <p class="text-gray-500">Belum ada notifikasi baru dari admin atau sistem.</p>
            </div>
            @endforelse
        </div>
    </div>
@endsection