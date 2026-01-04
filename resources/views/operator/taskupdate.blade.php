@extends('operator.layout')

@section('title', 'Task Update')

@section('content')
<div class="bg-white border border-blue-200 rounded-2xl p-6 shadow-sm">


    <div class="border-2 border-blue-300 rounded-2xl p-6 bg-white">

        <h2 class="text-xl font-bold text-gray-800 mb-6">
            Task Update Vacuum
        </h2>

        <div class="space-y-6">
            @forelse($tasks as $task)
                @php
                    $statusMap = [
                        'active' => ['text' => 'Pending', 'badge' => 'bg-yellow-300 text-black'],
                        'in_progress' => ['text' => 'Sedang Dikerjakan', 'badge' => 'bg-yellow-400 text-black'],
                        'resolved' => ['text' => 'Done', 'badge' => 'bg-green-400 text-black'],
                    ];
                    $status = $statusMap[$task->status] ?? $statusMap['active'];
                @endphp

                <div class="border-2 border-green-500 rounded-2xl p-6 bg-white">

                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">
                                {{ $task->homebase?->nama_lokasi ?? 'Lokasi tidak ditemukan' }}
                            </h3>
                            <p class="text-sm text-gray-700">
                                {{ $task->homebase?->kode_bin }} {{ ucfirst($task->type) }}
                            </p>
                        </div>

                        <span class="px-4 py-1 rounded-full text-sm font-semibold {{ $status['badge'] }}">
                            {{ $status['text'] }}
                        </span>
                    </div>

                    <div class="text-sm text-gray-800 space-y-1 mb-4">
                        <p>Diminta oleh: <span class="font-medium">Admin</span></p>
                        <p>Waktu: {{ $task->created_at->format('Y-m-d H:i') }}</p>
                        <p>Catatan: {{ $task->message }}</p>
                    </div>

                    @if($task->status !== 'resolved')
                        <button
                            onclick="startTask('{{ $task->_id }}', this)"
                            class="w-full bg-green-800 hover:bg-green-900 text-white font-semibold py-3 rounded-full transition">
                            Mulai Kerjakan
                        </button>
                    @else
                        <button disabled
                            class="w-full bg-blue-800 text-white font-semibold py-3 rounded-full cursor-default">
                            Selesai
                        </button>
                    @endif
                </div>
            @empty
                <p class="text-center text-gray-500 py-10">
                    Tidak ada task yang tersedia
                </p>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function startTask(taskId, button) {
    if (!confirm('Mulai mengerjakan task ini?')) return;

    fetch(`/operator/taskupdate/${taskId}/start`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);

        const card = button.closest('.border-green-500');
        const badge = card.querySelector('span.rounded-full');

        badge.textContent = 'Sedang Dikerjakan';
        badge.className = 'px-4 py-1 rounded-full text-sm font-semibold bg-yellow-400 text-black';

        button.textContent = 'Sedang Dikerjakan...';
        button.disabled = true;
        button.classList.add('bg-gray-400');

        setTimeout(() => completeTask(taskId), 60000);
    });
}

function completeTask(taskId) {
    fetch(`/operator/taskupdate/${taskId}/complete`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        location.reload();
    });
}
</script>
@endpush
