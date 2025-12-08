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
        <div class="flex justify-between items-center mb-8 -mt-2">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800">{{ $bin['name'] }}</h1>
                <div class="flex items-center gap-2 text-gray-600 mt-1.5">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="text-sm md:text-base">{{ $bin['location'] }}</span>
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
                        <div class="bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-500"
                                style="width: {{ $bin['battery'] }}%"></div>
                        </div>
                    </div>

                    <span class="text-xl md:text-2xl font-bold text-gray-800 min-w-[50px] text-right">{{ $bin['battery'] }}%</span>
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

            <div class="flex items-center gap-2 mb-6">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                <h3 class="text-xl font-bold text-gray-800">Trash Volume - Last 24 Hours</h3>
            </div>

            <!-- Current Capacity -->
            <div class="bg-blue-50 rounded-xl p-4 md:p-5 mb-6 border border-blue-100">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="text-sm md:text-base font-semibold text-gray-700">Current Capacity</h4>
                    <span class="text-2xl md:text-3xl font-bold text-gray-800">{{ $bin['capacity'] }}%</span>
                </div>

                <div class="bg-gray-200 rounded-full h-2.5">
                    <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-500"
                        style="width: {{ $bin['capacity'] }}%"></div>
                </div>
            </div>

            <h4 class="text-base font-semibold text-gray-700 mb-4">Volume History (Hourly)</h4>

            <!-- Volume History Bars - BAR KECIL-KECIL -->
            <div class="space-y-3">
                <!-- Baris Pertama (8 bar kecil) -->
                <div class="flex gap-2">
                    @php
                        $heights1 = [45, 55, 50, 60, 52, 48, 58, 65];
                    @endphp
                    @for($i = 0; $i < 8; $i++)
                        <div class="flex-1 flex flex-col items-center gap-1.5">
                            <div class="w-full bg-blue-500 rounded-md transition-all hover:bg-blue-600" 
                                 style="height: {{ $heights1[$i] }}px"></div>
                            <span class="text-xs text-gray-600">24h</span>
                        </div>
                    @endfor
                </div>

                <!-- Baris Kedua (8 bar kecil) -->
                <div class="flex gap-2">
                    @php
                        $heights2 = [42, 50, 55, 48, 52, 60, 49, 57];
                    @endphp
                    @for($i = 0; $i < 8; $i++)
                        <div class="flex-1 flex flex-col items-center gap-1.5">
                            <div class="w-full bg-blue-500 rounded-md transition-all hover:bg-blue-600" 
                                 style="height: {{ $heights2[$i] }}px"></div>
                            <span class="text-xs text-gray-600">24h</span>
                        </div>
                    @endfor
                </div>
            </div>

        </div>

        <!-- Solar + Vacuum -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Solar -->
            <div class="card-item bg-white rounded-xl shadow-md p-6 border">
                <div class="flex items-center gap-2 mb-6">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <h3 class="text-xl font-bold text-gray-800">Solar Panel Status</h3>
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Power Generation</span>
                        <span class="text-green-600 font-bold">{{ $bin['solar_status'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Daily Energy</span>
                        <span class="font-bold text-gray-800">{{ $bin['daily_energy'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Efficiency</span>
                        <span class="font-bold text-gray-800">{{ $bin['efficiency'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Vacuum -->
            <div class="card-item bg-white rounded-xl shadow-md p-6 border">
                <div class="flex items-center gap-2 mb-6">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <h3 class="text-xl font-bold text-gray-800">Vacuum System</h3>
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Motor Status</span>
                        <span class="text-green-600 font-bold">Online</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Suction Power</span>
                        <span class="font-bold text-gray-800">92%</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Filter Status</span>
                        <span class="font-bold text-gray-800">Clean</span>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

@endsection