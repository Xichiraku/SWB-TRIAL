@extends('admin.layouts.app')

@section('title', __('app.settings') . ' - Smart Waste Monitor')

@section('content')

<div x-data="settingsManager()" class="max-w-7xl mx-auto">

    <div class="-mt-4 mb-8">
        <p class="text-[16px] text-[#4a4a4a]">
            {{ __('app.system_config_description') }}
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
                    {{ __('app.esp32_status') }}
                </p>

                <h3 class="text-xl font-bold {{ $espOnline ? 'text-green-600' : 'text-red-600' }}">
                    {{ $espOnline ? __('app.connected') : __('app.offline') }}
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

                    {{ __('app.threshold') }}

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

                    {{ __('app.refresh') }}

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

                    {{ __('app.battery_alert_label') }}

                </p>

                <h3 class="text-xl font-bold">

                    {{ $settings->battery_threshold }}%

                </h3>

            </div>

        </div>

    </div>

</div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

       
       
        <div class="bg-white rounded-[30px] p-8 main-shadow border border-gray-100 min-h-[320px]">

    <h2 class="text-[24px] font-bold text-[#264626] mb-2">
        {{ __('app.system_settings') }}
    </h2>

    <p class="text-sm text-gray-500 mb-8">
        {{ __('app.manage_preferences') }}
    </p>

    <div class="space-y-8">

        <!-- Language -->

        <div>

            <label class="block text-[#264626] font-semibold mb-3">
                {{ __('app.language') }}
            </label>

            <select
                x-model="settings.language"
                @change="save()"
                class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 focus:ring-2 focus:ring-green-500">

                <option value="en">
                    English
                </option>

                <option value="id">
                    Bahasa Indonesia
                </option>

            </select>

        </div>

        <!-- Theme -->

        <div>

            <label class="block text-[#264626] font-semibold mb-3">
                {{ __('app.application_theme') }}
            </label>

            <select
                x-model="settings.theme"
                @change="save()"
                class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 focus:ring-2 focus:ring-green-500">

                <option value="light">
                {{ __('app.light_mode') }}
            </option>

            <option value="dark">
                {{ __('app.dark_mode') }}
            </option>

            <option value="system">
                {{ __('app.system_default') }}
            </option>

            </select>

        </div>

    </div>

</div>

        <div class="bg-[#9AD18B]/80 rounded-[30px] p-8 green-shadow border border-white/20 min-h-[320px]">

    <h2 class="text-[24px] font-bold text-[#264626] mb-2">
        {{ __('app.system_information') }}
    </h2>

    <p class="text-sm text-[#264626]/70 mb-8">
        {{ __('app.smart_waste_info') }}
    </p>

    <div class="space-y-5">

        <div class="flex justify-between border-b pb-3">

            <span class="text-[#264626] font-medium">
                {{ __('app.application') }}
            </span>

            <span class="font-semibold">
                Smart Waste Monitor
            </span>

        </div>

        <div class="flex justify-between border-b pb-3">

            <span class="text-[#264626] font-medium">
                {{ __('app.version') }}
            </span>

            <span class="font-semibold">
                1.0.0
            </span>

        </div>

        <div class="flex justify-between border-b pb-3">

            <span class="text-[#264626] font-medium">
                {{ __('app.framework') }}
            </span>

            <span class="font-semibold">
                Laravel 12
            </span>

        </div>

        <div class="flex justify-between border-b pb-3">

            <span class="text-[#264626] font-medium">
                {{ __('app.database') }}
            </span>

            <span class="font-semibold">
                MongoDB
            </span>

        </div>

        <div class="flex justify-between border-b pb-3">

            <span class="text-[#264626] font-medium">
                {{ __('app.microcontroller') }}
            </span>

            <span class="font-semibold">
                ESP32
            </span>

        </div>

        <div class="flex justify-between">

            <span class="text-[#264626] font-medium">
                {{ __('app.system_status') }}
            </span>

            <span class="{{ $espOnline ? 'text-green-600' : 'text-red-600' }} font-bold">
                {{ $espOnline ? __('app.connected') : __('app.offline') }}
            </span>

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
        <span class="font-bold">{{ __('app.settings_updated') }}</span>
    </div>

</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('settingsManager', () => ({
        notif: false,
        settings: {
            language: '{{ in_array($settings->language, ["English", "en"]) ? "en" : (in_array($settings->language, ["Bahasa Indonesia", "Indonesian", "id"]) ? "id" : "en") }}',
            theme: '{{ $settings->theme ?? "light" }}'a
        },

        save() {
            const token = document.querySelector('meta[name="csrf-token"]')?.content;
            const formData = new FormData();
            formData.append('_token', token || '');
            formData.append('language', this.settings.language);
            formData.append('theme', this.settings.theme);

            fetch('{{ route("admin.settings.update") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(() => {
                this.notif = true;
                setTimeout(() => this.notif = false, 3000);
                setTimeout(() => window.location.reload(), 800);
            })
            .catch(() => {
                this.notif = true;
                setTimeout(() => this.notif = false, 3000);
            });
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