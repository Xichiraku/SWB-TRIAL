@php
    // Deteksi role: bisa dipakai dari $userRole (BinController) atau session langsung
    $role = $userRole ?? session('user')['role'] ?? 'operator';
    $isAdmin = $role === 'admin';
@endphp

@if($isAdmin)
    @extends('admin.layouts.app')
@endif

@section('title', 'Bin #' . $bin->bin_id . ' - Detail')

@section('header_title')
    <div class="flex flex-col lg:flex-row lg:items-center gap-2 lg:gap-4">
    <div>
    <h2 class="text-2xl font-bold">
        🗑️ {{ $bin->name }}
    </h2>

    <p class="text-slate-500 mt-1">
        📍 {{ $bin->location }}
    </p>
    </div>
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

        {{-- Fill Level --}}

        <div class="bg-white rounded-3xl p-6 shadow-sm">

        <h3 class="font-bold text-lg mb-4">
        📊 Fill Level
        </h3>

        <div class="text-4xl font-bold text-green-600">
        {{ $bin->capacity }}%
        </div>

        <div class="w-full bg-slate-200 rounded-full h-3 mt-4">

        <div
        class="bg-green-500 h-3 rounded-full transition-all duration-500"
        style="width: {{ $bin->capacity }}%">
        </div>

        </div>

        <p class="mt-5 text-slate-600">

        📏 Distance

        <b>{{ $bin->distance_cm }} cm</b>

        </p>

        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm">

        <h3 class="font-bold text-lg mb-4">
        💧 Moisture Sensor
        </h3>

        <p class="mb-3">

        Raw Value

        <b>{{ $bin->moisture }}</b>

        </p>

        <p class="mb-3">

        Moisture

        <b>{{ $bin->moisture_percent }}%</b>

        </p>

        <p>

        Status

        <b>

        {{ $bin->moisture_status }}

        </b>

        </p>

        </div>

       <div class="bg-white rounded-3xl p-6 shadow-sm">

<h3 class="font-bold text-lg mb-4">
🤖 Last Sorting
</h3>

<div class="text-3xl font-bold">

{{ $bin->last_sort_result }}

</div>

</div>
       <div class="bg-white rounded-3xl p-6 shadow-sm">

<h3 class="font-bold text-lg mb-4">
📡 Device
</h3>

<p>

Status

<b>

{{ $bin->isOnline() ? '🟢 Online' : '🔴 Offline' }}

</b>

</p>

<p class="mt-4">

Last Seen

<br>

{{ optional($bin->last_seen_at)->format('d M Y H:i:s') }}

</p>

</div>


 <div class="space-y-4">

<div class="flex justify-between">

<span>

HC-SR04

</span>

<span>

{{ $bin->sensor_error ? '❌ Error' : '✅ OK' }}

</span>

</div>

<div class="flex justify-between">

<span>

YL-69

</span>

<span>

✅ OK

</span>

</div>

<div class="flex justify-between">

<span>

ESP32

</span>

<span>

{{ $bin->isOnline() ? '🟢 Online' : '🔴 Offline' }}

</span>

</div>

</div>
        

        <div class="bg-white rounded-3xl p-8 shadow-sm">

<h2 class="text-xl font-bold mb-6">

📋 Sensor Information

</h2>

<div class="grid grid-cols-2 gap-6">

<div>

<p class="text-slate-500">

Capacity

</p>

<p class="text-3xl font-bold">

{{ $bin->capacity }}%

</p>

</div>

<div>

<p class="text-slate-500">

Distance

</p>

<p class="text-3xl font-bold">

{{ $bin->distance_cm }} cm

</p>

</div>

<div>

<p class="text-slate-500">

Moisture

</p>

<p class="text-3xl font-bold">

{{ $bin->moisture_percent }}%

</p>

</div>

<div>

<p class="text-slate-500">

Status

</p>

<p class="text-3xl font-bold">

{{ $bin->moisture_status }}

</p>

</div>

</div>

</div>
              
<script>lucide.createIcons();</script>
@endsection