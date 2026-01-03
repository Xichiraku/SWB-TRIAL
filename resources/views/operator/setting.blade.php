@extends('layouts.app')

@section('title', __('app.settings'))

@section('content')
    {{-- Notifikasi Simpan --}}
    <div id="saveNotification" class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform -translate-y-20 transition-transform duration-300 z-50">
        ✓ {{ __('app.settings_saved') }}
    </div>

    {{-- Style Khusus untuk Toggle & Slider (Tidak tersedia di Tailwind default) --}}
    <style>
        /* Toggle Switch Styles */
        .toggle {
            position: relative;
            width: 52px;
            height: 28px;
            background: #e5e7eb; /* gray-200 */
            border-radius: 9999px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .toggle.active {
            background: #3b82f6; /* blue-500 */
        }
        .toggle-thumb {
            position: absolute;
            top: 2px;
            left: 2px;
            width: 24px;
            height: 24px;
            background: white;
            border-radius: 50%;
            transition: all 0.3s ease;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .toggle.active .toggle-thumb {
            transform: translateX(24px);
        }

        /* Slider Styles */
        .slider {
            -webkit-appearance: none;
            width: 100%;
            height: 6px;
            border-radius: 3px;
            background: #e5e7eb;
            outline: none;
        }
        .slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #3b82f6;
            cursor: pointer;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }
    </style>

    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">{{ __('app.settings') }}</h1>
        
        <div class="bg-white rounded-xl shadow-sm p-6 sm:p-8 mb-6">
            <div class="flex items-center gap-3 mb-6">
                <span class="text-2xl">🔔</span>
                <h2 class="text-xl font-bold text-gray-800">{{ __('app.notifications') }}</h2>
            </div>

            <div class="flex items-center justify-between py-4 border-b border-gray-100">
                <div>
                    <h4 class="font-semibold text-gray-800">{{ __('app.allow_notifications') }}</h4>
                    <p class="text-sm text-gray-500">{{ __('app.master_switch_notif') }}</p>
                </div>
                <div class="toggle {{ $settings->notif_enabled ? 'active' : '' }}" 
                     onclick="toggleSwitch(this, 'notif_enabled')">
                    <div class="toggle-thumb"></div>
                </div>
            </div>

            <div class="mt-6 mb-4">
                <h3 class="font-semibold text-gray-900 mb-4">{{ __('app.alert_types') }}</h3>
                
                <div class="flex items-center justify-between py-3">
                    <div>
                        <h4 class="text-gray-800">{{ __('app.capacity_full_alert') }}</h4>
                        <p class="text-sm text-gray-500">{{ __('app.notify_when_full') }}</p>
                    </div>
                    <div class="toggle {{ $settings->capacity_alert ? 'active' : '' }}" 
                         onclick="toggleSwitch(this, 'capacity_alert')">
                        <div class="toggle-thumb"></div>
                    </div>
                </div>

                <div class="flex items-center justify-between py-3">
                    <div>
                        <h4 class="text-gray-800">{{ __('app.battery_low_alert') }}</h4>
                        <p class="text-sm text-gray-500">{{ __('app.notify_low_battery') }}</p>
                    </div>
                    <div class="toggle {{ $settings->battery_alert ? 'active' : '' }}" 
                         onclick="toggleSwitch(this, 'battery_alert')">
                        <div class="toggle-thumb"></div>
                    </div>
                </div>

                <div class="flex items-center justify-between py-3">
                    <div>
                        <h4 class="text-gray-800">{{ __('app.maintenance_alert') }}</h4>
                        <p class="text-sm text-gray-500">{{ __('app.notify_maintenance') }}</p>
                    </div>
                    <div class="toggle {{ $settings->nurse_alert ? 'active' : '' }}" 
                         onclick="toggleSwitch(this, 'nurse_alert')">
                        <div class="toggle-thumb"></div>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <h3 class="font-semibold text-gray-900 mb-4">{{ __('app.delivery_methods') }}</h3>

                <div class="flex items-center justify-between py-3">
                    <div>
                        <h4 class="text-gray-800">{{ __('app.email_notification') }}</h4>
                        <p class="text-sm text-gray-500">{{ __('app.send_via_email') }}</p>
                    </div>
                    <div class="toggle {{ $settings->email_notif ? 'active' : '' }}" 
                         onclick="toggleSwitch(this, 'email_notif')">
                        <div class="toggle-thumb"></div>
                    </div>
                </div>

                <div class="flex items-center justify-between py-3">
                    <div>
                        <h4 class="text-gray-800">{{ __('app.push_notification') }}</h4>
                        <p class="text-sm text-gray-500">{{ __('app.send_via_browser') }}</p>
                    </div>
                    <div class="toggle {{ $settings->push_notif ? 'active' : '' }}" 
                         onclick="toggleSwitch(this, 'push_notif')">
                        <div class="toggle-thumb"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 sm:p-8 mb-6">
            <div class="flex items-center gap-3 mb-6">
                <span class="text-2xl">⚙️</span>
                <h2 class="text-xl font-bold text-gray-800">{{ __('app.system_configuration') }}</h2>
            </div>

            <div class="mb-6">
                <h3 class="font-semibold text-gray-900 mb-3">{{ __('app.operation_mode') }}</h3>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <p class="font-semibold text-gray-800">{{ __('app.automatic') }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ __('app.system_auto_trigger') }}</p>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-6">
                <h3 class="font-semibold text-gray-900 mb-6">{{ __('app.alert_threshold') }}</h3>

                <div class="mb-6">
                    <div class="flex justify-between mb-2">
                        <span class="font-medium text-gray-700">{{ __('app.collection_threshold') }}</span>
                        <span class="font-bold text-blue-600" id="collectionValue">{{ $settings->collection_threshold }}%</span>
                    </div>
                    <input type="range" class="slider" id="collectionThreshold" 
                           min="0" max="100" value="{{ $settings->collection_threshold }}"
                           oninput="updateSlider('collectionThreshold', 'collectionValue', '%')"
                           onchange="saveSettings()">
                    <p class="text-sm text-gray-500 mt-2">{{ __('app.trigger_collection') }}</p>
                </div>

                <div class="mb-6">
                    <div class="flex justify-between mb-2">
                        <span class="font-medium text-gray-700">{{ __('app.battery_threshold') }}</span>
                        <span class="font-bold text-blue-600" id="batteryValue">{{ $settings->battery_threshold }}%</span>
                    </div>
                    <input type="range" class="slider" id="batteryThreshold" 
                           min="0" max="100" value="{{ $settings->battery_threshold }}"
                           oninput="updateSlider('batteryThreshold', 'batteryValue', '%')"
                           onchange="saveSettings()">
                    <p class="text-sm text-gray-500 mt-2">{{ __('app.trigger_battery') }}</p>
                </div>

                <div>
                    <div class="flex justify-between mb-2">
                        <span class="font-medium text-gray-700">{{ __('app.refresh_interval') }}</span>
                        <span class="font-bold text-blue-600" id="refreshValue">{{ $settings->refresh_interval }}s</span>
                    </div>
                    <input type="range" class="slider" id="refreshInterval" 
                           min="10" max="120" step="10" value="{{ $settings->refresh_interval }}"
                           oninput="updateSlider('refreshInterval', 'refreshValue', 's')"
                           onchange="saveSettings()">
                    <p class="text-sm text-gray-500 mt-2">{{ __('app.how_often_refresh') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 sm:p-8 mb-6">
            <div class="flex items-center gap-3 mb-6">
                <span class="text-2xl">🎨</span>
                <h2 class="text-xl font-bold text-gray-800">{{ __('app.display_preferences') }}</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">{{ __('app.theme') }}</label>
                    <select id="theme" onchange="saveSettings()" 
                            class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white">
                        <option {{ $settings->theme == 'System' ? 'selected' : '' }}>System</option>
                        <option {{ $settings->theme == 'Light' ? 'selected' : '' }}>Light</option>
                        <option {{ $settings->theme == 'Dark' ? 'selected' : '' }}>Dark</option>
                    </select>
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-2">{{ __('app.language') }}</label>
                    <select id="language" onchange="saveSettings()"
                            class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white">
                        <option {{ $settings->language == 'English' ? 'selected' : '' }}>English</option>
                        <option {{ $settings->language == 'Bahasa Indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                        <option {{ $settings->language == '中文' ? 'selected' : '' }}>中文</option>
                    </select>
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-2">{{ __('app.units') }}</label>
                    <select id="units" onchange="saveSettings()"
                            class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white">
                        <option {{ $settings->units == 'Metric' ? 'selected' : '' }}>Metric</option>
                        <option {{ $settings->units == 'Imperial' ? 'selected' : '' }}>Imperial</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Menggunakan CSRF token dari layout app.blade.php
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    const settingsData = {
        notif_enabled: {{ $settings->notif_enabled ? 'true' : 'false' }},
        capacity_alert: {{ $settings->capacity_alert ? 'true' : 'false' }},
        battery_alert: {{ $settings->battery_alert ? 'true' : 'false' }},
        nurse_alert: {{ $settings->nurse_alert ? 'true' : 'false' }},
        email_notif: {{ $settings->email_notif ? 'true' : 'false' }},
        push_notif: {{ $settings->push_notif ? 'true' : 'false' }}
    };

    function toggleSwitch(element, key) {
        element.classList.toggle('active');
        settingsData[key] = element.classList.contains('active');
        saveSettings();
    }

    function updateSlider(sliderId, valueId, unit) {
        const slider = document.getElementById(sliderId);
        const valueDisplay = document.getElementById(valueId);
        valueDisplay.textContent = slider.value + unit;
    }

    function saveSettings() {
        const data = {
            ...settingsData,
            collection_threshold: parseInt(document.getElementById('collectionThreshold').value),
            battery_threshold: parseInt(document.getElementById('batteryThreshold').value),
            refresh_interval: parseInt(document.getElementById('refreshInterval').value),
            theme: document.getElementById('theme').value,
            language: document.getElementById('language').value,
            units: document.getElementById('units').value
        };

        fetch('{{ route("admin.settings.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                showNotification();
                // Reload halaman untuk apply bahasa baru jika berubah
                if(data.language !== '{{ $settings->language }}') {
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function showNotification() {
        const notification = document.getElementById('saveNotification');
        // Gunakan tailwind utility classes untuk animasi
        notification.classList.remove('-translate-y-20');
        notification.classList.add('translate-y-0');
        
        setTimeout(() => {
            notification.classList.remove('translate-y-0');
            notification.classList.add('-translate-y-20');
        }, 2000);
    }
</script>
@endpush