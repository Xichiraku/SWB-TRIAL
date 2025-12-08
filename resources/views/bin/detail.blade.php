@extends('admin.layouts.app')

@section('title', 'Bin - Smart Waste Monitor')

@section('content')

<style>
    /* Biar kartu kalau dihover langsung biru */
    .card-item {
        transition: 0.25s ease;
    }
    .card-item:hover {
        background-color: #dbeafe !important; /* biru-100 */
        border: 1px solid #3b82f6 !important; /* border biru-500 */
        transform: translateY(-2px);
    }
</style>

        <!-- Header -->
        <div class="flex justify-between items-center mb-6 -mt-10">
            <div>
                <h1 class="text-4xl font-bold text-gray-800">{{ $bin['name'] }}</h1>
                <div class="flex items-center gap-2 text-gray-600 mt-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>{{ $bin['location'] }}</span>
                </div>
            </div>
        </div>

        <!-- Status Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

            <!-- STATUS -->
            <div class="card-item bg-white rounded-xl shadow-md p-6 border">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Status</h3>
                <div class="flex items-center justify-center">
                    @if($bin['status'] === 'Full')
                        <span class="flex items-center gap-2 bg-red-100 text-red-600 px-6 py-3 rounded-lg font-bold">
                            Full
                        </span>
                    @elseif($bin['status'] === 'Normal')
                        <span class="bg-green-100 text-green-600 px-6 py-3 rounded-lg font-bold">Normal</span>
                    @else
                        <span class="bg-gray-100 text-gray-600 px-6 py-3 rounded-lg font-bold">Empty</span>
                    @endif
                </div>
            </div>

            <!-- BATTERY -->
            <div class="card-item bg-white rounded-xl shadow-md p-6 border">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Battery Level</h3>

                <div class="flex items-center gap-3">
                    <div class="flex-1">
                        <div class="bg-gray-200 rounded-full h-4">
                            <div class="bg-blue-600 h-4 rounded-full transition-all duration-500"
                                style="width: {{ $bin['battery'] }}%"></div>
                        </div>
                    </div>

                    <span class="text-2xl font-bold text-gray-800">{{ $bin['battery'] }}%</span>
                </div>
            </div>

            <!-- LAST EMPTIED -->
            <div class="card-item bg-white rounded-xl shadow-md p-6 border">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Last Emptied</h3>

                <div class="flex items-center gap-2 text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-lg">{{ $bin['last_emptied'] }}</span>
                </div>
            </div>
        </div>

        <!-- Trash Volume Chart -->
        <div class="card-item bg-white rounded-xl shadow-md p-6 mb-6 border">

            <h3 class="text-xl font-bold text-gray-800 mb-6">Trash Volume - Last 24 Hours</h3>

            <!-- Current Capacity -->
            <div class="bg-gray-50 rounded-xl p-6 mb-6">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="text-lg font-semibold text-gray-700">Current Capacity</h4>
                    <span class="text-2xl font-bold text-gray-800">{{ $bin['capacity'] }}%</span>
                </div>

                <div class="bg-gray-200 rounded-full h-4">
                    <div class="bg-blue-600 h-4 rounded-full transition-all duration-500"
                        style="width: {{ $bin['capacity'] }}%"></div>
                </div>
            </div>

            <h4 class="text-lg font-semibold text-gray-700 mb-4">Volume History (Hourly)</h4>

            <div class="grid grid-cols-8 gap-2">
                @for($i = 0; $i < 16; $i++)
                    <div class="text-center">
                        <div class="bg-blue-500 rounded-t-lg mb-2"
                             style="height: {{ rand(40, 150) }}px"></div>
                        <span class="text-xs text-gray-500">24h</span>
                    </div>
                @endfor
            </div>

        </div>

        <!-- Solar + Vacuum -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Solar -->
            <div class="card-item bg-white rounded-xl shadow-md p-6 border">
                <h3 class="text-xl font-bold text-gray-800 mb-6">Solar Panel Status</h3>

                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Power Generation</span>
                        <span class="text-green-600 font-bold">{{ $bin['solar_status'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Daily Energy</span>
                        <span class="font-bold">{{ $bin['daily_energy'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Efficiency</span>
                        <span class="font-bold">{{ $bin['efficiency'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Vacuum -->
            <div class="card-item bg-white rounded-xl shadow-md p-6 border">
                <h3 class="text-xl font-bold text-gray-800 mb-6">Vacuum System</h3>

                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Power</span>
                        <span class="text-green-600 font-bold">{{ $bin['solar_status'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Daily Usage</span>
                        <span class="font-bold">{{ $bin['daily_energy'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Efficiency</span>
                        <span class="font-bold">{{ $bin['efficiency'] }}</span>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

@endsection
