@extends('admin.layouts.app')

@section('title', 'Analytic & Report')
@section('header_title', 'Analytic & Report')

@section('content')

<div x-data="reportManager()" x-init="initCharts()">

    <div class="-mt-4 mb-7">
        <p class="text-[14px] lg:text-[16px] text-[#4a4a4a]">
            Performance analytics and waste collection trends.
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-green-200">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-green-100 rounded-2xl">
                    <i data-lucide="scale" class="w-8 h-8 text-green-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Collection</p>
                    <h3 class="text-2xl font-bold text-gray-800">9,275 <span class="text-sm font-normal">KG</span></h3>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-green-600 text-sm">
                <i data-lucide="trending-up" class="w-4 h-4"></i>
                <span>12% increase from last month</span>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-green-200">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-blue-100 rounded-2xl">
                    <i data-lucide="zap" class="w-8 h-8 text-blue-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Avg. Efficiency</p>
                    <h3 class="text-2xl font-bold text-gray-800">85.4 <span class="text-sm font-normal">%</span></h3>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-blue-600 text-sm">
                <i data-lucide="check-circle" class="w-4 h-4"></i>
                <span>System uptime: 99.9%</span>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-green-200">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-orange-100 rounded-2xl">
                    <i data-lucide="truck" class="w-8 h-8 text-orange-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Pickups</p>
                    <h3 class="text-2xl font-bold text-gray-800">124 <span class="text-sm font-normal">times</span></h3>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-orange-600 text-sm">
                <i data-lucide="map-pin" class="w-4 h-4"></i>
                <span>Most active: Polibatam Area</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <div class="bg-white rounded-[22px] p-6 shadow-sm border border-green-100">
            <h3 class="text-lg font-bold text-gray-700 mb-6">Monthly Waste Collection Trend</h3>
            <div class="h-[300px]">
                <canvas id="collectionChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-[22px] p-6 shadow-sm border border-green-100">
            <h3 class="text-lg font-bold text-gray-700 mb-6">Key Performance Metrics</h3>
            <div class="space-y-8">
                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-sm font-semibold text-gray-600">Organic Waste Rate</span>
                        <span class="text-sm font-bold text-green-600">85%</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-4">
                        <div class="bg-green-500 h-4 rounded-full" style="width: 85%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-sm font-semibold text-gray-600">Battery Health Avg.</span>
                        <span class="text-sm font-bold text-blue-600">92%</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-4">
                        <div class="bg-blue-500 h-4 rounded-full" style="width: 92%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-sm font-semibold text-gray-600">Response Time Score</span>
                        <span class="text-sm font-bold text-orange-600">78%</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-4">
                        <div class="bg-orange-500 h-4 rounded-full" style="width: 78%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[22px] p-6 shadow-sm border border-green-100">
        <h3 class="text-lg font-bold text-gray-700 mb-4">Location Breakdown</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left border-b border-gray-100">
                        <th class="py-3 px-2 text-sm text-gray-400 font-medium">Location Name</th>
                        <th class="py-3 px-2 text-sm text-gray-400 font-medium">Total Bin</th>
                        <th class="py-3 px-2 text-sm text-gray-400 font-medium">Monthly Vol</th>
                        <th class="py-3 px-2 text-sm text-gray-400 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-50">
                        <td class="py-4 px-2 font-bold text-gray-700">Gedung Utama Polibatam</td>
                        <td class="py-4 px-2 text-gray-600">12 Bins</td>
                        <td class="py-4 px-2 text-gray-600">2,450 KG</td>
                        <td class="py-4 px-2"><span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Optimal</span></td>
                    </tr>
                    <tr class="border-b border-gray-50">
                        <td class="py-4 px-2 font-bold text-gray-700">Kantin Pusat</td>
                        <td class="py-4 px-2 text-gray-600">8 Bins</td>
                        <td class="py-4 px-2 text-gray-600">4,120 KG</td>
                        <td class="py-4 px-2"><span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-bold">High Load</span></td>
                    </tr>
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
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Weight (KG)',
                        data: [1200, 1900, 1500, 2100, 2800, 2450],
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