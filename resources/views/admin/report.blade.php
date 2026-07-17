@extends('admin.layouts.app')

@section('title', __('app.analytics_and_report'))
@section('header_title', __('app.analytics_and_report'))

@section('content')

<div x-data="reportManager()" x-init="initCharts()">

    <div class="-mt-4 mb-7">
        <p class="text-[14px] lg:text-[16px] text-[#4a4a4a]">
            {{ __('app.report_description') }}
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">

    {{-- Total Sorting --}}
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-green-200">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-green-100 rounded-2xl">
                <i data-lucide="trash-2" class="w-8 h-8 text-green-600"></i>
            </div>

            <div>
                <p class="text-sm text-gray-500 font-medium">
                    {{ __('app.total_sorting') }}
                </p>

                <h3 class="text-3xl font-bold text-gray-800">
                    {{ $totalSorting }}
                </h3>
            </div>
        </div>

        <div class="mt-4 text-green-600 text-sm">
            {{ __('app.successful_sorting_events') }}
        </div>
    </div>

    {{-- Full Bin --}}
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-red-200">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-red-100 rounded-2xl">
                <i data-lucide="alert-triangle" class="w-8 h-8 text-red-600"></i>
            </div>

            <div>
                <p class="text-sm text-gray-500 font-medium">
                    {{ __('app.full_bin_events') }}
                </p>

                <h3 class="text-3xl font-bold text-gray-800">
                    {{ $fullEvents }}
                </h3>
            </div>
        </div>

        <div class="mt-4 text-red-600 text-sm">
            {{ __('app.bin_reached_full_capacity') }}
        </div>
    </div>

    {{-- Maintenance --}}
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-orange-200">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-orange-100 rounded-2xl">
                <i data-lucide="wrench" class="w-8 h-8 text-orange-600"></i>
            </div>

            <div>
                <p class="text-sm text-gray-500 font-medium">
                    {{ __('app.maintenance_events') }}
                </p>

                <h3 class="text-3xl font-bold text-gray-800">
                    {{ $maintenanceEvents }}
                </h3>
            </div>
        </div>

        <div class="mt-4 text-orange-600 text-sm">
            {{ __('app.sensor_maintenance_history') }}
        </div>
    </div>

</div>


    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <div class="bg-white rounded-[22px] p-6 shadow-sm border border-green-100 ">
            <h3 class="text-lg font-bold text-gray-700 mb-6">
                {{ __('app.sorting_activity') }}
            </h3>
            <div class="h-[300px]">
                <canvas id="collectionChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-[22px] p-6 shadow-sm border border-green-100">
            <h3 class="text-lg font-bold text-gray-700 mb-6">
            {{ __('app.waste_distribution') }}
        </h3>
            <div class="space-y-8">

            @php
                $total = $wetCount + $dryCount;

                $wetPercent = $total > 0 ? round(($wetCount / $total) * 100) : 0;

                $dryPercent = $total > 0 ? round(($dryCount / $total) * 100) : 0;
            @endphp

            <div>

                <div class="flex justify-between mb-2">

                    <span class="text-sm font-semibold text-gray-600">
                        {{ __('app.wet_waste') }}
                    </span>

                    <span class="text-sm font-bold text-green-600">

                        {{ $wetPercent }}%

                    </span>

                </div>

                <div class="w-full bg-gray-100 rounded-full h-4">

                    <div
                        class="bg-green-500 h-4 rounded-full"
                        style="width: {{ $wetPercent }}%">
                    </div>

                </div>

            </div>

            <div>

                <div class="flex justify-between mb-2">

                    <span class="text-sm font-semibold text-gray-600">
                        {{ __('app.dry_waste') }}
                    </span>

                    <span class="text-sm font-bold text-blue-600">

                        {{ $dryPercent }}%

                    </span>

                </div>

                <div class="w-full bg-gray-100 rounded-full h-4">

                    <div
                        class="bg-blue-500 h-4 rounded-full"
                        style="width: {{ $dryPercent }}%">
                    </div>

                </div>

            </div>

        </div>
</div>
        <div class="flex justify-end mb-6">

                <a href="{{ route('admin.export.report.pdf') }}"
                class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-xl font-semibold transition">

                    <i data-lucide="download" class="w-5 h-5"></i>

                    {{ __('app.export_pdf') }}

                </a>
            </div>

    <div class="bg-white rounded-[22px] p-6 shadow-sm border border-green-100 lg:col-span-2">
        <h3 class="text-lg font-bold text-gray-700 mb-4">
            {{ __('app.current_bin_status') }}
        </h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left border-b border-gray-100">

                    <th class="py-3 px-2 text-sm text-gray-400 font-medium">

                    {{ __('app.bin') }}

                    </th>

                    <th class="py-3 px-2 text-sm text-gray-400 font-medium">

                    {{ __('app.capacity') }}

                    </th>

                    <th class="py-3 px-2 text-sm text-gray-400 font-medium">

                    {{ __('app.status') }}

                    </th>

                    <th class="py-3 px-2 text-sm text-gray-400 font-medium">

                    {{ __('app.last_sorting') }}

                    </th>

                    <th class="py-3 px-2 text-sm text-gray-400 font-medium">

                    {{ __('app.last_seen') }}

                    </th>

                    </tr>

                    </thead>
                <tbody>

                @foreach($bins as $bin)

                <tr class="border-b border-gray-100">

                    <td class="py-4 px-2 font-bold text-gray-700">

                        {{ $bin->name }}

                    </td>

                    <td class="py-4 px-2">

                        {{ $bin->capacity }}%

                    </td>

                    <td class="py-4 px-2">

                        @if($bin->computed_status == 'Full')

                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                                {{ __('app.full') }}
                            </span>

                        @elseif($bin->computed_status == 'Maintenance')

                            <span class="px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-bold">
                                {{ __('app.maintenance') }}
                            </span>

                        @else

                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                                {{ __('app.normal') }}
                            </span>

                        @endif

                    </td>

                    <td class="py-4 px-2">

                        {{ $bin->last_sort_result }}

                    </td>

                    <td class="py-4 px-2">

                        {{ optional($bin->last_seen_at)->format('d M Y H:i') }}

                    </td>

                </tr>

                @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('reportManager', () => ({
        initCharts() {
            const ctx = document.getElementById('collectionChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode(array_keys($sortingChart)) !!},
                    datasets: [{
                        label: 'Weight (KG)',
                        data: {!! json_encode(array_values($sortingChart)) !!},
                        backgroundColor: '#9AD18B',
                        borderRadius: 8,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { beginAtZero: true, grid: { display: false } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }
    }));
});
</script>

@endsection