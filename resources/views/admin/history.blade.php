@extends('admin.layouts.app')

@section('title', 'History - Smart Waste Monitor')

@section('content')
<div class="min-h-screen bg-gray-50 px-6 py-6">
    <div class="max-w-[1400px] mx-auto">

        <!-- Header -->
        <div class="flex justify-between items-start mb-8">
            <div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">History Log Monitor</h1>
                <p class="text-lg text-gray-600">Waste collection and maintenance records</p>
            </div>

            <!-- TOMBOL REFRESH -->
            <button onclick="location.reload()" 
                class="flex items-center space-x-2 bg-blue-100 text-blue-700 px-4 py-2 rounded-lg font-medium hover:bg-blue-200 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span>Refresh</span>
            </button>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-200 to-blue-100 rounded-2xl p-6 text-center shadow">
                <h2 class="text-3xl font-bold text-gray-800">{{ $stats['total'] }}</h2>
                <p class="text-gray-700 mt-1">Total Records</p>
            </div>
            <div class="bg-gradient-to-br from-green-200 to-green-100 rounded-2xl p-6 text-center shadow">
                <h2 class="text-3xl font-bold text-gray-800">{{ $stats['collections'] }}</h2>
                <p class="text-gray-700 mt-1">Collections</p>
            </div>
            <div class="bg-gradient-to-br from-yellow-200 to-yellow-100 rounded-2xl p-6 text-center shadow">
                <h2 class="text-3xl font-bold text-gray-800">{{ $stats['maintenance'] }}</h2>
                <p class="text-gray-700 mt-1">Maintenance</p>
            </div>
            <div class="bg-gradient-to-br from-red-200 to-red-100 rounded-2xl p-6 text-center shadow">
                <h2 class="text-3xl font-bold text-gray-800">{{ $stats['alerts'] }}</h2>
                <p class="text-gray-700 mt-1">Alerts</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-2xl p-6 shadow mb-8">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Filters</h3>
            <form id="filterForm" method="GET" action="{{ route('admin.history') }}" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">Status</label>
                    <select name="status" onchange="submitFilter()" class="w-full border-2 border-gray-200 rounded-lg p-2 focus:border-blue-500">
                        <option value="all">All Status</option>
                        <option value="Empetied" {{ request('status') == 'Empetied' ? 'selected' : '' }}>Empetied</option>
                        <option value="Full" {{ request('status') == 'Full' ? 'selected' : '' }}>Full</option>
                        <option value="Battery Low" {{ request('status') == 'Battery Low' ? 'selected' : '' }}>Battery Low</option>
                        <option value="Alert" {{ request('status') == 'Alert' ? 'selected' : '' }}>Alert</option>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">Bin</label>
                    <select name="bin" onchange="submitFilter()" class="w-full border-2 border-gray-200 rounded-lg p-2 focus:border-blue-500">
                        <option value="all">All Bins</option>
                        @foreach($bins as $bin)
                            <option value="{{ $bin }}" {{ request('bin') == $bin ? 'selected' : '' }}>{{ $bin }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">Date Range</label>
                    <select name="date" onchange="submitFilter()" class="w-full border-2 border-gray-200 rounded-lg p-2 focus:border-blue-500">
                        <option value="">All Dates</option>
                        @foreach($dates as $date)
                            <option value="{{ $date }}" {{ request('date') == $date ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::parse($date)->format('d-M-Y') }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <!-- Records Table -->
        <div class="bg-white rounded-2xl p-6 shadow">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Records</h3>
            <div class="overflow-x-auto">
                @if($records->count() > 0)
                    <table class="w-full border-collapse">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="text-left p-3 font-semibold text-gray-700 border-b-2 border-gray-200">Date</th>
                                <th class="text-left p-3 font-semibold text-gray-700 border-b-2 border-gray-200">Time</th>
                                <th class="text-left p-3 font-semibold text-gray-700 border-b-2 border-gray-200">Bin</th>
                                <th class="text-left p-3 font-semibold text-gray-700 border-b-2 border-gray-200">Status</th>
                                <th class="text-left p-3 font-semibold text-gray-700 border-b-2 border-gray-200">Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($records as $record)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3">{{ \Carbon\Carbon::parse($record->date)->format('d/m/Y') }}</td>
                                    <td class="p-3">{{ \Carbon\Carbon::parse($record->time)->format('H:i') }}</td>
                                    <td class="p-3">{{ $record->bin }}</td>
                                    <td class="p-3">
                                        <span class="px-3 py-1 rounded-full font-semibold text-sm
                                            {{ strtolower(str_replace(' ', '-', $record->status)) == 'empetied' ? 'bg-green-200 text-green-800' : '' }}
                                            {{ strtolower(str_replace(' ', '-', $record->status)) == 'full' ? 'bg-yellow-200 text-yellow-800' : '' }}
                                            {{ strtolower(str_replace(' ', '-', $record->status)) == 'battery-low' ? 'bg-yellow-100 text-orange-700' : '' }}
                                            {{ strtolower(str_replace(' ', '-', $record->status)) == 'alert' ? 'bg-red-200 text-red-800' : '' }}
                                        ">
                                            {{ $record->status }}
                                        </span>
                                    </td>
                                    <td class="p-3">{{ $record->notes }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center text-gray-500 py-10">
                        No records found with the selected filters.
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

<script>
    function submitFilter() {
        document.getElementById('filterForm').submit();
    }
</script>
@endsection
