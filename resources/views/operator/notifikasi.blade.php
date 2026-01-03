@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
    <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm p-4 sm:p-6 lg:p-8">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4 sm:mb-6">Notifikasi Dari Admin</h2>

        <div class="space-y-4">
            @forelse($peringatans as $peringatan)
                @php
                    $isNew = $peringatan->created_at->diffInHours(now()) < 24;
                    
                    // Icon & Color based on type/priority
                    if ($peringatan->priority === 'high') {
                        $bgColor = 'bg-red-50';
                        $borderColor = 'border-red-200';
                        $iconBg = 'bg-red-100';
                        $iconColor = 'text-red-600';
                        $icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>';
                    } elseif ($peringatan->priority === 'medium') {
                        $bgColor = 'bg-yellow-50';
                        $borderColor = 'border-yellow-200';
                        $iconBg = 'bg-yellow-100';
                        $iconColor = 'text-yellow-600';
                        $icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>';
                    } elseif ($peringatan->status === 'resolved') {
                        $bgColor = 'bg-green-50';
                        $borderColor = 'border-green-200';
                        $iconBg = 'bg-green-100';
                        $iconColor = 'text-green-600';
                        $icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>';
                    } else {
                        $bgColor = 'bg-blue-50';
                        $borderColor = 'border-blue-200';
                        $iconBg = 'bg-blue-100';
                        $iconColor = 'text-blue-600';
                        $icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>';
                    }
                @endphp

                <div class="relative {{ $bgColor }} border-2 {{ $borderColor }} rounded-xl p-4 sm:p-6 transition hover:shadow-md">
                    <div class="flex items-start space-x-4">
                        {{-- Icon --}}
                        <div class="{{ $iconBg }} p-3 rounded-full flex-shrink-0">
                            <svg class="w-6 h-6 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $icon !!}
                            </svg>
                        </div>

                        {{-- Content --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="text-lg font-bold text-gray-800">{{ $peringatan->title }}</h3>
                                @if($isNew && $peringatan->status === 'active')
                                <span class="bg-blue-500 text-white text-xs font-semibold px-3 py-1 rounded-full ml-2">Baru</span>
                                @endif
                            </div>
                            
                            <p class="text-sm text-gray-600 mb-2">
                                Dari {{ $peringatan->type === 'system' ? 'System' : 'Admin' }} 
                                {{ $peringatan->created_at->format('Y-m-d H:i') }}
                            </p>
                            
                            <p class="text-gray-700">{{ $peringatan->message }}</p>
                        </div>

                        {{-- Mark as Read Button --}}
                        @if($peringatan->status === 'active')
                        <button onclick="markAsRead('{{ $peringatan->id }}')" 
                                class="flex-shrink-0 p-2 hover:bg-white rounded-full transition"
                                title="Tandai sudah dibaca">
                            <svg class="w-6 h-6 text-gray-400 hover:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <p class="text-gray-500 text-lg">Tidak ada notifikasi</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function markAsRead(peringatanId) {
            if (confirm('Tandai notifikasi ini sudah dibaca?')) {
                $.ajax({
                    url: `/peringatan/${peringatanId}/resolve`,
                    type: 'PUT',
                    success: (response) => {
                        if (response.success) {
                            location.reload();
                        }
                    },
                    error: (xhr, status, error) => {
                        alert('Terjadi kesalahan: ' + error);
                    }
                });
            }
        }
    </script>
@endpush