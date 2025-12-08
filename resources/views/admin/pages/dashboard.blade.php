@extends('admin.layouts.app')

@section('title', 'Dashboard - Smart Waste Monitor')

{{-- TITLE UNTUK HEADER KANAN --}}
@section('page_title')
<div class="flex flex-col">
    <h1 class="text-3xl font-bold text-gray-800 leading-tight">
       Dashboard Monitoring
    </h1>
    <p class="text-gray-600 mt-1 text-base leading-snug">
   Last updated: 10:42:17
    </p>
    </div>
@endsection

@section('content')
<div x-data="{
    filter: 'all',
    bins: [
        {
            id: '001',
            name: 'Bin #001',
            location: 'Main Street Park',
            status: 'Full',
            capacity: 85,
            battery: 78
        },
        {
            id: '002',
            name: 'Bin #002',
            location: 'Central Market',
            status: 'Normal',
            capacity: 65,
            battery: 62
        },
        {
            id: '003',
            name: 'Bin #003',
            location: 'City Plaza',
            status: 'Full',
            capacity: 92,
            battery: 55
        },
        {
            id: '004',
            name: 'Bin #004',
            location: 'Beach Park',
            status: 'Normal',
            capacity: 45,
            battery: 88
        },
        {
            id: '005',
            name: 'Bin #005',
            location: 'Shopping Mall',
            status: 'Maintenance',
            capacity: 30,
            battery: 25
        }
    ],
    get filteredBins() {
        if (this.filter === 'all') return this.bins;
        return this.bins.filter(bin => bin.status === this.filter);
    },
    get totalBins() {
        return this.bins.length;
    },
    get fullBins() {
        return this.bins.filter(bin => bin.status === 'Full').length;
    },
    get normalBins() {
        return this.bins.filter(bin => bin.status === 'Normal').length;
    },
    get maintenanceBins() {
        return this.bins.filter(bin => bin.status === 'Maintenance').length;
    }
}" 
     class="min-h-screen px-4 sm:px-6 lg:px-8 py-6">

<!-- STATS CARDS dengan Filter -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

    <!-- Total Bins -->
    <div @click="filter = 'all'" 
         :class="filter === 'all' ? 'bg-blue-50 border-blue-400' : 'bg-white border-gray-300'"
         class="rounded-xl shadow-sm p-6 border-2 hover:bg-blue-50 hover:border-blue-300 transition cursor-pointer">
        <div class="flex items-center space-x-3 mb-3">
            <div class="bg-gray-100 p-2 rounded-lg">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Total Bins</p>
                <p class="text-3xl font-bold" x-text="totalBins"></p>
            </div>
        </div>
    </div>

    <!-- Full -->
    <div @click="filter = 'Full'" 
         :class="filter === 'Full' ? 'bg-red-50 border-red-400' : 'bg-white border-gray-300'"
         class="rounded-xl shadow-sm p-6 border-2 hover:bg-red-50 hover:border-red-300 transition cursor-pointer">
        <div class="flex items-center space-x-3 mb-3">
            <div class="bg-red-100 p-2 rounded-lg">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Full</p>
                <p class="text-3xl font-bold text-red-600" x-text="fullBins"></p>
            </div>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-red-600 h-2 rounded-full" :style="`width: ${(fullBins / totalBins) * 100}%`"></div>
        </div>
    </div>

    <!-- Normal -->
    <div @click="filter = 'Normal'" 
         :class="filter === 'Normal' ? 'bg-green-50 border-green-400' : 'bg-white border-gray-300'"
         class="rounded-xl shadow-sm p-6 border-2 hover:bg-green-50 hover:border-green-300 transition cursor-pointer">
        <div class="flex items-center space-x-3 mb-3">
            <div class="bg-green-100 p-2 rounded-lg">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 0 018 18z"/>
                </svg>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Normal</p>
                <p class="text-3xl font-bold text-green-600" x-text="normalBins"></p>
            </div>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-green-600 h-2 rounded-full" :style="`width: ${(normalBins / totalBins) * 100}%`"></div>
        </div>
    </div>

    <!-- Maintenance -->
    <div @click="filter = 'Maintenance'" 
         :class="filter === 'Maintenance' ? 'bg-orange-50 border-orange-400' : 'bg-white border-gray-300'"
         class="rounded-xl shadow-sm p-6 border-2 hover:bg-orange-50 hover:border-orange-300 transition cursor-pointer">
        <div class="flex items-center space-x-3 mb-3">
            <div class="bg-orange-100 p-2 rounded-lg">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Maintenance</p>
                <p class="text-3xl font-bold text-orange-600" x-text="maintenanceBins"></p>
            </div>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-orange-600 h-2 rounded-full" :style="`width: ${(maintenanceBins / totalBins) * 100}%`"></div>
        </div>
    </div>

</div>

<!-- BIN LIST -->
<div class="bg-white rounded-xl shadow-sm border p-6">
    <h2 class="text-xl font-bold text-gray-900 mb-6">Smart Vacuum Trash Bins</h2>

    <div class="space-y-4">

        <!-- Loop Bins -->
        <template x-for="bin in filteredBins" :key="bin.id">
            <a :href="`/bin/${bin.id}`" class="block">
                <div class="bg-white border-2 border-gray-300 rounded-xl p-5 hover:bg-blue-50 hover:border-blue-300 transition cursor-pointer">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="bg-gray-100 p-3 rounded-lg">
                                <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold" x-text="bin.name"></h3>
                                <div class="flex items-center space-x-1 text-gray-600 text-sm mt-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span x-text="bin.location"></span>
                                </div>
                            </div>

                            <!-- Status Badge -->
                            <div x-show="bin.status === 'Full'" class="bg-red-100 text-red-700 px-4 py-1 rounded-full text-sm font-medium flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <span>Full</span>
                            </div>

                            <div x-show="bin.status === 'Normal'" class="bg-green-100 text-green-700 px-4 py-1 rounded-full text-sm font-medium flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 0 018 18z"/>
                                </svg>
                                <span>Normal</span>
                            </div>

                            <div x-show="bin.status === 'Maintenance'" class="bg-orange-100 text-orange-700 px-4 py-1 rounded-full text-sm font-medium flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>Maintenance</span>
                            </div>
                        </div>

                        <div class="flex items-center space-x-8">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Capacity</p>
                                <div class="flex items-center space-x-3">
                                    <div class="w-48 bg-gray-300 h-3 rounded-full">
                                        <div class="bg-blue-600 h-3 rounded-full" :style="`width: ${bin.capacity}%`"></div>
                                    </div>
                                    <span class="text-sm font-bold text-gray-700" x-text="bin.capacity + '%'"></span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                <span class="text-lg font-bold text-blue-600" x-text="bin.battery + '%'"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </template>

        <!-- Empty State -->
        <div x-show="filteredBins.length === 0" class="text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <p class="text-gray-500 text-lg font-medium">No bins found</p>
            <p class="text-gray-400 text-sm mt-1">Try selecting a different filter</p>
        </div>

    </div>
</div>

</div>
@endsection