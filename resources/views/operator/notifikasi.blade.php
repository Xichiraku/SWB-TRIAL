<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Notifikasi - SWB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-50 min-h-screen">
    
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-3 sm:py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2 sm:space-x-3">
                    <a href="/" class="inline-flex items-center">
                        <img src="{{ asset('assets/images/logo.png') }}" 
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
                            @if($activePeringatans > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-semibold">{{ $activePeringatans }}</span>
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
                        Semangat bekerja hari ini! anda memiliki 
                        <span class="font-semibold text-blue-600">{{ $activePeringatans }} task</span> 
                        yang perlu diselesaikan
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
                <a href="{{ route('operator.vacuumbin') }}" class="flex items-center justify-center space-x-2 text-gray-600 hover:bg-gray-50 px-4 py-3 sm:px-6 sm:py-4 rounded-xl font-semibold transition whitespace-nowrap">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <span class="text-sm sm:text-base">Vacuum Bins</span>
                </a>
                <a href="{{ route('operator.notifikasi') }}" class="flex items-center justify-center space-x-2 bg-blue-100 text-blue-700 px-4 py-3 sm:px-6 sm:py-4 rounded-xl font-semibold transition whitespace-nowrap">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="text-sm sm:text-base">Notifikasi</span>
                </a>
                <a href="{{ route('operator.taskupdate') }}" 
                    class="flex items-center justify-center space-x-2 px-4 py-3 sm:px-6 sm:py-4 rounded-xl font-semibold transition whitespace-nowrap
                   {{ request()->routeIs('operator.taskupdate') 
                        ? 'bg-blue-100 text-blue-700' 
                        : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' 
                   }}">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="text-sm sm:text-base">Task Update</span>
                </a>
            </div>
        </div>

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

    </div>

    <script>
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });

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

</body>
</html>