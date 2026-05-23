@extends('admin.layouts.app')

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
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="bg-white rounded-3xl p-6 border border-green-100 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <span class="text-slate-500 font-medium uppercase text-xs tracking-wider">Organic Tank</span>
                <i data-lucide="leaf" class="w-5 h-5 text-green-500"></i>
            </div>
            <div class="text-3xl font-bold text-slate-800 mb-2">{{ $bin->organic_capacity }}%</div>
            <div class="w-full bg-slate-100 rounded-full h-2">
                <div class="bg-green-500 h-2 rounded-full transition-all duration-700" style="width: {{ $bin->organic_capacity }}%"></div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-blue-100 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <span class="text-slate-500 font-medium uppercase text-xs tracking-wider">Anorganic Tank</span>
                <i data-lucide="recycle" class="w-5 h-5 text-blue-500"></i>
            </div>
            <div class="text-3xl font-bold text-slate-800 mb-2">{{ $bin->anorganic_capacity }}%</div>
            <div class="w-full bg-slate-100 rounded-full h-2">
                <div class="bg-blue-500 h-2 rounded-full transition-all duration-700" style="width: {{ $bin->anorganic_capacity }}%"></div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex flex-col justify-center">
            <span class="text-slate-500 font-medium mb-3 uppercase text-xs tracking-wider">Sorter System</span>
            <div class="flex items-center gap-2 font-bold text-green-600">
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                </span>
                Active / Standby
            </div>
        </div>

        <div class="bg-[#9AD18B] p-6 rounded-3xl shadow-sm flex flex-col justify-center border border-green-200">
            <span class="text-[#1F4D1F] font-bold mb-1 text-xs uppercase tracking-wider">Full Prediction</span>
            <div class="text-2xl font-black text-[#1F4D1F]">± 4h 20m</div>
            <p class="text-[10px] text-[#2D5A2D] mt-2 font-medium">Based on historical trends</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-1">
            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm h-full">
                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <i data-lucide="settings-2" class="w-5 h-5 text-green-600"></i>
                    Device Hardware
                </h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between py-3 border-b border-slate-50">
                        <span class="text-slate-500">ESP32 Status</span>
                        <span class="font-bold text-green-600">ONLINE</span>
                    </div>
                    <div class="flex justify-between py-3 border-b border-slate-50">
                        <span class="text-slate-500">Conveyor Belt</span>
                        <span class="font-bold text-slate-700 font-mono">Standby</span>
                    </div>
                    <div class="flex justify-between py-3 border-b border-slate-50">
                        <span class="text-slate-500">PIR Sensor</span>
                        <span class="font-bold text-slate-700">Detecting...</span>
                    </div>
                    <div class="flex justify-between py-3">
                        <span class="text-slate-500">Servo Sorter</span>
                        <span class="font-bold text-slate-700">Ready</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm h-full">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <i data-lucide="bar-chart" class="w-5 h-5 text-green-600"></i>
                        Sorting Distribution
                    </h3>
                    <span class="text-[10px] font-bold bg-slate-100 px-3 py-1 rounded-full text-slate-500 uppercase tracking-widest">Last 7 Days</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="aspect-square bg-slate-50 rounded-2xl flex items-center justify-center border border-slate-100 relative shadow-inner">
                         <div class="text-center p-4">
                             <div class="text-5xl font-black text-green-600 mb-1">64%</div>
                             <div class="text-xs font-bold text-slate-400 uppercase tracking-tighter">Organic Ratio</div>
                         </div>
                    </div>

                    <div class="space-y-6">
                        <div class="p-5 bg-green-50 rounded-2xl border border-green-100">
                            <p class="text-[10px] text-green-700 font-black uppercase mb-2 tracking-widest flex items-center gap-1">
                                <i data-lucide="info" class="w-3 h-3"></i> Recommendation
                            </p>
                            <p class="text-sm text-slate-600 leading-relaxed">
                                Trend shows higher organic load. Empty the <b>Organic</b> bin before 12:00 PM tomorrow.
                            </p>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                    <span class="text-sm font-medium text-slate-600">Organic</span>
                                </div>
                                <span class="font-bold text-slate-800">142 items</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                                    <span class="text-sm font-medium text-slate-600">Anorganic</span>
                                </div>
                                <span class="font-bold text-slate-800">82 items</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    lucide.createIcons();
</script>
@endsection