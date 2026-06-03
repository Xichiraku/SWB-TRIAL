@php
    // Deteksi role: bisa dipakai dari $userRole (BinController) atau session langsung
    $role = $userRole ?? session('user')['role'] ?? 'operator';
    $isAdmin = $role === 'admin';
@endphp

@if($isAdmin)
    @extends('admin.layouts.app')
@else
    @extends('operator.layout')
@endif

@section('title', 'Bin #' . $bin->bin_id . ' - Detail')

@section('header_title')
<div class="flex flex-col lg:flex-row lg:items-center gap-2 lg:gap-4">
    <span class="text-slate-800">Bin #{{ $bin->bin_id }}</span>
    <div class="flex items-center gap-2 text-sm lg:text-base text-slate-500 font-normal">
        <i data-lucide="map-pin" class="w-4 h-4"></i>
        <span>{{ $bin->location ?? 'Polibatam Area' }}</span>
    </div>
</div>
@endsection

@section('content')
<div class="w-full space-y-6">

    {{-- ===== STAT CARDS ATAS ===== --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

        {{-- Organic Tank --}}
        <div class="bg-white rounded-3xl p-6 border border-green-100 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <span class="text-slate-500 font-medium uppercase text-xs tracking-wider">Organic Tank</span>
                <i data-lucide="leaf" class="w-5 h-5 text-green-500"></i>
            </div>
            <div class="text-3xl font-bold text-slate-800 mb-2">{{ $bin->organic_capacity ?? 0 }}%</div>
            <div class="w-full bg-slate-100 rounded-full h-2">
                <div class="bg-green-500 h-2 rounded-full transition-all duration-700"
                     style="width: {{ $bin->organic_capacity ?? 0 }}%"></div>
            </div>
        </div>

        {{-- Anorganic Tank --}}
        <div class="bg-white rounded-3xl p-6 border border-blue-100 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <span class="text-slate-500 font-medium uppercase text-xs tracking-wider">Anorganic Tank</span>
                <i data-lucide="recycle" class="w-5 h-5 text-blue-500"></i>
            </div>
            <div class="text-3xl font-bold text-slate-800 mb-2">{{ $bin->anorganic_capacity ?? 0 }}%</div>
            <div class="w-full bg-slate-100 rounded-full h-2">
                <div class="bg-blue-500 h-2 rounded-full transition-all duration-700"
                     style="width: {{ $bin->anorganic_capacity ?? 0 }}%"></div>
            </div>
        </div>

        {{-- Sorter System --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex flex-col justify-center">
            <span class="text-slate-500 font-medium mb-3 uppercase text-xs tracking-wider">Sorter System</span>
            @php
                $sorterOnline = ($bin->esp32_status ?? 'Offline') === 'Online';
            @endphp
            <div class="flex items-center gap-2 font-bold {{ $sorterOnline ? 'text-green-600' : 'text-red-500' }}">
                <span class="relative flex h-3 w-3">
                    @if($sorterOnline)
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                    @else
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                    @endif
                </span>
                {{ $sorterOnline ? ($bin->conveyor_status ?? 'Standby') : 'Offline' }}
            </div>
        </div>

        {{-- Full Prediction --}}
        <div class="bg-[#9AD18B] p-6 rounded-3xl shadow-sm flex flex-col justify-center border border-green-200">
            <span class="text-[#1F4D1F] font-bold mb-1 text-xs uppercase tracking-wider">Full Prediction</span>
            <div class="text-2xl font-black text-[#1F4D1F]">
                {{ $bin->full_prediction_label }}
            </div>
            <p class="text-[10px] text-[#2D5A2D] mt-2 font-medium">Based on historical trends</p>
        </div>

    </div>

    {{-- ===== BAWAH: Hardware + Sorting Distribution ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Hardware Detail — HANYA ADMIN --}}
        @if($isAdmin)
        <div class="lg:col-span-1">
            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm h-full">
                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <i data-lucide="settings-2" class="w-5 h-5 text-green-600"></i>
                    Device Hardware
                </h3>

                <div class="space-y-4">
                    <div class="flex justify-between py-3 border-b border-slate-50">
                        <span class="text-slate-500">ESP32 Status</span>
                        <span class="font-bold {{ ($bin->esp32_status ?? 'Offline') === 'Online' ? 'text-green-600' : 'text-red-500' }}">
                            {{ strtoupper($bin->esp32_status ?? 'OFFLINE') }}
                        </span>
                    </div>
                    <div class="flex justify-between py-3 border-b border-slate-50">
                        <span class="text-slate-500">Conveyor Belt</span>
                        <span class="font-bold text-slate-700 font-mono">{{ $bin->conveyor_status ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-3 border-b border-slate-50">
                        <span class="text-slate-500">PIR Sensor</span>
                        <span class="font-bold text-slate-700">{{ $bin->pir_status ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-3">
                        <span class="text-slate-500">Servo Sorter</span>
                        <span class="font-bold text-slate-700">{{ $bin->servo_status ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Sorting Distribution — span 2 di admin, full di operator --}}
        <div class="{{ $isAdmin ? 'lg:col-span-2' : 'lg:col-span-3' }}">
            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm h-full">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <i data-lucide="bar-chart" class="w-5 h-5 text-green-600"></i>
                        Sorting Distribution
                    </h3>
                    <span class="text-[10px] font-bold bg-slate-100 px-3 py-1 rounded-full text-slate-500 uppercase tracking-widest">
                        Last 7 Days
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    {{-- Organic Ratio --}}
                    @php
                        $total = ($bin->organic_count ?? 0) + ($bin->anorganic_count ?? 0);
                        $organicRatio = $total > 0
                            ? round(($bin->organic_count / $total) * 100)
                            : 0;
                    @endphp
                    <div class="aspect-square bg-slate-50 rounded-2xl flex items-center justify-center border border-slate-100 relative shadow-inner">
                        <div class="text-center p-4">
                            <div class="text-5xl font-black text-green-600 mb-1">{{ $organicRatio }}%</div>
                            <div class="text-xs font-bold text-slate-400 uppercase tracking-tighter">Organic Ratio</div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        {{-- Recommendation --}}
                        <div class="p-5 bg-green-50 rounded-2xl border border-green-100">
                            <p class="text-[10px] text-green-700 font-black uppercase mb-2 tracking-widest flex items-center gap-1">
                                <i data-lucide="info" class="w-3 h-3"></i> Recommendation
                            </p>
                            <p class="text-sm text-slate-600 leading-relaxed">
                                @if($organicRatio >= 60)
                                    Trend shows higher organic load. Empty the <b>Organic</b> bin soon.
                                @elseif($organicRatio <= 40)
                                    Trend shows higher anorganic load. Empty the <b>Anorganic</b> bin soon.
                                @else
                                    Waste distribution is balanced. No immediate action needed.
                                @endif
                            </p>
                        </div>

                        {{-- Item Counts --}}
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                    <span class="text-sm font-medium text-slate-600">Organic</span>
                                </div>
                                <span class="font-bold text-slate-800">{{ $bin->organic_count ?? 0 }} items</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                                    <span class="text-sm font-medium text-slate-600">Anorganic</span>
                                </div>
                                <span class="font-bold text-slate-800">{{ $bin->anorganic_count ?? 0 }} items</span>
                            </div>
                        </div>

                        {{-- Battery — ditampilkan di kedua role --}}
                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                            <div class="flex items-center gap-3">
                                <i data-lucide="battery" class="w-4 h-4 text-slate-400"></i>
                                <span class="text-sm font-medium text-slate-600">Battery</span>
                            </div>
                            <span class="font-bold {{ ($bin->battery ?? 100) < 30 ? 'text-red-600' : 'text-slate-800' }}">
                                {{ $bin->battery ?? '-' }}%
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>lucide.createIcons();</script>
@endsection