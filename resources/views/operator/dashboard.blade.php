@extends('operator.layout')

@section('title', 'Dashboard Operator')

@section('content')

<!-- Peringatan Penting -->
<div class="bg-red-50 border-2 border-red-400 rounded-2xl p-6 mb-12">
    <h2 class="text-xl font-bold text-red-600 mb-6 flex items-center gap-2">
        ⚠️ Peringatan Penting
    </h2>

    <div class="space-y-6">
        @foreach($warnings as $warning)
        <div
            class="bg-white rounded-xl p-5 border-l-4 border-red-500 shadow-sm
                   transition duration-200
                   hover:bg-red-100 hover:border-red-600 hover:shadow-md">
            <h3 class="font-bold text-gray-900 mb-1">
                {{ $warning['title'] }}
            </h3>
            <p class="text-sm text-gray-700">
                {{ $warning['message'] }}
            </p>
        </div>
        @endforeach
    </div>
</div>

<!-- Status Homebase -->
<div class="bg-white rounded-2xl shadow-sm border border-blue-200 p-6">
    <h2 class="text-xl font-bold text-gray-900 mb-5">
        🏠 Status Homebase
    </h2>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @foreach($homebases as $homebase)
        <div class="rounded-xl border-2 border-blue-300 p-5 shadow-sm
                    transition hover:bg-blue-50 hover:border-blue-500">

            <div class="flex justify-between">
                <div>
                    <h3 class="font-semibold text-lg">
                        {{ $homebase['name'] }}
                    </h3>
                    <p class="text-sm text-gray-500">
                        📍 {{ $homebase['location'] }}
                    </p>
                </div>

                <span class="text-green-600 font-medium">
                    ● {{ $homebase['status'] }}
                </span>
            </div>

            <hr class="my-4 border-blue-200">

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">Vacuum Assigned</p>
                    <p class="text-xl font-bold text-blue-600">
                        {{ $homebase['vacuum_assigned'] }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">Active</p>
                    <p class="text-xl font-bold text-green-600">
                        {{ $homebase['active'] }}
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
