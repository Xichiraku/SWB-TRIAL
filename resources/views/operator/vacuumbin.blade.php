@extends('operator.layout')

@section('title', 'Vacuum Bins')

@section('content')

<!-- Wrapper supaya konten ga nutup welcome -->
<div class="relative z-0 mt-6">

    <!-- Vacuum Bin Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        @foreach ($vacuums as $vacuum)
        <div
            class="bg-white rounded-2xl border-2 p-6 shadow-sm transition hover:shadow-md
            {{ $vacuum->capacity >= 90 ? 'border-blue-500' : 'border-blue-300' }}">

            <!-- Header -->
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-lg font-bold flex items-center gap-2">
                        🗑️ {{ $vacuum->name }}
                    </h3>
                    <p class="text-sm text-gray-500 flex items-center gap-1 mt-1">
                        📍 {{ $vacuum->location }}
                    </p>
                </div>

                <!-- Status -->
                <span
                    class="px-4 py-1 rounded-full text-sm font-semibold
                    {{ $vacuum->capacity >= 90
                        ? 'bg-red-500 text-white'
                        : 'bg-gray-200 text-gray-700' }}">
                    {{ $vacuum->capacity >= 90 ? 'Full' : 'Normal' }}
                </span>
            </div>

            <!-- Kapasitas Sampah -->
            <div class="mb-4">
                <div class="flex justify-between text-sm mb-1">
                    <span class="font-medium text-gray-700">Kapasitas Sampah</span>
                    <span class="font-semibold">{{ $vacuum->capacity }}%</span>
                </div>

                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div
                        class="h-3 rounded-full
                        {{ $vacuum->capacity >= 90 ? 'bg-blue-800' : 'bg-blue-700' }}"
                        style="width: {{ $vacuum->capacity }}%">
                    </div>
                </div>

                @if ($vacuum->capacity >= 90)
                <p class="mt-1 text-sm font-medium text-red-600">
                    Segera Kosongkan!
                </p>
                @endif
            </div>

            <!-- Baterai -->
            <div class="mb-4">
                <div class="flex justify-between text-sm mb-1">
                    <span class="font-medium text-gray-700">🔋 Baterai Solar</span>
                    <span class="font-semibold">{{ $vacuum->battery }}%</span>
                </div>

                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div
                        class="h-3 rounded-full bg-blue-700"
                        style="width: {{ $vacuum->battery }}%">
                    </div>
                </div>

                @if ($vacuum->battery <= 40)
                <p class="mt-1 text-sm text-red-600">
                    Baterai rendah – periksa panel solar
                </p>
                @endif
            </div>

            <hr class="my-4 border-blue-200">

            <!-- Info -->
            <div class="space-y-2 text-sm text-gray-700">
                <div class="flex justify-between">
                    <span>ID Vacuum</span>
                    <span class="font-semibold">{{ $vacuum->code }}</span>
                </div>

                <div class="flex justify-between">
                    <span>Update Terakhir</span>
                    <span class="font-semibold">
                        {{ $vacuum->updated_at->format('Y-m-d H:i') }}
                    </span>
                </div>

                <div class="flex justify-between items-center">
                    <span>Koneksi</span>

                    <span class="flex items-center gap-2 font-semibold text-green-600">
                        <!-- WiFi Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-5 h-5"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M8.53 16.11a6 6 0 016.94 0
                                     M5.1 12.69a10 10 0 0113.8 0
                                     M1.42 9.01a14 14 0 0119.16 0
                                     M12 20h.01"/>
                        </svg>
                        Online
                    </span>
                </div>
            </div>

        </div>
        @endforeach

    </div>
</div>

@endsection
