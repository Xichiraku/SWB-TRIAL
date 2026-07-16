@extends('admin.layouts.app')

@section('title', 'Settings - Smart Waste Monitor')

@section('content')

<div x-data="settingsManager()" class="max-w-7xl mx-auto">

    <div class="-mt-4 mb-8">
        <p class="text-[16px] text-[#4a4a4a]">
            System configuration and personalization
        </p>
    </div>

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-8">

    <!-- ESP32 -->
    <div class="bg-white rounded-3xl p-5 shadow-sm border border-green-200">

        <div class="flex items-center gap-4">

            <div class="p-3 bg-green-100 rounded-2xl">

                <i data-lucide="cpu" class="w-7 h-7 text-green-600"></i>

            </div>

            <div>

                <p class="text-sm text-gray-500">
                    ESP32 Status
                </p>

                <h3 class="text-xl font-bold text-green-600">
                    Connected
                </h3>

            </div>

        </div>

    </div>

    <!-- Threshold -->

    <div class="bg-white rounded-3xl p-5 shadow-sm border border-green-200">

        <div class="flex items-center gap-4">

            <div class="p-3 bg-orange-100 rounded-2xl">

                <i data-lucide="gauge" class="w-7 h-7 text-orange-600"></i>

            </div>

            <div>

                <p class="text-sm text-gray-500">

                    Threshold

                </p>

                <h3 class="text-xl font-bold">

                    {{ $settings->collection_threshold }}%

                </h3>

            </div>

        </div>

    </div>

    <!-- Refresh -->

    <div class="bg-white rounded-3xl p-5 shadow-sm border border-green-200">

        <div class="flex items-center gap-4">

            <div class="p-3 bg-blue-100 rounded-2xl">

                <i data-lucide="refresh-cw" class="w-7 h-7 text-blue-600"></i>

            </div>

            <div>

                <p class="text-sm text-gray-500">

                    Refresh

                </p>

                <h3 class="text-xl font-bold">

                    {{ $settings->refresh_interval }} sec

                </h3>

            </div>

        </div>

    </div>

    <!-- Battery -->

    <div class="bg-white rounded-3xl p-5 shadow-sm border border-green-200">

        <div class="flex items-center gap-4">

            <div class="p-3 bg-purple-100 rounded-2xl">

                <i data-lucide="battery-full" class="w-7 h-7 text-purple-600"></i>

            </div>

            <div>

                <p class="text-sm text-gray-500">

                    Battery Alert

                </p>

                <h3 class="text-xl font-bold">

                    {{ $settings->battery_threshold }}%

                </h3>

            </div>

        </div>

    </div>

</div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <div class="bg-[#9AD18B]/80 rounded-[30px] p-8 green-shadow border border-white/20 min-h-[320px]">
            <h2 class="text-[24px] font-bold text-[#264626] mb-8">Notification Preference</h2>
            
            <div class="space-y-6">
                <label class="flex items-center justify-between cursor-pointer group">
                    <span class="text-[18px] text-[#264626] font-medium">Email Notification</span>
                    <input type="checkbox" x-model="settings.email_notif" @change="save()" class="w-6 h-6 rounded border-none bg-white/50 text-green-600 focus:ring-green-500">
                </label>

                <label class="flex items-center justify-between cursor-pointer group">
                    <span class="text-[18px] text-[#264626] font-medium">Push Notification</span>
                    <input type="checkbox" x-model="settings.push_notif" @change="save()" class="w-6 h-6 rounded border-none bg-white/50 text-green-600 focus:ring-green-500">
                </label>

                <label class="flex items-center justify-between cursor-pointer group">
                    <span class="text-[18px] text-[#264626] font-medium">SMS Alert</span>
                    <input type="checkbox" x-model="settings.sms_alert" @change="save()" class="w-6 h-6 rounded border-none bg-white/50 text-green-600 focus:ring-green-500">
                </label>
            </div>
        </div>

        <div class="bg-white rounded-[30px] p-8 main-shadow border border-gray-100 min-h-[320px]">
            <h2 class="text-[24px] font-bold text-[#4a4a4a] mb-6">Alert Threshold</h2>
            
            <div class="space-y-8">
                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-[#4a4a4a] font-medium">Capacity alert level</span>
                        <span class="font-bold text-green-600" x-text="settings.capacity_level + '%'"></span>
                    </div>
                    <input type="range" x-model="settings.capacity_level" @change="save()" min="50" max="100" 
                           class="w-full h-3 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-green-500">
                </div>

                <div>
                    <label class="block text-[#4a4a4a] font-medium mb-2">Auto - Notification Delay</label>
                    <div class="bg-gray-200 rounded-lg h-10 w-full"></div> 
                    <p class="text-xs text-gray-400 mt-2 italic">*System will wait before sending repeated alerts</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[30px] p-8 main-shadow border border-gray-100">
            <h2 class="text-[24px] font-bold text-[#4a4a4a] mb-8">Data Management</h2>
            
            <div class="space-y-4">
                <button @click="backupData()" class="w-full bg-gray-200 hover:bg-gray-300 py-4 rounded-xl text-[18px] font-semibold text-gray-700 transition">
                    Backup Data
                </button>
                <button @click="clearLogs()" class="w-full bg-gray-200 hover:bg-gray-300 py-4 rounded-xl text-[18px] font-semibold text-gray-700 transition">
                    Clear Old Logs
                </button>
            </div>
        </div>

        <div class="bg-[#9AD18B]/80 rounded-[30px] p-8 green-shadow border border-white/20">
            <h2 class="text-[24px] font-bold text-[#264626] mb-8">Appearance</h2>
            
            <div>
                <label class="block text-[#264626] font-medium mb-3 text-[18px]">Theme</label>
                <div class="relative">
                    <select x-model="settings.theme" @change="save()" 
                            class="w-full bg-white/70 border-none rounded-xl py-4 px-5 text-[18px] text-[#264626] appearance-none focus:ring-2 focus:ring-white">
                        <option value="Light Mode">Light Mode</option>
                        <option value="Dark Mode">Dark Mode</option>
                        <option value="System">System Default</option>
                    </select>
                    <div class="absolute right-5 top-5 pointer-events-none">
                        <i data-lucide="chevron-down" class="text-[#264626]"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div x-show="notif" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         class="fixed bottom-10 right-10 bg-[#1F4D1F] text-white px-8 py-4 rounded-2xl shadow-2xl z-[100] flex items-center gap-3">
        <i data-lucide="check-circle" class="w-6 h-6"></i>
        <span class="font-bold">Settings Updated!</span>
    </div>

</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('settingsManager', () => ({
        notif: false,
        settings: {
            email_notif: true,
            push_notif: true,
            sms_alert: false,
            capacity_level: 80,
            theme: 'Dark Mode'
        },

        save() {
            // Logika simpan via Fetch API ke Controller Anda
            this.notif = true;
            setTimeout(() => this.notif = false, 3000);
            
            // fetch('{{ route("admin.settings.update") }}', { ... });
        },

        backupData() {
            alert('Starting secure cloud backup...');
        },

        clearLogs() {
            if(confirm('Are you sure you want to clear logs older than 30 days?')) {
                alert('Logs cleared successfully!');
            }
        }
    }));
});
</script>

@endsection