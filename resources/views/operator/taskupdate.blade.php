<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Task Update - SWB</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-50 min-h-screen">
    
    <!-- Header -->
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
                <button class="relative p-2 hover:bg-gray-100 rounded-full transition inline-block">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @if($pendingTasks > 0)
                    <span class="absolute top-1 right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-semibold">{{ $pendingTasks }}</span>
                    @endif
                </button>
            </div>
            
            <button class="p-2 hover:bg-gray-100 rounded-full transition">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </button>

            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="flex items-center space-x-2 bg-red-500 hover:bg-red-600 text-white px-3 sm:px-4 py-2 rounded-lg transition font-semibold text-sm sm:text-base">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span class="hidden sm:inline">Logout</span>
                </button>
            </form>
        </div>
    </header>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
        
        <!-- Welcome Card -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm p-4 sm:p-6 lg:p-8 mb-4 sm:mb-6 lg:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                <div>
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 mb-1 sm:mb-2 flex items-center">
                        Selamat {{ $greeting }}, Operator! 
                        <span class="ml-2 sm:ml-3 text-2xl sm:text-3xl lg:text-4xl">👋</span>
                    </h1>
                    <p class="text-sm sm:text-base lg:text-lg text-gray-600">
                        Semangat bekerja hari ini! anda memiliki 
                        <span class="font-semibold text-blue-600">{{ $pendingTasks }} task</span> 
                        yang perlu diselesaikan
                    </p>
                </div>
                <div class="bg-blue-50 px-4 py-2 sm:px-6 sm:py-3 rounded-lg sm:rounded-xl border-2 border-blue-200 self-start sm:self-auto">
                    <p class="text-xs sm:text-sm text-gray-600 font-medium whitespace-nowrap">{{ $currentDate }}</p>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
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
                <a href="{{ route('operator.notifikasi') }}" class="flex items-center justify-center space-x-2 text-gray-600 hover:bg-gray-50 px-4 py-3 sm:px-6 sm:py-4 rounded-xl font-semibold transition whitespace-nowrap">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="text-sm sm:text-base">Notifikasi</span>
                </a>
                <a href="{{ route('operator.taskupdate') }}" class="flex items-center justify-center space-x-2 bg-blue-100 text-blue-700 px-4 py-3 sm:px-6 sm:py-4 rounded-xl font-semibold transition whitespace-nowrap">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm sm:text-base">Task Update</span>
                </a>
            </div>
        </div>

        <!-- Task Update Content -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm p-4 sm:p-6 lg:p-8">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4 sm:mb-6">Task Update Vacuum</h2>

            <div class="space-y-4">
                @forelse($tasks as $task)
                    @php
                        $statusClass = match($task->status) {
                            'resolved' => 'bg-green-100 text-green-800',
                            'in_progress' => 'bg-yellow-100 text-yellow-800',
                            default => 'bg-gray-100 text-gray-800'
                        };
                        
                        $statusText = match($task->status) {
                            'resolved' => 'Done',
                            'in_progress' => 'In Progress',
                            default => 'Pending'
                        };
                    @endphp

                    <div class="border-2 border-gray-200 rounded-xl p-4 sm:p-6 hover:shadow-md transition">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-800 mb-1">
                                    {{ $task->homebase ? $task->homebase->nama_lokasi : 'Lokasi tidak ditemukan' }}
                                </h3>
                                <p class="text-sm text-gray-600">
                                    {{ $task->homebase ? $task->homebase->kode_bin : '' }} 
                                    {{ ucfirst($task->type) }}
                                </p>
                            </div>
                            <span class="px-4 py-1 rounded-full text-sm font-semibold {{ $statusClass }} mt-2 sm:mt-0 self-start">
                                {{ $statusText }}
                            </span>
                        </div>

                        <div class="space-y-2 text-sm text-gray-700 mb-4">
                            <p><span class="font-semibold">Diminta oleh:</span> Admin</p>
                            <p><span class="font-semibold">Waktu:</span> {{ $task->created_at->format('Y-m-d H:i') }}</p>
                            <p><span class="font-semibold">Catatan:</span> {{ $task->message }}</p>
                        </div>

                        @if($task->status === 'active')
                        <button onclick="startTask('{{ $task->_id }}')" 
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg transition">
                            Mulai Kerjakan
                        </button>
                        @elseif($task->status === 'in_progress')
                        <button onclick="completeTask('{{ $task->_id }}')" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition">
                            Tandai Selesai
                        </button>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-gray-500 text-lg">Tidak ada task yang tersedia</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    <script>
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });

        function startTask(taskId) {
            if (confirm('Mulai mengerjakan task ini?')) {
                $.ajax({
                    url: `/operator/taskupdate/${taskId}/start`,
                    type: 'POST',
                    success: (response) => {
                        if (response.success) {
                            alert(response.message);
                            location.reload();
                        }
                    },
                    error: (xhr, status, error) => {
                        alert('Terjadi kesalahan: ' + error);
                    }
                });
            }
        }

        function completeTask(taskId) {
            if (confirm('Tandai task ini sebagai selesai?')) {
                $.ajax({
                    url: `/operator/taskupdate/${taskId}/complete`,
                    type: 'POST',
                    success: (response) => {
                        if (response.success) {
                            alert(response.message);
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