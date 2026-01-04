@extends('admin.layouts.app')

@section('title', 'Bin #' . $bin->bin_id . ' - Detail')

@section('page_title')
<div>
    <h1 class="text-3xl font-bold text-slate-900">Bin #{{ $bin->bin_id }}</h1>
    <div class="flex items-center gap-2 text-slate-500 mt-1">
        <i data-lucide="map-pin" class="w-4 h-4"></i>
        <span>{{ $bin->location ?? 'Lokasi Belum Diatur' }}</span>
    </div>
</div>
@endsection

@section('content')
<div class="w-full">
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <div class="bg-slate-100/80 p-6 rounded-2xl flex flex-col items-center justify-center h-40 border border-slate-200/50 shadow-sm">
            <span class="text-slate-600 font-medium mb-3">Status</span>
            @php
                $badgeColor = 'bg-green-600 text-white'; // Default Normal
                $iconName = 'check-circle';
                if($bin->status === 'Full' || $bin->capacity >= 85) {
                    $badgeColor = 'bg-red-600 text-white';
                    $iconName = 'alert-triangle';
                } elseif($bin->status === 'maintenance') {
                    $badgeColor = 'bg-orange-500 text-white';
                    $iconName = 'wrench';
                }
            @endphp
            <div class="px-6 py-1.5 rounded-full font-bold text-sm flex items-center gap-2 {{ $badgeColor }}">
                <i data-lucide="{{ $iconName }}" class="w-4 h-4"></i>
                {{ $bin->capacity >= 85 ? 'Full' : ($bin->status == 'maintenance' ? 'Maintenance' : 'Normal') }}
            </div>
        </div>

        <div class="bg-slate-100/80 p-6 rounded-2xl flex flex-col justify-center h-40 border border-slate-200/50 shadow-sm">
            <span class="text-slate-600 font-medium mb-4 text-center">Battery Level</span>
            <div class="w-full px-4">
                <div class="w-full bg-slate-300 rounded-full h-3 mb-2">
                    <div class="bg-cyan-800 h-3 rounded-full transition-all duration-1000" style="width: {{ $bin->battery }}%"></div>
                </div>
                <div class="text-center font-bold text-slate-800 mt-2">
                    {{ $bin->battery }}%
                </div>
            </div>
        </div>

        <div class="bg-slate-100/80 p-6 rounded-2xl flex flex-col items-center justify-center h-40 border border-slate-200/50 shadow-sm">
            <span class="text-slate-600 font-medium mb-2">Last Updated</span>
            <div class="flex items-center gap-2 mt-1 text-slate-800">
                <i data-lucide="clock" class="w-5 h-5"></i>
                <span class="font-medium">{{ \Carbon\Carbon::parse($bin->updated_at)->format('Y-m-d H:i') }}</span>
            </div>
        </div>
    </div>

    <div class="bg-sky-100 p-8 rounded-2xl border border-sky-200 mb-6 shadow-sm">
        <div class="flex items-center gap-3 mb-6">
            <i data-lucide="zap" class="w-6 h-6 text-slate-800"></i>
            <h3 class="text-lg font-medium text-slate-900">Solar Panel Status</h3>
        </div>

        <div class="grid grid-y-4 gap-4">
            <div class="flex justify-between items-center">
                <span class="text-slate-700">Power Generation</span>
                <span class="font-bold text-green-600">Active</span>
            </div>
            <div class="flex justify-between items-center border-t border-sky-200 pt-4">
                <span class="text-slate-700">Daily Energy</span>
                <span class="font-bold text-slate-900">2.4 kWh</span>
            </div>
            <div class="flex justify-between items-center border-t border-sky-200 pt-4">
                <span class="text-slate-700">Efficiency</span>
                <span class="font-bold text-slate-900">85%</span>
            </div>
        </div>
    </div>

    <div class="bg-white p-8 rounded-2xl border-2 border-slate-100 shadow-sm">
        <div class="flex items-center gap-3 mb-6">
            <i data-lucide="trash-2" class="w-6 h-6 text-slate-600"></i>
            <h3 class="text-lg font-medium text-slate-900">Vacuum System</h3>
        </div>

        <div class="grid grid-y-4 gap-4">
            <div class="flex justify-between items-center">
                <span class="text-slate-700">Motor Status</span>
                <span class="font-bold text-green-600">Online</span>
            </div>
            <div class="flex justify-between items-center border-t border-slate-100 pt-4">
                <span class="text-slate-700">Suction Power</span>
                <span class="font-bold text-slate-900">92%</span>
            </div>
            <div class="flex justify-between items-center border-t border-slate-100 pt-4">
                <span class="text-slate-700">Filter Status</span>
                <span class="font-bold text-slate-900">Clean</span>
            </div>
        </div>
    </div>

</div>

<script>
    lucide.createIcons();
</script>
@endsection