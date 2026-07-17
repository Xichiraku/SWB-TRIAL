@extends('operator.layout')
@section('title', 'Vacuum Monitoring')
@section('header_title', 'Vacuum Monitoring')

@section('content')
<div class="w-full max-w-7xl space-y-6">
    <div class="bg-white rounded-[25px] p-8 border border-green-100 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4 w-full">
        <div class="flex items-center gap-5">
            <div class="text-5xl text-center text-[#1F4D1F]">
                <i data-lucide="bar-chart-3" class="w-10 h-10"></i>
            </div>
            <div class="text-left">
                <h1 class="text-2xl lg:text-3xl font-black text-[#1F4D1F]">Status Vacuum Bin</h1>
                <p class="text-slate-500 font-medium">Detail kapasitas dan baterai unit.</p>
            </div>
        </div>
        <div class="px-6 py-2 border-2 border-slate-800 rounded-full font-bold text-slate-800">{{ now()->translatedFormat('l, d F Y') }}</div>
    </div>

    <div class="bg-white rounded-[30px] p-10 shadow-sm border border-green-200">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 justify-items-center">
            @foreach ($vacuums as $v)
            <div class="bg-white rounded-[25px] border border-green-200 p-8 hover:shadow-lg transition-all w-full relative">
                <div class="absolute top-6 right-6">
                    <span class="px-4 py-1 {{ $v->capacity >= 90 ? 'bg-red-500' : 'bg-green-500' }} text-white text-[10px] font-bold rounded-full uppercase">{{ $v->status }}</span>
                </div>
                <div class="flex items-center gap-4 mb-6">
                    <div class="p-3 bg-green-50 rounded-xl text-[#1F4D1F]"><i data-lucide="trash-2"></i></div>
                    <div>
                        <h3 class="text-xl font-black text-slate-800">{{ $v->name }}</h3>
                        <p class="text-xs text-slate-400">ID: {{ $v->vacuum_code }}</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-xs font-bold mb-1"><span>KAPASITAS</span><span>{{ $v->capacity }}%</span></div>
                        <div class="w-full bg-slate-100 h-3 rounded-full overflow-hidden">
                            <div class="h-full {{ $v->capacity >= 90 ? 'bg-red-500' : 'bg-[#9AD18B]' }}" style="width: {{ $v->capacity }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection