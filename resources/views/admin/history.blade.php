@extends('admin.layouts.app')

@section('title', __('app.history'))

@section('page_title')
<div class="flex flex-col">
    <h1 class="text-3xl font-bold text-gray-800 leading-tight">
        {{ __('app.collection_history') }}
    </h1>
    <p class="text-gray-600 mt-1 text-base leading-snug">
        {{ __('app.loading_bins') }}
    </p>
</div>
@endsection

@section('content')
<div class="min-h-screen px-4 sm:px-6 lg:px-8 py-6">

    {{-- STATS --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl p-6 text-center">
            <p class="text-5xl font-bold text-white">{{ $stats['total'] }}</p>
            <p class="text-sm text-blue-50 mt-1">{{ __('app.total_bins') }}</p>
        </div>

        <div class="bg-gradient-to-br from-teal-500 to-emerald-600 rounded-2xl p-6 text-center">
            <p class="text-5xl font-bold text-white">{{ $stats['collections'] }}</p>
            <p class="text-sm text-teal-50 mt-1">{{ __('app.collection_history') }}</p>
        </div>

        <div class="bg-gradient-to-br from-orange-400 to-amber-500 rounded-2xl p-6 text-center">
            <p class="text-5xl font-bold text-white">{{ $stats['maintenance'] }}</p>
            <p class="text-sm text-orange-50 mt-1">{{ __('app.maintenance') }}</p>
        </div>

        <div class="bg-gradient-to-br from-pink-500 to-rose-600 rounded-2xl p-6 text-center">
            <p class="text-5xl font-bold text-white">{{ $stats['alerts'] }}</p>
            <p class="text-sm text-pink-50 mt-1">{{ __('app.alert_types') }}</p>
        </div>
    </div>

    {{-- EXPORT --}}
    <div class="bg-white rounded-xl border shadow-sm mb-6 p-5">
        <div class="flex justify-between items-center mb-3">
            <h3 class="text-sm font-bold text-gray-800">{{ __('app.action') }}</h3>
            <p class="text-xs text-gray-500">PDF</p>
        </div>

        <button
            type="button"
            onclick="exportVacuum()"
            class="flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2.5 rounded-lg font-semibold text-sm transition hover:scale-105">
            Export Vacuum
        </button>
    </div>

    {{-- FILTER --}}
    <form method="GET" class="bg-white rounded-xl border shadow-sm mb-6 p-5">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

            <div>
                <label class="text-xs font-medium text-gray-600 mb-1 block">
                    {{ __('app.filter_by_status') }}
                </label>
                <select name="status" class="w-full px-3 py-2.5 text-sm border rounded-lg">
                    <option value="">{{ __('app.all') }}</option>
                    <option value="Empetied">Empetied</option>
                    <option value="Full">Full</option>
                    <option value="Battery Low">Battery Low</option>
                    <option value="Alert">Alert</option>
                </select>
            </div>

            <div>
                <label class="text-xs font-medium text-gray-600 mb-1 block">
                    {{ __('app.bin_location') }}
                </label>
                <select name="bin" class="w-full px-3 py-2.5 text-sm border rounded-lg">
                    <option value="">{{ __('app.all') }}</option>
                    @foreach ($bins as $bin)
                        <option value="{{ $bin }}">{{ $bin }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-xs font-medium text-gray-600 mb-1 block">
                    {{ __('app.date') }}
                </label>
                <input type="date" name="date"
                    class="w-full px-3 py-2.5 text-sm border rounded-lg">
            </div>

        </div>

        <div class="mt-4 text-right">
            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
                {{ __('app.search') }}
            </button>
        </div>
    </form>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl border shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3 text-center">{{ __('app.date') }}</th>
                    <th class="px-4 py-3 text-center">Time</th>
                    <th class="px-4 py-3 text-center">{{ __('app.bin_location') }}</th>
                    <th class="px-4 py-3 text-center">{{ __('app.status') }}</th>
                    <th class="px-4 py-3 text-left">Notes</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($records as $record)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2 text-center">
                            {{ \Carbon\Carbon::parse($record->date)->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-2 text-center">{{ $record->time }}</td>
                        <td class="px-4 py-2 text-center">{{ $record->bin }}</td>
                        <td class="px-4 py-2 text-center">{{ $record->status }}</td>
                        <td class="px-4 py-2">{{ $record->notes }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-10 text-center text-gray-500">
                            {{ __('app.no_bins_found') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<script>
function exportVacuum() {
    const now = new Date();
    const month = now.getMonth() + 1;
    const year = now.getFullYear();
    window.location.href = `/admin/export/vacuum?month=${month}&year=${year}`;
}
</script>
@endsection