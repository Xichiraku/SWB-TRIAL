@extends('admin.layouts.app')

@section('title', __('app.dashboard') . ' - Smart Waste Monitor')

{{-- TITLE UNTUK HEADER KANAN --}}
@section('page_title')
<div class="flex flex-col">
    <h1 class="text-3xl font-bold text-gray-800 leading-tight">
       {{ __('app.dashboard_monitoring') }}
    </h1>
    <p class="text-gray-600 mt-1 text-base leading-snug" id="last-updated">
        {{ __('app.last_updated') }}: Loading...
    </p>
</div>
@endsection

@section('content')
<div x-data="{
    bins: [],
    stats: { total: 0, full: 0, normal: 0, maintenance: 0 },
    filter: 'all',
    loading: true,
    lastUpdated: 'Loading...',
    
    async fetchBins() {
        try {
            const response = await fetch('/api/admin/bins?filter=' + this.filter);
            const data = await response.json();
            
            if (data.success) {
                this.bins = data.data;
                this.stats = data.stats;
            }
        } catch (error) {
            console.error('Error:', error);
        } finally {
            this.loading = false;
        }
    },
    
    async fetchStats() {
        try {
            const response = await fetch('/api/admin/stats');
            const data = await response.json();
            
            if (data.success) {
                this.lastUpdated = data.data.last_updated;
                document.getElementById('last-updated').textContent = '{{ __('app.last_updated') }}: ' + data.data.last_updated;
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
}" 
x-init="
    fetchBins(); 
    fetchStats(); 
    setInterval(() => { fetchBins(); fetchStats(); }, 10000);
"
class="min-h-screen px-4 sm:px-6 lg:px-8 py-6">

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

    <div @click="filter = 'all'; fetchBins()" 
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
                <p class="text-gray-600 text-sm">{{ __('app.total_bins') }}</p>
                <p class="text-3xl font-bold" x-text="stats.total"></p>
            </div>
        </div>
    </div>

    <div @click="filter = 'Full'; fetchBins()" 
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
                <p class="text-gray-600 text-sm">{{ __('app.full') }}</p>
                <p class="text-3xl font-bold text-red-600" x-text="stats.full"></p>
            </div>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-red-600 h-2 rounded-full" 
                 :style="`width: ${stats.total > 0 ? (stats.full / stats.total) * 100 : 0}%`"></div>
        </div>
    </div>

    <div @click="filter = 'Normal'; fetchBins()" 
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
                <p class="text-gray-600 text-sm">{{ __('app.normal') }}</p>
                <p class="text-3xl font-bold text-green-600" x-text="stats.normal"></p>
            </div>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-green-600 h-2 rounded-full" 
                 :style="`width: ${stats.total > 0 ? (stats.normal / stats.total) * 100 : 0}%`"></div>
        </div>
    </div>

    <div @click="filter = 'Maintenance'; fetchBins()" 
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
                <p class="text-gray-600 text-sm">{{ __('app.maintenance') }}</p>
                <p class="text-3xl font-bold text-orange-600" x-text="stats.maintenance"></p>
            </div>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-orange-600 h-2 rounded-full" 
                 :style="`width: ${stats.total > 0 ? (stats.maintenance / stats.total) * 100 : 0}%`"></div>
        </div>
    </div>

</div>

<div x-show="loading" class="bg-white rounded-xl shadow-sm border p-12 text-center">
    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
    <p class="text-gray-600">{{ __('app.loading_bins') }}</p>
</div>

<div x-show="!loading" class="bg-white rounded-xl shadow-sm border p-6">
    <h2 class="text-xl font-bold text-gray-900 mb-6">{{ __('app.smart_vacuum_bins') }}</h2>

    <div class="space-y-4">
        <template x-for="(bin, index) in bins" :key="index">
            <a :href="`/admin/bin/${bin.bin_id}`" class="block group">
                <div class="bg-white border-2 border-gray-300 rounded-xl p-5 hover:bg-blue-50 hover:border-blue-300 transition-all duration-200 cursor-pointer shadow-sm hover:shadow-md">
                    <div class="flex items-center justify-between">
                        
                        <div class="flex items-center space-x-4">
                            <div class="bg-gray-100 p-3 rounded-lg group-hover:bg-blue-100 transition-colors">
                                <svg class="w-8 h-8 text-gray-700 group-hover:text-blue-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold group-hover:text-blue-700 transition-colors" x-text="bin.name"></h3>
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

                            <div x-show="bin.status === 'Full'" class="bg-red-100 text-red-700 px-4 py-1 rounded-full text-sm font-medium">{{ __('app.full') }}</div>
                            <div x-show="bin.status === 'Normal'" class="bg-green-100 text-green-700 px-4 py-1 rounded-full text-sm font-medium">{{ __('app.normal') }}</div>
                            <div x-show="bin.status === 'Maintenance'" class="bg-orange-100 text-orange-700 px-4 py-1 rounded-full text-sm font-medium">{{ __('app.maintenance') }}</div>
                        </div>

                        <div class="flex items-center space-x-8">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">{{ __('app.capacity') }}</p>
                                <div class="flex items-center space-x-3">
                                    <div class="w-48 bg-gray-300 h-3 rounded-full overflow-hidden">
                                        <div class="h-3 rounded-full transition-all duration-1000" 
                                             :class="bin.capacity >= 85 ? 'bg-red-600' : 'bg-blue-600'"
                                             :style="`width: ${bin.capacity}%`"></div>
                                    </div>
                                    <span class="text-sm font-bold text-gray-700" x-text="bin.capacity + '%'"></span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 rounded-full" :class="bin.battery <= 20 ? 'bg-red-500' : 'bg-blue-500'"></div>
                                <span class="text-lg font-bold" :class="bin.battery <= 20 ? 'text-red-600' : 'text-blue-600'" x-text="bin.battery + '%'"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </template>

        <div x-show="bins.length === 0 && !loading" class="text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <p class="text-gray-500 text-lg font-medium">{{ __('app.no_bins_found') }}</p>
            <p class="text-gray-400 text-sm mt-1">{{ __('app.try_different_filter') }}</p>
        </div>
    </div>
</div>

</div>
@endsection