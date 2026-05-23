@extends('operator.layout')
@section('title', 'Dashboard')

@section('content')
<div class="w-full max-w-7xl space-y-6">
    <div class="bg-white rounded-[25px] p-8 border border-green-100 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4 w-full">
        <div class="flex items-center gap-5">
            <div class="text-5xl">👋</div>
            <div class="text-left">
                <h1 class="text-2xl lg:text-3xl font-black text-[#1F4D1F]">Selamat Pagi, Operator!</h1>
                <p class="text-slate-500 font-medium">Monitoring sistem real-time.</p>
            </div>
        </div>
        <div class="px-6 py-2 border-2 border-slate-800 rounded-full font-bold text-slate-800">{{ now()->translatedFormat('l, d F Y') }}</div>
    </div>

    <div class="bg-white rounded-[30px] p-8 shadow-sm border border-green-200">
        <h2 class="text-xl font-bold text-slate-800 mb-6">Homebase Monitoring</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($homebases as $h)
            <div class="bg-[#f8faf8] border border-green-100 rounded-2xl p-6">
                <h3 class="font-black text-[#1F4D1F] text-lg">{{ $h['name'] }}</h3>
                <p class="text-xs text-slate-400 mb-4">{{ $h['location'] }}</p>
                <div class="flex gap-4">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Unit</p>
                        <p class="text-xl font-black">{{ $h['vacuum_assigned'] }}</p>
                    </div>
                    <div class="w-px bg-slate-200"></div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Aktif</p>
                        <p class="text-xl font-black text-blue-600">{{ $h['active'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="bg-red-50 border border-red-100 rounded-[30px] p-8">
        <h2 class="text-xl font-bold text-red-600 mb-6 flex items-center gap-2">
            <i data-lucide="alert-triangle"></i> Peringatan Penting
        </h2>
        <div class="space-y-4">
            @foreach($warnings as $w)
            <div class="bg-white p-6 rounded-2xl shadow-sm border-l-8 border-red-500">
                <h3 class="font-black text-slate-800 uppercase">{{ $w['title'] }}</h3>
                <p class="text-slate-600 text-sm">{{ $w['message'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection