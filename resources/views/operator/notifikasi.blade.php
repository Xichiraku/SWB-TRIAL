@extends('operator.layout')
@section('title', 'Notifikasi')

@section('content')
<div class="w-full max-w-7xl space-y-6">
    <div class="bg-white rounded-[25px] p-8 border border-green-100 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4 w-full">
        <div class="flex items-center gap-5 text-center md:text-left">
            <div class="text-5xl">🔔</div>
            <div>
                <h1 class="text-2xl lg:text-3xl font-black text-[#1F4D1F]">Pusat Notifikasi</h1>
                <p class="text-slate-500 font-medium">Informasi terbaru dari sistem dan admin.</p>
            </div>
        </div>
        <div class="px-6 py-2 border-2 border-slate-800 rounded-full font-bold text-slate-800 bg-white">
            {{ now()->translatedFormat('l, d F Y') }}
        </div>
    </div>

    <div class="bg-white rounded-[30px] p-6 lg:p-10 shadow-sm border border-green-200 w-full">
        <div class="space-y-4 max-w-5xl mx-auto">
            @forelse($notifikasi as $notif)
            <div class="bg-white border border-slate-100 rounded-2xl p-6 relative hover:shadow-md transition-all border-l-8 
                @if($notif->type === 'critical') border-red-500 
                @elseif($notif->type === 'warning') border-orange-400 
                @else border-blue-500 @endif">
                
                <div class="flex justify-between items-start">
                    <div class="flex gap-4">
                        <div class="p-3 rounded-xl 
                            @if($notif->type === 'critical') bg-red-50 text-red-600 
                            @elseif($notif->type === 'warning') bg-orange-50 text-orange-600 
                            @else bg-blue-50 text-blue-600 @endif">
                            <i data-lucide="@if($notif->type === 'critical') alert-octagon @else bell @endif" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-800 uppercase tracking-tight">{{ $notif->title }}</h3>
                            <p class="text-[10px] font-bold text-slate-400 mb-2 uppercase">Dari {{ $notif->source }} | {{ $notif->datetime }}</p>
                            <p class="text-slate-600 text-sm leading-relaxed">{{ $notif->message }}</p>
                        </div>
                    </div>
                    
                    @if($notif->has_check)
                    <button class="text-slate-300 hover:text-green-600 transition-colors">
                        <i data-lucide="check-circle" class="w-8 h-8"></i>
                    </button>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-20 bg-slate-50 rounded-[30px] border-2 border-dashed border-slate-200">
                <i data-lucide="bell-off" class="w-12 h-12 text-slate-300 mx-auto mb-4"></i>
                <p class="text-slate-500 font-bold">Tidak ada notifikasi baru</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection