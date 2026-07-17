@php
    // Deteksi role: bisa dipakai dari $userRole (BinController) atau session langsung
    $role = $userRole ?? session('user')['role'] ?? 'operator';
    $isAdmin = $role === 'admin';
@endphp

@if($isAdmin)
    @extends('admin.layouts.app')
@endif

@section('title', __('app.bin_number', ['id' => $bin->bin_id]) . ' - ' . __('app.detail'))

@section('header_title')
    <div class="flex items-start gap-4">
        <div class="flex flex-col">
            <div class="flex items-center gap-3">
                <i data-lucide="trash-2" class="w-6 h-6"></i>
                <h2 class="text-2xl font-bold">{{ $bin->name }}</h2>
            </div>
            <p class="text-slate-500 mt-1 text-sm flex items-center gap-2">
                <i data-lucide="map-pin" class="w-4 h-4"></i>
                <span>{{ $bin->location ?? __('app.polibatam_area') }}</span>
            </p>
        </div>
    </div>
@endsection

@section('content')
<div class="w-full space-y-6">

    {{-- ===== STAT CARDS ATAS ===== --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

        {{-- Fill Level --}}

        <div class="bg-white rounded-3xl p-6 shadow-sm">

        <h3 class="font-bold text-lg mb-4 flex items-center gap-2">
            <i data-lucide="gauge" class="w-5 h-5"></i>
            <span>{{ __('app.fill_level') }}</span>
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

        <p class="mt-5 text-slate-600 flex items-center gap-2">
            <i data-lucide="ruler" class="w-4 h-4"></i>
            <span>{{ __('app.distance') }}</span>
            <b>{{ $bin->distance_cm }} cm</b>
        </p>

        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm">

        <h3 class="font-bold text-lg mb-4 flex items-center gap-2">
            <i data-lucide="droplets" class="w-5 h-5"></i>
            <span>{{ __('app.moisture_sensor') }}</span>
        </h3>

        <p class="mb-3">

        {{ __('app.raw_value') }}

        <b>{{ $bin->moisture }}</b>

        </p>

        <p class="mb-3">

        {{ __('app.moisture') }}

        <b>{{ $bin->moisture_percent }}%</b>

        </p>

        </div>

       <div class="bg-white rounded-3xl p-6 shadow-sm">

<h3 class="font-bold text-lg mb-4 flex items-center gap-2">
    <i data-lucide="cpu" class="w-5 h-5"></i>
    <span>{{ __('app.device') }}</span>
</h3>

<p>

Status

<b class="device-status-text flex items-center gap-2" data-bin-code="{{ $bin->bin_id }}">
    <i data-lucide="{{ $bin->isOnline() ? 'circle-dot' : 'circle-off' }}" class="w-4 h-4 {{ $bin->isOnline() ? 'text-green-600' : 'text-red-600' }}"></i>
    <span>{{ $bin->isOnline() ? __('app.online') : __('app.offline') }}</span>
</b>

</p>

<p class="mt-4">

{{ __('app.last_seen') }}

<br>

<span class="device-last-seen" data-bin-code="{{ $bin->bin_id }}">{{ $bin->last_seen_at ? \Carbon\Carbon::createFromTimestampUTC((int) $bin->last_seen_at)->format('d M Y H:i:s') : '-' }}</span>

</p>

<div class="mt-6 pt-4 border-t border-slate-200 space-y-3">

<div class="flex justify-between text-sm">

<span class="text-slate-500">HC-SR04</span>

<span class="flex items-center gap-2">
    @if(!$bin->isOnline())
        <i data-lucide="circle-off" class="w-4 h-4 text-red-600"></i>
        <span>{{ __('app.offline') }}</span>
    @elseif($bin->sensor_error)
        <i data-lucide="triangle-alert" class="w-4 h-4 text-red-600"></i>
        <span>Error</span>
    @else
        <i data-lucide="check-circle-2" class="w-4 h-4 text-green-600"></i>
        <span>OK</span>
    @endif
</span>

</div>

<div class="flex justify-between text-sm">

<span class="text-slate-500">Moisture Sensor</span>

<span class="flex items-center gap-2">
    @if(!$bin->isOnline())
        <i data-lucide="circle-off" class="w-4 h-4 text-red-600"></i>
        <span>{{ __('app.offline') }}</span>
    @else
        <i data-lucide="check-circle-2" class="w-4 h-4 text-green-600"></i>
        <span>OK</span>
    @endif
</span>

</div>

<div class="flex justify-between text-sm">

<span class="text-slate-500">ESP32</span>

<span class="device-status-line flex items-center gap-2" data-bin-code="{{ $bin->bin_id }}">
    <i data-lucide="{{ $bin->isOnline() ? 'circle-dot' : 'circle-off' }}" class="w-4 h-4 {{ $bin->isOnline() ? 'text-green-600' : 'text-red-600' }}"></i>
    <span>{{ $bin->isOnline() ? __('app.online') : __('app.offline') }}</span>
</span>

</div>

</div>

</div>
        

        <div class="bg-white rounded-3xl p-8 shadow-sm">

<h2 class="text-xl font-bold mb-6 flex items-center gap-2">
    <i data-lucide="scan-search" class="w-5 h-5"></i>
    <span>{{ __('app.sensor_information') }}</span>
</h2>

<div class="grid grid-cols-2 gap-6">

<div>

<p class="text-slate-500">

{{ __('app.capacity') }}

</p>

<p class="text-3xl font-bold">

{{ $bin->capacity }}%

</p>

</div>

<div>

<p class="text-slate-500">

{{ __('app.distance') }}

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

</div>

</div>
              
<script>
lucide.createIcons();

const statusUrl = "{{ route('admin.bin.status', ['code' => $bin->bin_id]) }}";

function refreshDeviceStatus() {
    fetch(statusUrl, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then((response) => response.json())
    .then((result) => {
        if (!result.success || !result.data) return;

        document.querySelectorAll(`.device-status-text[data-bin-code="${result.data.bin_id}"]`).forEach((el) => {
            const icon = el.querySelector('i');
            const label = el.querySelector('span');
            if (icon) {
                icon.setAttribute('data-lucide', result.data.is_online ? 'circle-dot' : 'circle-off');
                icon.className = `w-4 h-4 ${result.data.is_online ? 'text-green-600' : 'text-red-600'}`;
            }
            if (label) {
                label.textContent = result.data.is_online ? '{{ __('app.online') }}' : '{{ __('app.offline') }}';
            }
        });

        document.querySelectorAll(`.device-status-line[data-bin-code="${result.data.bin_id}"]`).forEach((el) => {
            const icon = el.querySelector('i');
            const label = el.querySelector('span');
            if (icon) {
                icon.setAttribute('data-lucide', result.data.is_online ? 'circle-dot' : 'circle-off');
                icon.className = `w-4 h-4 ${result.data.is_online ? 'text-green-600' : 'text-red-600'}`;
            }
            if (label) {
                label.textContent = result.data.is_online ? '{{ __('app.online') }}' : '{{ __('app.offline') }}';
            }
        });

        document.querySelectorAll(`.device-last-seen[data-bin-code="${result.data.bin_id}"]`).forEach((el) => {
            el.textContent = result.data.last_seen_at;
        });
    })
    .catch((error) => console.error('Gagal memperbarui status device:', error));
}

refreshDeviceStatus();
setInterval(refreshDeviceStatus, 5000);
</script>
@endsection