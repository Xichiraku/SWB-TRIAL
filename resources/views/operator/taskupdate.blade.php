@extends('operator.layout')
@section('title', 'Task Update')

@section('content')
<div class="w-full max-w-7xl space-y-6">
    <div class="bg-white rounded-[25px] p-8 border border-blue-100 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4 w-full">
        <div class="flex items-center gap-5 text-center md:text-left">
            <div class="text-5xl">📋</div>
            <div>
                <h1 class="text-2xl lg:text-3xl font-black text-blue-900">Daftar Tugas</h1>
                <p class="text-slate-500 font-medium">Selesaikan tugas pengosongan vacuum bin tepat waktu.</p>
            </div>
        </div>
        <div class="px-6 py-2 border-2 border-blue-900 rounded-full font-bold text-blue-900 bg-white">
            {{ count($tasks) }} Tugas Tersedia
        </div>
    </div>

    <div class="bg-white rounded-[30px] p-6 lg:p-10 shadow-sm border border-blue-100 w-full">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-6xl mx-auto">
            @forelse($tasks as $task)
                @php
                    $statusMap = [
                        'active' => ['text' => 'Pending', 'badge' => 'bg-yellow-400 text-black'],
                        'in_progress' => ['text' => 'Dikerjakan', 'badge' => 'bg-blue-500 text-white'],
                        'resolved' => ['text' => 'Selesai', 'badge' => 'bg-green-500 text-white'],
                    ];
                    $st = $statusMap[$task->status] ?? $statusMap['active'];
                @endphp

                <div class="border-2 border-slate-100 rounded-[25px] p-6 bg-white hover:border-blue-300 transition-all shadow-sm relative">
                    <div class="flex justify-between items-start mb-4">
                        <span class="px-4 py-1 rounded-full text-[10px] font-black uppercase {{ $st['badge'] }}">
                            {{ $st['text'] }}
                        </span>
                    </div>

                    <div class="flex items-center gap-4 mb-4">
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                            <i data-lucide="map-pin" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-800">{{ $task->homebase?->nama_lokasi ?? 'Lokasi' }}</h3>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-tighter">Unit: {{ $task->vacuum_code ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-dashed border-slate-100 flex gap-2">
                        @if($task->status === 'active')
                            <button onclick="startTask('{{ $task->id }}', this)" class="w-full bg-blue-600 text-white font-black py-3 rounded-xl hover:bg-blue-700 transition-all">
                                Kerjakan Sekarang
                            </button>
                        @elseif($task->status === 'in_progress')
                            <button disabled class="w-full bg-slate-100 text-slate-400 font-black py-3 rounded-xl cursor-not-allowed">
                                Sedang Dikerjakan...
                            </button>
                        @else
                            <button disabled class="w-full bg-green-50 text-green-600 font-black py-3 rounded-xl cursor-default">
                                Selesai ✓
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 bg-slate-50 rounded-[30px] border-2 border-dashed border-slate-200">
                    <i data-lucide="clipboard-check" class="w-12 h-12 text-slate-300 mx-auto mb-4"></i>
                    <p class="text-slate-500 font-bold">Semua tugas sudah selesai!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
function startTask(taskId, button) {
    if (!confirm('Mulai mengerjakan tugas ini?')) return;
    
    // Logic fetch AJAX kamu tetap sama
    fetch(`/operator/taskupdate/${taskId}/start`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        window.location.reload();
    });
}
</script>
@endsection