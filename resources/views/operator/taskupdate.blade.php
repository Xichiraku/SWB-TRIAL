@extends('layouts.app')

@section('title', 'Task Update')

@section('content')
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
@endsection

@push('scripts')
    <script>
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
@endpush