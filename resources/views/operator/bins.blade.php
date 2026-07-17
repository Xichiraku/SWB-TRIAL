@extends('operator.layout')
@section('title', 'Bin Monitoring')
@section('header_title', 'Bin Monitoring')

@section('content')
<div class="w-full max-w-7xl space-y-6">

    {{-- Header --}}
    <div class="bg-white rounded-[25px] p-8 border border-green-100 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4 w-full">
        <div class="flex items-center gap-5">
            <div class="text-5xl text-center text-[#1F4D1F]">
                <i data-lucide="bar-chart-3" class="w-10 h-10"></i>
            </div>
            <div class="text-left">
                <h1 class="text-2xl lg:text-3xl font-black text-[#1F4D1F]">Status Smart Bins</h1>
                <p class="text-slate-500 font-medium">Detail kapasitas dan baterai unit.</p>
            </div>
        </div>
        <div class="px-6 py-2 border-2 border-slate-800 rounded-full font-bold text-slate-800">
            {{ now()->translatedFormat('l, d F Y') }}
        </div>
    </div>

    {{-- Grid Bins --}}
    <div class="bg-white rounded-[30px] p-10 shadow-sm border border-green-200">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 justify-items-center">
            @forelse ($bins as $bin)
            <a href="{{ route('operator.bin.detail', $bin->bin_id) }}"
               class="bg-white rounded-[25px] border border-green-200 p-8 hover:shadow-lg transition-all w-full relative group">

                {{-- Status Badge --}}
                <div class="absolute top-6 right-6">
                    <span class="px-4 py-1 text-white text-[10px] font-bold rounded-full uppercase
                        {{ $bin->status === 'Full' ? 'bg-red-500' : ($bin->status === 'Maintenance' ? 'bg-orange-500' : 'bg-green-500') }}">
                        {{ $bin->status }}
                    </span>
                </div>

                {{-- Header Bin --}}
                <div class="flex items-center gap-4 mb-6">
                    <div class="p-3 bg-green-50 rounded-xl text-[#1F4D1F] group-hover:bg-green-100 transition">
                        <i data-lucide="trash-2"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-800">{{ $bin->name ?? 'Bin #' . $bin->bin_id }}</h3>
                        <p class="text-xs text-slate-400">ID: {{ $bin->bin_id }}</p>
                        <p class="text-xs text-slate-400">{{ $bin->location }}</p>
                    </div>
                </div>

                {{-- Kapasitas --}}
                <div class="space-y-4">

                    {{-- Organic --}}
                    <div>
                        <div class="flex justify-between text-xs font-bold mb-1">
                            <span class="text-green-700">ORGANIK</span>
                            <span>{{ $bin->organic_capacity ?? 0 }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 h-3 rounded-full overflow-hidden">
                            <div class="h-full transition-all duration-500
                                {{ ($bin->organic_capacity ?? 0) >= 90 ? 'bg-red-500' : ($bin->organic_capacity ?? 0) >= 75 ? 'bg-yellow-400' : 'bg-green-400' }}"
                                 style="width: {{ $bin->organic_capacity ?? 0 }}%"></div>
                        </div>
                    </div>

                    {{-- Anorganic --}}
                    <div>
                        <div class="flex justify-between text-xs font-bold mb-1">
                            <span class="text-blue-700">ANORGANIK</span>
                            <span>{{ $bin->anorganic_capacity ?? 0 }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 h-3 rounded-full overflow-hidden">
                            <div class="h-full transition-all duration-500
                                {{ ($bin->anorganic_capacity ?? 0) >= 90 ? 'bg-red-500' : ($bin->anorganic_capacity ?? 0) >= 75 ? 'bg-yellow-400' : 'bg-blue-400' }}"
                                 style="width: {{ $bin->anorganic_capacity ?? 0 }}%"></div>
                        </div>
                    </div>

                    {{-- Battery + Prediction --}}
                    <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-500">
                            <i data-lucide="battery" class="w-4 h-4 {{ $bin->lowBattery() ? 'text-red-500' : 'text-slate-400' }}"></i>
                            <span class="{{ $bin->lowBattery() ? 'text-red-600' : 'text-slate-600' }}">
                                {{ $bin->battery ?? '-' }}%
                            </span>
                        </div>
                        <div class="text-xs font-bold text-[#1F4D1F] bg-green-50 px-3 py-1 rounded-full">
                            {{ $bin->full_prediction_label }}
                        </div>
                    </div>

                </div>
            </a>
            @empty
            <div class="col-span-2 py-20 text-center text-slate-400">
                <i data-lucide="inbox" class="w-12 h-12 mx-auto mb-3 opacity-40"></i>
                <p class="font-medium">Tidak ada bin terdaftar.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection