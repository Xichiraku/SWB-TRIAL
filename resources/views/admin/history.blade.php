@extends('admin.layouts.app')

@section('title', 'History Log')

{{-- TITLE UNTUK HEADER KANAN --}}
@section('page_title')
<div class="flex flex-col">
    <h1 class="text-3xl font-bold text-gray-800 leading-tight">
        History Log Monitor
    </h1>

    <p class="text-gray-600 mt-1 text-base leading-snug">
        Waste collection and maintenance records
    </p>
</div>
@endsection

@section('content')
<div x-data="historyLogMonitor()" class="min-h-screen px-4 sm:px-6 lg:px-8 py-6">

    {{-- STATS --}}
    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">

        {{-- Total --}}
        <div class="bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl p-5 sm:p-6 text-center hover:shadow-lg transition hover:-translate-y-1">
            <p class="text-4xl sm:text-5xl font-bold text-white" x-text="allRecords.length"></p>
            <p class="text-xs sm:text-sm text-blue-50 mt-1">Total Records</p>
        </div>

        {{-- Collections --}}
        <div class="bg-gradient-to-br from-teal-500 to-emerald-600 rounded-2xl p-5 sm:p-6 text-center hover:shadow-lg transition hover:-translate-y-1">
            <p class="text-4xl sm:text-5xl font-bold text-white" x-text="countByStatus('Empetied')"></p>
            <p class="text-xs sm:text-sm text-teal-50 mt-1">Normal</p>
        </div>

        {{-- Maintenance --}}
        <div class="bg-gradient-to-br from-orange-400 to-amber-500 rounded-2xl p-5 sm:p-6 text-center hover:shadow-lg transition hover:-translate-y-1">
            <p class="text-4xl sm:text-5xl font-bold text-white" x-text="countMaintenance()"></p>
            <p class="text-xs sm:text-sm text-orange-50 mt-1">Maintenance</p>
        </div>

        {{-- Alerts --}}
        <div class="bg-gradient-to-br from-pink-500 to-rose-600 rounded-2xl p-5 sm:p-6 text-center hover:shadow-lg transition hover:-translate-y-1">
            <p class="text-4xl sm:text-5xl font-bold text-white" x-text="countByStatus('Alert')"></p>
            <p class="text-xs sm:text-sm text-pink-50 mt-1">Full</p>
        </div>

    </div>

    {{-- FILTER CARD --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm mb-6">

        <div class="p-4 sm:p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-gray-800">Filters</h3>

                {{-- RESET BUTTON --}}
                <button @click="handleResetFilter()"
                    class="flex items-center gap-2 text-xs font-medium text-gray-600 px-3 py-1.5 
                           hover:bg-gray-100 hover:text-gray-800 transition">

                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.6m15.4 2A8 8 0 004.6 9m0 
                               0H9m11 11v-5h-.6m0 0a8 8 0 01-15.4-2m15.4 
                               2H15" />
                    </svg>

                    Reset All
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                {{-- STATUS --}}
                <div>
                    <label class="text-xs font-medium text-gray-600 mb-1 block">Status</label>
                    <select x-model="statusFilter"
                        class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-blue-400">
                        <option value="">All Status</option>
                        <option>Empetied</option>
                        <option>Full</option>
                        <option>Battery Low</option>
                    </select>
                </div>

                {{-- BIN --}}
                <div>
                    <label class="text-xs font-medium text-gray-600 mb-1 block">Bin</label>
                    <select x-model="binFilter"
                        class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-blue-400">
                        <option value="">All Bins</option>
                        <option>Bin #001</option>
                        <option>Bin #002</option>
                        <option>Bin #003</option>
                        <option>Bin #004</option>
                    </select>
                </div>

                {{-- DATE --}}
                <div>
                    <label class="text-xs font-medium text-gray-600 mb-1 block">Date</label>
                    <input type="text" placeholder="Select Date" x-ref="dateInput" x-model="dateFilter"
                        class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg bg-white cursor-pointer focus:ring-2 focus:ring-blue-400"
                        readonly>
                </div>

            </div>
        </div>

    </div>

    {{-- TABLE CARD --}}
    <div class="bg-white shadow-sm border rounded-xl overflow-hidden">

        {{-- TABLE HEADER WITH SEARCH --}}
        <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-3 px-4 py-3 bg-gray-50 border-b">

            {{-- SEARCH --}}
            <div class="relative w-full sm:w-72 lg:w-80">
                <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-4.35-4.35m0 0a7 7 
                           0 11-9.9-9.9 7 7 0 019.9 9.9z" />
                </svg>
                <input type="text" x-model="searchQuery" placeholder="Search records..."
                    class="w-full pl-9 pr-3 py-2 text-sm bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="text-xs sm:text-sm text-gray-600 whitespace-nowrap">
                Showing 
                <span class="font-semibold" x-text="paginationStart"></span> -
                <span class="font-semibold" x-text="paginationEnd"></span>
                of 
                <span class="font-semibold" x-text="filteredRecords.length"></span>
            </div>

        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full min-w-[650px]">

                <thead>
                    <tr class="bg-gray-50 border-b">

                        {{-- SORTABLE HEADERS --}}
                        <template x-for="col in [
                            { key: 'date', label: 'Date' },
                            { key: 'time', label: 'Time' },
                            { key: 'bin', label: 'Bin' },
                            { key: 'status', label: 'Status' }
                        ]">
                            <th @click="handleSort(col.key)"
                                class="px-4 py-3 text-center font-semibold text-sm cursor-pointer hover:bg-gray-100">
                                
                                <div class="flex items-center justify-center gap-1">
                                    <span x-text="col.label"></span>

                                    <template x-if="sortField === col.key">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path x-show="sortDirection === 'asc'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 15l7-7 7 7" />
                                            <path x-show="sortDirection === 'desc'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </template>
                                </div>

                            </th>
                        </template>

                        <th class="px-4 py-3 text-center font-semibold text-sm">Notes</th>

                    </tr>
                </thead>

                <tbody>

                    {{-- ROWS --}}
                    <template x-for="(record, i) in paginatedRecords" :key="i">
                        <tr class="border-b hover:bg-gray-50 transition">

                            <td class="px-4 py-3 text-center text-sm" x-text="record.date"></td>
                            <td class="px-4 py-3 text-center text-sm" x-text="record.time"></td>
                            <td class="px-4 py-3 text-center text-sm font-medium" x-text="record.bin"></td>

                            <td class="px-4 py-3 text-center">
                                <span class="inline-block w-24 text-center px-3 py-1 rounded-lg text-xs font-semibold"
                                    :class="getStatusBadgeClasses(record.status)"
                                    x-text="record.status">
                                </span>
                            </td>

                            <td class="px-4 py-3 text-left text-sm text-gray-600" x-text="record.notes"></td>

                        </tr>
                    </template>

                    {{-- EMPTY STATE --}}
                    <template x-if="paginatedRecords.length === 0">
                        <tr>
                            <td colspan="5" class="py-12 px-4">
                                <div class="flex flex-col items-center gap-3">

                                    <svg class="w-14 h-14 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 
                                               2 0 01-2-2V5a2 2 0 012-2h5.6a1 1 
                                               0 01.7.3l5.4 5.4a1 1 0 01.3.7V19a2 
                                               2 0 01-2 2z" />
                                    </svg>

                                    <p class="text-gray-700 font-semibold">No records found</p>
                                    <p class="text-gray-500 text-xs">Try adjusting filters or search</p>

                                    <button @click="handleResetFilter()"
                                        class="mt-1 px-4 py-2 text-xs bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                        Reset Filters
                                    </button>

                                </div>
                            </td>
                        </tr>
                    </template>

                </tbody>

            </table>
        </div>

        {{-- PAGINATION --}}
        <div x-show="filteredRecords.length > 0"
            class="px-4 py-3 bg-gray-50 border-t flex items-center justify-center gap-2">

            <button @click="currentPage--"
                :disabled="currentPage === 1"
                class="px-3 py-1.5 text-xs border rounded-md hover:bg-blue-50 disabled:opacity-40">
                Prev
            </button>

            <template x-for="page in totalPages">
                <button @click="currentPage = page"
                    :class="currentPage === page 
                        ? 'bg-blue-600 text-white' 
                        : 'bg-white hover:bg-blue-50'"
                    class="px-3 py-1.5 text-xs border rounded-md">
                    <span x-text="page"></span>
                </button>
            </template>

            <button @click="currentPage++"
                :disabled="currentPage === totalPages"
                class="px-3 py-1.5 text-xs border rounded-md hover:bg-blue-50 disabled:opacity-40">
                Next
            </button>

        </div>

    </div>

</div>

{{-- FLATPICKR --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

{{-- ALPINE JS LOGIC --}}
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('historyLogMonitor', () => ({

        statusFilter: '',
        binFilter: '',
        dateFilter: '',
        searchQuery: '',
        sortField: null,
        sortDirection: 'asc',
        currentPage: 1,
        perPage: 5,
        flatpickrInstance: null,

        allRecords: [
            { date: '30/09/2025', time: '13.30', bin: 'Bin #001', status: 'Empetied', notes: 'Regular Collection' },
            { date: '30/09/2025', time: '09.52', bin: 'Bin #001', status: 'Empetied', notes: 'Solar panel efficiency below 20%' },
            { date: '30/09/2025', time: '16.47', bin: 'Bin #001', status: 'Empetied', notes: 'Capacity reached 90%' },
            { date: '29/09/2025', time: '14.20', bin: 'Bin #002', status: 'Empetied', notes: 'Regular Collection' },
            { date: '29/09/2025', time: '11.15', bin: 'Bin #003', status: 'Alert', notes: 'Requires immediate attention' },
            { date: '28/09/2025', time: '10.30', bin: 'Bin #002', status: 'Empetied', notes: 'Capacity reached 85%' },
            { date: '27/09/2025', time: '08.15', bin: 'Bin #004', status: 'Empetied', notes: 'Regular Collection' },
            { date: '27/09/2025', time: '15.20', bin: 'Bin #001', status: 'Full', notes: 'High volume detected' },
            { date: '26/09/2025', time: '12.45', bin: 'Bin #003', status: 'Empetied', notes: 'Maintenance required' },
            { date: '26/09/2025', time: '09.30', bin: 'Bin #002', status: 'Empetied', notes: 'Regular Collection' },
        ],

        init() {
            this.flatpickrInstance = flatpickr(this.$refs.dateInput, {
                dateFormat: "d/m/Y",
                onChange: (d, dateStr) => {
                    this.dateFilter = dateStr;
                    this.currentPage = 1;
                }
            });
        },

        get filteredRecords() {
            let q = this.searchQuery.toLowerCase();

            let results = this.allRecords.filter(r => {
                let matches =
                    (!this.statusFilter || r.status === this.statusFilter) &&
                    (!this.binFilter || r.bin === this.binFilter) &&
                    (!this.dateFilter || r.date.includes(this.dateFilter));

                let search = Object.values(r).some(v =>
                    String(v).toLowerCase().includes(q)
                );

                return matches && search;
            });

            if (this.sortField) {
                results.sort((a, b) => {
                    let A = a[this.sortField];
                    let B = b[this.sortField];

                    if (A < B) return this.sortDirection === 'asc' ? -1 : 1;
                    if (A > B) return this.sortDirection === 'asc' ? 1 : -1;
                    return 0;
                });
            }

            return results;
        },

        get paginatedRecords() {
            let start = (this.currentPage - 1) * this.perPage;
            return this.filteredRecords.slice(start, start + this.perPage);
        },

        get totalPages() {
            return Math.ceil(this.filteredRecords.length / this.perPage);
        },

        get paginationStart() {
            if (this.filteredRecords.length === 0) return 0;
            return (this.currentPage - 1) * this.perPage + 1;
        },

        get paginationEnd() {
            return Math.min(this.currentPage * this.perPage, this.filteredRecords.length);
        },

        handleSort(field) {
            this.currentPage = 1;

            if (this.sortField === field) {
                this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortField = field;
                this.sortDirection = 'asc';
            }
        },

        handleResetFilter() {
            this.statusFilter = '';
            this.binFilter = '';
            this.dateFilter = '';
            this.searchQuery = '';
            this.sortField = null;
            this.sortDirection = 'asc';
            this.currentPage = 1;

            if (this.flatpickrInstance) this.flatpickrInstance.clear();
        },

        countByStatus(status) {
            return this.allRecords.filter(r => r.status === status).length;
        },

        countMaintenance() {
            return this.allRecords.filter(r =>
                r.status === 'Battery Low' || r.status === 'Full'
            ).length;
        },

        getStatusBadgeClasses(status) {
            return {
                'Empetied': 'bg-emerald-100 text-emerald-700',
                'Battery Low': 'bg-amber-100 text-amber-700',
                'Alert': 'bg-rose-100 text-rose-700',
                'Full': 'bg-blue-100 text-blue-700',
            }[status] || 'bg-gray-100 text-gray-600';
        }

    }));
});
</script>

@endsection