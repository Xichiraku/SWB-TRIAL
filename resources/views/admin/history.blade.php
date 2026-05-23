@extends('admin.layouts.app')

@section('title', 'Activity Log')
@section('header_title', 'Activity Log')

@section('content')

<div x-data="historyLogMonitor()">

    <div class="-mt-4 mb-7">
        <p class="text-[14px] lg:text-[16px] text-[#4a4a4a]">
            Waste collection and maintenance records
        </p>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-4 mb-8">
        <div class="bg-[#9AD18B] rounded-2xl p-4 lg:p-6 text-center main-shadow">
            <h2 class="text-3xl lg:text-5xl font-bold text-[#4a4a4a]" x-text="allRecords.length"></h2>
            <p class="text-xs lg:text-[16px] text-[#4a4a4a] mt-1 font-medium">Total Records</p>
        </div>

        <div class="bg-[#BFE3BF] rounded-2xl p-4 lg:p-6 text-center main-shadow">
            <h2 class="text-3xl lg:text-5xl font-bold text-[#4a4a4a]" x-text="countByStatus('Empetied')"></h2>
            <p class="text-xs lg:text-[16px] text-[#4a4a4a] mt-1 font-medium">Collection</p>
        </div>

        <div class="bg-[#EFE7BE] rounded-2xl p-4 lg:p-6 text-center main-shadow">
            <h2 class="text-3xl lg:text-5xl font-bold text-[#4a4a4a]" x-text="countMaintenance()"></h2>
            <p class="text-xs lg:text-[16px] text-[#4a4a4a] mt-1 font-medium">Maintenance</p>
        </div>

        <div class="bg-[#EECFD1] rounded-2xl p-4 lg:p-6 text-center main-shadow">
            <h2 class="text-3xl lg:text-5xl font-bold text-[#4a4a4a]" x-text="countByStatus('Alert')"></h2>
            <p class="text-xs lg:text-[16px] text-[#4a4a4a] mt-1 font-medium">Alert</p>
        </div>
    </div>

    <div class="bg-[#f8f8f8] rounded-[22px] p-5 lg:p-6 green-shadow mb-8 border border-[#b9e4b9]">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-[20px] lg:text-[24px] font-bold text-[#4a4a4a]">Filters</h2>
            <button @click="resetFilters()" class="text-sm text-green-700 font-semibold hover:underline">Reset Filter</button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-5">
            <div>
                <label class="block text-sm font-semibold text-[#4a4a4a] mb-2">Status</label>
                <select x-model="statusFilter"
                        class="w-full border-2 border-[#3b6d3b] rounded-xl px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-green-200 focus:outline-none">
                    <option value="">All Status</option>
                    <option value="Empetied">Empetied</option>
                    <option value="Full">Full</option>
                    <option value="Battery Low">Battery Low</option>
                    <option value="Alert">Alert</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#4a4a4a] mb-2">Select Bin</label>
                <select x-model="binFilter"
                        class="w-full border-2 border-[#3b6d3b] rounded-xl px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-green-200 focus:outline-none">
                    <option value="">All Bins</option>
                    <option value="Bin #001">Bin #001</option>
                    <option value="Bin #002">Bin #002</option>
                    <option value="Bin #003">Bin #003</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#4a4a4a] mb-2">Specific Date</label>
                <input type="date" x-model="dateFilter"
                       class="w-full border-2 border-[#3b6d3b] rounded-xl px-4 py-2 text-sm bg-white focus:outline-none">
            </div>
        </div>
    </div>

    <div class="bg-[#f8f8f8] rounded-[22px] p-5 lg:p-7 green-shadow border border-[#b9e4b9]">
        <h2 class="text-[24px] lg:text-[28px] font-bold text-[#4a4a4a] mb-6">Records</h2>

        <div class="overflow-hidden">
            <table class="w-full border-collapse">
                <thead class="hidden lg:table-header-group">
                    <tr class="border-b-[3px] border-black">
                        <th class="text-left py-4 px-2 text-[16px] font-bold text-[#555]">Date</th>
                        <th class="text-left py-4 px-2 text-[16px] font-bold text-[#555]">Time</th>
                        <th class="text-left py-4 px-2 text-[16px] font-bold text-[#555]">Bin</th>
                        <th class="text-left py-4 px-2 text-[16px] font-bold text-[#555]">Status</th>
                        <th class="text-left py-4 px-2 text-[16px] font-bold text-[#555]">Notes</th>
                    </tr>
                </thead>

                <tbody class="block lg:table-row-group">
                    <template x-for="(record, index) in filteredRecords" :key="index">
                        <tr class="block lg:table-row border-b lg:border-b-[3px] border-gray-200 lg:border-black py-4 lg:py-0">
                            <td class="flex lg:table-cell justify-between py-2 lg:py-4 lg:px-2 text-sm font-semibold text-[#555]">
                                <span class="lg:hidden text-gray-400 font-normal">Date</span>
                                <span x-text="record.date"></span>
                            </td>
                            <td class="flex lg:table-cell justify-between py-2 lg:py-4 lg:px-2 text-sm font-semibold text-[#555]">
                                <span class="lg:hidden text-gray-400 font-normal">Time</span>
                                <span x-text="record.time"></span>
                            </td>
                            <td class="flex lg:table-cell justify-between py-2 lg:py-4 lg:px-2 text-sm font-semibold text-[#555]">
                                <span class="lg:hidden text-gray-400 font-normal">Bin No</span>
                                <span x-text="record.bin"></span>
                            </td>
                            <td class="flex lg:table-cell justify-between py-2 lg:py-4 lg:px-2 text-sm font-semibold">
                                <span class="lg:hidden text-gray-400 font-normal">Status</span>
                                <span :class="{
                                    'text-green-600': record.status === 'Empetied',
                                    'text-red-600': record.status === 'Alert',
                                    'text-orange-500': record.status === 'Battery Low',
                                    'text-blue-600': record.status === 'Full'
                                }" x-text="record.status"></span>
                            </td>
                            <td class="flex lg:table-cell justify-between py-2 lg:py-4 lg:px-2 text-sm font-semibold text-[#555] italic">
                                <span class="lg:hidden text-gray-400 font-normal">Notes</span>
                                <span x-text="record.notes"></span>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>

            <template x-if="filteredRecords.length === 0">
                <div class="py-20 text-center">
                    <i data-lucide="search-x" class="w-16 h-16 mx-auto text-gray-300 mb-4"></i>
                    <p class="text-gray-500 font-medium text-lg">No records found matching your filters.</p>
                </div>
            </template>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('historyLogMonitor', () => ({
        statusFilter: '',
        binFilter: '',
        dateFilter: '',

        allRecords: [
            { date: '2025-09-30', time: '13.30', bin: 'Bin #001', status: 'Empetied', notes: 'Regular Collection' },
            { date: '2025-09-30', time: '09.52', bin: 'Bin #001', status: 'Battery Low', notes: 'Solar panel efficiency below 20%' },
            { date: '2025-09-30', time: '16.47', bin: 'Bin #001', status: 'Alert', notes: 'Capacity reached 90%' },
            { date: '2025-10-01', time: '10.20', bin: 'Bin #002', status: 'Full', notes: 'Needs immediate pickup' },
        ],

        // LOGIKA FILTERING (Computed)
        get filteredRecords() {
            return this.allRecords.filter(record => {
                const matchStatus = this.statusFilter === '' || record.status === this.statusFilter;
                const matchBin = this.binFilter === '' || record.bin === this.binFilter;
                const matchDate = this.dateFilter === '' || record.date === this.dateFilter;
                return matchStatus && matchBin && matchDate;
            });
        },

        countByStatus(status) {
            return this.allRecords.filter(r => r.status === status).length;
        },

        countMaintenance() {
            return this.allRecords.filter(r => r.status === 'Battery Low').length;
        },

        resetFilters() {
            this.statusFilter = '';
            this.binFilter = '';
            this.dateFilter = '';
        }
    }));
});
</script>

@endsection