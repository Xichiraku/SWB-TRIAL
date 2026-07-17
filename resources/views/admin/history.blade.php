@extends('admin.layouts.app')

@section('title', 'Activity Log')
@section('header_title', 'Activity Log')

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
            Waste collection and maintenance records
        </p>
    </div>

    {{-- STAT CARDS — dari $stats controller --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-4 mb-8">
        <div class="bg-[#9AD18B] rounded-2xl p-4 lg:p-6 text-center main-shadow">
            <h2 class="text-3xl lg:text-5xl font-bold text-[#4a4a4a]">{{ $stats['total'] }}</h2>
            <p class="text-xs lg:text-[16px] text-[#4a4a4a] mt-1 font-medium">Total Records</p>
        </div>
        <div class="bg-[#BFE3BF] rounded-2xl p-4 lg:p-6 text-center main-shadow">
            <h2 class="text-3xl lg:text-5xl font-bold text-[#4a4a4a]">{{ $stats['collections'] }}</h2>
            <p class="text-xs lg:text-[16px] text-[#4a4a4a] mt-1 font-medium">Sorting Success</p>
        </div>
        <div class="bg-[#EFE7BE] rounded-2xl p-4 lg:p-6 text-center main-shadow">
            <h2 class="text-3xl lg:text-5xl font-bold text-[#4a4a4a]">{{ $stats['maintenance'] }}</h2>
            <p class="text-xs lg:text-[16px] text-[#4a4a4a] mt-1 font-medium">Maintenance</p>
        </div>
        <div class="bg-[#EECFD1] rounded-2xl p-4 lg:p-6 text-center main-shadow">
            <h2 class="text-3xl lg:text-5xl font-bold text-[#4a4a4a]">{{ $stats['alerts'] }}</h2>
            <p class="text-xs lg:text-[16px] text-[#4a4a4a] mt-1 font-medium">Full BIn</p>
        </div>
    </div>

    {{-- FILTERS — submit ke controller, bukan Alpine filter --}}
    <form method="GET" action="{{ route('admin.history') }}"
          class="bg-[#f8f8f8] rounded-[22px] p-5 lg:p-6 green-shadow mb-8 border border-[#b9e4b9]">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-[20px] lg:text-[24px] font-bold text-[#4a4a4a]">Filters</h2>
            <a href="{{ route('admin.history') }}" class="text-sm text-green-700 font-semibold hover:underline">
                Reset Filter
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-5">
            <div>
                <label class="block text-sm font-semibold text-[#4a4a4a] mb-2">Status</label>
                <select name="status"
                        class="w-full border-2 border-[#3b6d3b] rounded-xl px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-green-200 focus:outline-none">
                    <option value="all">All Status</option>
                    <option value="Success" {{ request('status') === 'Success' ? 'selected' : '' }}>
                        Success
                    </option>
                    <option value="Maintenance" {{ request('status') === 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="Full"    {{ request('status') === 'Full'       ? 'selected' : '' }}>Full</option>
                    
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#4a4a4a] mb-2">Select Bin</label>
                <select name="bin"
                        class="w-full border-2 border-[#3b6d3b] rounded-xl px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-green-200 focus:outline-none">
                    <option value="all">All Bins</option>
                    @foreach($bins as $bin)
                        <option value="{{ $bin['id'] }}" {{ request('bin') === $bin['id'] ? 'selected' : '' }}>
                            {{ $bin['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#4a4a4a] mb-2">Specific Date</label>
                <input type="date" name="date" value="{{ request('date') }}"
                       class="w-full border-2 border-[#3b6d3b] rounded-xl px-4 py-2 text-sm bg-white focus:outline-none">
            </div>
        </div>

        <div class="mt-5 flex justify-end">
            <button type="submit"
                    class="bg-[#1F4D1F] text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-[#2a6a2a] transition">
                Apply Filter
            </button>
        </div>
    </form>

    {{-- RECORDS TABLE — dari $records controller --}}
    <div class="bg-[#f8f8f8] rounded-[22px] p-5 lg:p-7 green-shadow border border-[#b9e4b9]">
        <h2 class="text-[24px] lg:text-[28px] font-bold text-[#4a4a4a] mb-6">Records</h2>

        <div class="overflow-hidden">
            <table class="w-full border-collapse">
                <thead class="hidden lg:table-header-group">
                    <tr class="border-b-[3px] border-black">
                        <th class="text-left py-4 px-2 text-[16px] font-bold text-[#555]">Date & Time</th>
                        <th class="text-left py-4 px-2 text-[16px] font-bold text-[#555]">Bin</th>
                        <th class="text-left py-4 px-2 text-[16px] font-bold text-[#555]">Status</th>
                        <th class="text-left py-4 px-2 text-[16px] font-bold text-[#555]">Message</th>
                        <th class="text-left py-4 px-2 text-[16px] font-bold text-[#555]">Triggered By</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($records as $record)
                    <tr class="block lg:table-row border-b lg:border-b-[3px] border-gray-200 lg:border-black py-4 lg:py-0">
                        <td class="flex lg:table-cell justify-between py-2 lg:py-4 lg:px-2 text-sm font-semibold text-[#555]">
                            <span class="lg:hidden text-gray-400 font-normal">Date & Time</span>
                            <span>{{ $record->created_at?->format('d/m/Y H:i') ?? '-' }}</span>
                        </td>
                        <td class="flex lg:table-cell justify-between py-2 lg:py-4 lg:px-2 text-sm font-semibold text-[#555]">
                            <span class="lg:hidden text-gray-400 font-normal">Bin</span>
                            <span>{{ $record->bin_id }}</span>
                        </td>
                        <td class="flex lg:table-cell justify-between py-2 lg:py-4 lg:px-2 text-sm font-semibold">

    <span class="lg:hidden text-gray-400 font-normal">
        Status
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
                            <span class="lg:hidden text-gray-400 font-normal">Message</span>
                            <span>{{ $record->message ?? '-' }}</span>
                        </td>
                        <td class="flex lg:table-cell justify-between py-2 lg:py-4 lg:px-2 text-sm font-semibold text-[#555]">
                            <span class="lg:hidden text-gray-400 font-normal">Triggered By</span>
                            <span class="capitalize">{{ $record->triggered_by ?? 'system' }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-20 text-center">
                            <i data-lucide="search-x" class="w-16 h-16 mx-auto text-gray-300 mb-4"></i>
                            <p class="text-gray-500 font-medium text-lg">No records found matching your filters.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($records->hasPages())
        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mt-6 pt-4 border-t border-[#b9e4b9]">
            <p class="text-sm text-gray-500">
                Showing {{ $records->firstItem() }} to {{ $records->lastItem() }} of {{ $records->total() }} results
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