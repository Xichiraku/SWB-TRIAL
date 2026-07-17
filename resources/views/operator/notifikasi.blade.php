@extends('operator.layout')
@section('title', 'Notifikasi')

@section('content')
<div class="w-full max-w-7xl space-y-6">
    <div class="bg-white rounded-[25px] p-8 border border-green-100 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4 w-full">
        <div class="flex items-center gap-5 text-center md:text-left">
            <div class="flex items-center justify-center rounded-2xl bg-green-50 p-3 text-[#1F4D1F]">
                <i data-lucide="bell-ring" class="w-8 h-8"></i>
            </div>
            <div>
                <h1 class="text-2xl lg:text-3xl font-black text-[#1F4D1F]">Pusat Notifikasi</h1>
                <p class="text-slate-500 font-medium">Informasi terbaru dari sistem dan admin.</p>
            </div>
        </div>
        <div class="px-6 py-2 border-2 border-slate-800 rounded-full font-bold text-slate-800 bg-white">
            {{ now()->translatedFormat('l, d F Y') }}
        </div>
    </div>

    <div class="bg-white rounded-[30px] p-6 lg:p-10 shadow-sm border border-green-200 w-full">
        <div class="space-y-4 max-w-5xl mx-auto">
           @forelse($notifications as $bin)

<div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">

    <div class="flex justify-between items-start">

        <div>

            @if($bin->sensor_error)

                <h3 class="font-bold text-red-600">
                    Maintenance Required
                </h3>

                <p class="text-slate-600 mt-2">
                    {{ $bin->name }} mengalami masalah pada sensor HC-SR04.
                </p>

            @elseif($bin->capacity >= 90)

                <h3 class="font-bold text-red-600">
                    Bin Full
                </h3>

                <p class="text-slate-600 mt-2">
                    {{ $bin->name }} telah mencapai
                    <b>{{ $bin->capacity }}%</b>.
                    Segera lakukan pengosongan.
                </p>

            @elseif($bin->capacity >= 75)

                <h3 class="font-bold text-yellow-600">
                    Bin Warning
                </h3>

                <p class="text-slate-600 mt-2">
                    {{ $bin->name }} telah mencapai
                    <b>{{ $bin->capacity }}%</b>.
                    Pantau kondisi tong.
                </p>

            @endif

            <p class="text-xs text-slate-400 mt-3">

                {{ $bin->updated_at?->diffForHumans() }}

            </p>
            <div class="mt-5">

                <a href="{{ route('operator.taskupdate') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl text-sm font-semibold transition">

                    <i data-lucide="clipboard-list" class="w-4 h-4"></i>

                    View Task

                </a>

            </div>
        </div>

        <div>

            @if($bin->sensor_error)

                <i data-lucide="wrench" class="w-8 h-8 text-red-500"></i>

            @else

                <i data-lucide="trash-2" class="w-8 h-8 text-orange-500"></i>

            @endif

        </div>

    </div>

</div>

@empty

<div class="text-center py-20">

    <i data-lucide="bell-off" class="w-14 h-14 mx-auto text-slate-300"></i>

    <p class="mt-4 text-slate-500">

        No notifications.

    </p>

</div>

@endforelse
     </div>
    </div>
</div>
@endsection