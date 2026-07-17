@extends('admin.layouts.app')

@section('title', __('app.activity_log'))
@section('header_title', __('app.activity_log'))

@section('content')

{{--
    Data dari HistoryController:
    $records  — koleksi HistoryLog (sudah difilter)
    $stats    — array ['total', 'collections', 'maintenance', 'alerts']
    $bins     — daftar bin_id unik untuk dropdown filter
    $dates    — daftar tanggal unik untuk dropdown filter
--}}

<div x-data="historyLogMonitor()" x-init="init()">

    <div class="-mt-4 mb-7">
        <p class="text-[14px] lg:text-[16px] text-[#4a4a4a]">
            {{ __('app.history_description') }}
        </p>
    </div>

    {{-- STAT CARDS — dari $stats controller --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-green-200">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-green-100 rounded-2xl">
                    <i data-lucide="clipboard-list" class="w-8 h-8 text-green-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">{{ __('app.total_records') }}</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $stats['total'] }}</h3>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-green-200">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-green-100 rounded-2xl">
                    <i data-lucide="check-circle" class="w-8 h-8 text-green-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">{{ __('app.sorting_success') }}</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $stats['collections'] }}</h3>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-red-200">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-red-100 rounded-2xl">
                    <i data-lucide="alert-triangle" class="w-8 h-8 text-red-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">{{ __('app.full_bin') }}</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $stats['alerts'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTERS — submit ke controller, bukan Alpine filter --}}
    <form method="GET" action="{{ route('admin.history') }}"
          class="bg-[#f8f8f8] rounded-[22px] p-5 lg:p-6 green-shadow mb-8 border border-[#b9e4b9]">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-[20px] lg:text-[24px] font-bold text-[#4a4a4a]">{{ __('app.filters') }}</h2>
            <a href="{{ route('admin.history') }}" class="text-sm text-green-700 font-semibold hover:underline">
                {{ __('app.reset_filter') }}
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-5">
            <div>
                <label class="block text-sm font-semibold text-[#4a4a4a] mb-2">{{ __('app.status') }}</label>
                <select name="status"
                        class="w-full border-2 border-[#3b6d3b] rounded-xl px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-green-200 focus:outline-none">
                    <option value="all">{{ __('app.all_status') }}</option>
                    <option value="Success" {{ request('status') === 'Success' ? 'selected' : '' }}>
                        {{ __('app.success') }}
                    </option>
                    <option value="Full"    {{ request('status') === 'Full'       ? 'selected' : '' }}>{{ __('app.full') }}</option>
                    
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#4a4a4a] mb-2">{{ __('app.select_bin') }}</label>
                <select name="bin"
                        class="w-full border-2 border-[#3b6d3b] rounded-xl px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-green-200 focus:outline-none">
                    <option value="all">{{ __('app.all_bins') }}</option>
                    @foreach($bins as $bin)
                        <option value="{{ $bin['id'] }}" {{ request('bin') === $bin['id'] ? 'selected' : '' }}>
                            {{ $bin['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#4a4a4a] mb-2">{{ __('app.specific_date') }}</label>
                <input type="date" name="date" value="{{ request('date') }}"
                       class="w-full border-2 border-[#3b6d3b] rounded-xl px-4 py-2 text-sm bg-white focus:outline-none">
            </div>
        </div>

        <div class="mt-5 flex justify-end">
            <button type="submit"
                    class="bg-[#1F4D1F] text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-[#2a6a2a] transition">
                {{ __('app.apply_filter') }}
            </button>
        </div>
    </form>

    {{-- RECORDS TABLE — dari $records controller --}}
    <div class="bg-[#f8f8f8] rounded-[22px] p-5 lg:p-7 green-shadow border border-[#b9e4b9]">
        <h2 class="text-[24px] lg:text-[28px] font-bold text-[#4a4a4a] mb-6">{{ __('app.records') }}</h2>

        <div class="overflow-hidden">
            <table class="w-full border-collapse">
                <thead class="hidden lg:table-header-group">
                    <tr class="border-b-[3px] border-black">
                        <th class="text-left py-4 px-2 text-[16px] font-bold text-[#555]">{{ __('app.date_time') }}</th>
                        <th class="text-left py-4 px-2 text-[16px] font-bold text-[#555]">{{ __('app.bin') }}</th>
                        <th class="text-left py-4 px-2 text-[16px] font-bold text-[#555]">{{ __('app.status') }}</th>
                        <th class="text-left py-4 px-2 text-[16px] font-bold text-[#555]">{{ __('app.message') }}</th>
                        <th class="text-left py-4 px-2 text-[16px] font-bold text-[#555]">{{ __('app.triggered_by') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($records as $record)
                    <tr class="block lg:table-row border-b lg:border-b-[3px] border-gray-200 lg:border-black py-4 lg:py-0">
                        <td class="flex lg:table-cell justify-between py-2 lg:py-4 lg:px-2 text-sm font-semibold text-[#555]">
                            <span class="lg:hidden text-gray-400 font-normal">{{ __('app.date_time') }}</span>
                            <span>{{ $record->created_at?->format('d/m/Y H:i') ?? '-' }}</span>
                        </td>
                        <td class="flex lg:table-cell justify-between py-2 lg:py-4 lg:px-2 text-sm font-semibold text-[#555]">
                            <span class="lg:hidden text-gray-400 font-normal">{{ __('app.bin') }}</span>
                            <span>{{ $record->bin_id }}</span>
                        </td>
                        <td class="flex lg:table-cell justify-between py-2 lg:py-4 lg:px-2 text-sm font-semibold">

    <span class="lg:hidden text-gray-400 font-normal">
        {{ __('app.status') }}
    </span>

    <span @class([
        'text-green-600 font-bold' => $record->status === 'Success',
        'text-red-600 font-bold' => $record->status === 'Full',
        'text-orange-500 font-bold' => $record->status === 'Maintenance',
        'text-gray-600 font-bold' => !in_array($record->status, ['Success','Full','Maintenance']),
    ])>
        {{ $record->status }}
    </span>

</td>
                        <td class="flex lg:table-cell justify-between py-2 lg:py-4 lg:px-2 text-sm font-semibold text-[#555] italic">
                            <span class="lg:hidden text-gray-400 font-normal">{{ __('app.message') }}</span>
                            <span>{{ $record->message ?? '-' }}</span>
                        </td>
                        <td class="flex lg:table-cell justify-between py-2 lg:py-4 lg:px-2 text-sm font-semibold text-[#555]">
                            <span class="lg:hidden text-gray-400 font-normal">{{ __('app.triggered_by') }}</span>
                            <span class="capitalize">{{ $record->triggered_by ?? 'system' }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-20 text-center">
                            <i data-lucide="search-x" class="w-16 h-16 mx-auto text-gray-300 mb-4"></i>
                            <p class="text-gray-500 font-medium text-lg">{{ __('app.no_records_found_matching') }}</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($records->hasPages())
        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mt-6 pt-4 border-t border-[#b9e4b9]">
            <p class="text-sm text-gray-500">
                {{ __('app.showing_results', ['from' => $records->firstItem(), 'to' => $records->lastItem(), 'total' => $records->total()]) }}
            </p>
            {{ $records->links('vendor.pagination.custom') }}
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('historyLogMonitor', () => ({
        init() {
            // Filter sekarang ditangani server-side via form GET
            // Alpine hanya untuk UI interaktif ringan jika diperlukan
        }
    }));
});
</script>

@endsection