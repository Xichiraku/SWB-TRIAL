@extends('operator.layout')
@section('title', 'Dashboard')
@section('header_title', 'Dashboard')

@section('content')
<div class="w-full max-w-7xl space-y-6">
    <div class="bg-white rounded-[25px] p-8 border border-green-100 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4 w-full">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center">

                <i data-lucide="shield-check"
                class="w-9 h-9 text-green-700"></i>

            </div>
            <div class="text-left">
                <h1 class="text-2xl lg:text-3xl font-black text-[#1F4D1F]">Selamat Pagi, Operator!</h1>
                <p class="text-slate-500 font-medium">Monitoring sistem real-time.</p>
            </div>
        </div>
        <div class="px-6 py-2 border-2 border-slate-800 rounded-full font-bold text-slate-800">{{ now()->translatedFormat('l, d F Y') }}</div>
    </div>

    <!-- <div class="bg-red-50 border border-red-100 rounded-[30px] p-8">
        <h2 class="text-xl font-bold text-red-600 mb-6 flex items-center gap-2">
            <i data-lucide="alert-triangle"></i> Peringatan Penting
        </h2>
        <div class="space-y-4">
            @foreach($warnings as $w)
            <div class="bg-white p-6 rounded-2xl shadow-sm border-l-8 border-red-500">
                <h3 class="font-black text-slate-800 uppercase">{{ $w->title }}</h3>
                <p class="text-slate-600 text-sm">{{ $w->message }}</p>
            </div>
            @endforeach
        </div>
    </div> -->

    <div class="bg-white rounded-[30px] p-8 shadow-sm border border-green-200">

    <div class="flex items-center gap-3 mb-7">

        <i data-lucide="activity"
           class="w-7 h-7 text-green-600"></i>

        <h2 class="text-xl font-bold text-slate-800">

            Live Bin Monitoring

        </h2>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        @foreach($bins as $bin)

        <div class="border border-slate-200 rounded-3xl p-6 hover:shadow-md transition">

            <div class="flex justify-between items-start">

                <div class="flex items-center gap-4">

                    <div class="w-14 h-14 rounded-2xl bg-green-50 flex items-center justify-center">

                        <i data-lucide="trash-2"
                           class="w-7 h-7 text-green-600"></i>

                    </div>

                    <div>

                        <h3 class="font-bold text-lg">

                            {{ $bin->name }}

                        </h3>

                        <p class="text-sm text-slate-500">

                            {{ $bin->location }}

                        </p>

                    </div>

                </div>

                @if($bin->capacity >= 90)

                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-600 text-xs font-bold status-badge" data-bin-id="{{ $bin->bin_id }}">

                        Full

                    </span>

                @elseif($bin->capacity >= 75)

                    <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold status-badge" data-bin-id="{{ $bin->bin_id }}">

                        Warning

                    </span>

                @elseif($bin->sensor_error)

                    <span class="px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-bold status-badge" data-bin-id="{{ $bin->bin_id }}">

                        Maintenance

                    </span>

                @else

                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold status-badge" data-bin-id="{{ $bin->bin_id }}">

                        Normal

                    </span>

                @endif

            </div>

            <div class="mt-6 space-y-4">

                <div>

                    <div class="flex justify-between text-sm">

                        <span class="text-slate-500">

                            Capacity

                        </span>

                        <span class="font-bold capacity-text" data-bin-id="{{ $bin->bin_id }}">

                            {{ $bin->capacity }}%

                        </span>

                    </div>

                    <div class="mt-2 w-full bg-slate-200 rounded-full h-2">

                        <div
                            class="capacity-bar bg-green-500 h-2 rounded-full"
                            data-bin-id="{{ $bin->bin_id }}"
                            style="width: {{ $bin->capacity }}%">
                        </div>

                    </div>

                </div>

                <!-- <div class="flex justify-between">

                    <span class="text-slate-500">

                        Moisture

                    </span>

                    <span class="font-semibold moisture-status" data-bin-id="{{ $bin->bin_id }}">

                        {{ $bin->moisture_status }}

                    </span>

                </div> -->

                <div class="flex justify-between">

                    <span class="text-slate-500">

                        Updated

                    </span>

                    <span class="font-semibold updated-at" data-bin-id="{{ $bin->bin_id }}">

                        {{ optional($bin->updated_at)->format('H:i:s') }}

                    </span>

                </div>

            </div>

        </div>

        @endforeach

    </div>

</div>
<script>
lucide.createIcons();

const refreshUrl = "{{ route('operator.dashboard.refresh') }}";
const refreshIntervalMs = 5000;

function refreshBins() {
    fetch(refreshUrl, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then((response) => response.json())
    .then((result) => {
        if (!result.success) return;

        (result.data || []).forEach((bin) => {
            // Capacity text
            const capEl = document.querySelector(`.capacity-text[data-bin-id="${bin.bin_id}"]`);
            if (capEl) capEl.textContent = bin.capacity + '%';

            // Progress bar
            const barEl = document.querySelector(`.capacity-bar[data-bin-id="${bin.bin_id}"]`);
            if (barEl) {
                barEl.style.width = bin.capacity + '%';
                barEl.className = 'capacity-bar h-2 rounded-full ' +
                    (bin.sensor_error ? 'bg-yellow-500' : bin.capacity >= 90 ? 'bg-red-500' : bin.capacity >= 75 ? 'bg-yellow-400' : 'bg-green-500');
            }

            // Status badge
            const badgeEl = document.querySelector(`.status-badge[data-bin-id="${bin.bin_id}"]`);
            if (badgeEl) {
                badgeEl.textContent = bin.status;
                badgeEl.className = 'px-3 py-1 rounded-full text-xs font-bold status-badge ' +
                    (bin.status === 'Full' ? 'bg-red-100 text-red-600' :
                     bin.status === 'Warning' ? 'bg-yellow-100 text-yellow-700' :
                     bin.status === 'Maintenance' ? 'bg-orange-100 text-orange-700' :
                     'bg-green-100 text-green-700');
            }

            // Moisture
            const statusEl = document.querySelector(`.moisture-status[data-bin-id="${bin.bin_id}"]`);
            if (statusEl) statusEl.textContent = bin.moisture_status ?? 'Unknown';

            // Updated time
            const updatedEl = document.querySelector(`.updated-at[data-bin-id="${bin.bin_id}"]`);
            if (updatedEl) updatedEl.textContent = bin.updated_at ?? '-';
        });
    })
    .catch((error) => console.error('Gagal memperbarui data bin:', error));
}

refreshBins();
setInterval(refreshBins, refreshIntervalMs);
</script>
@endsection