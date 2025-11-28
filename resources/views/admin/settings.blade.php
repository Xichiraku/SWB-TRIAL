@extends('admin.layouts.app')

@section('title', 'Settings - Smart Waste Monitor')

@section('content')
<div id="saveNotification" class="save-notification">
    ✓ Settings saved successfully!
</div>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        background: linear-gradient(135deg, #e3f2fd 0%, #f5f5f5 100%);
        min-height: 100vh;
        padding: 0;
        margin: 0;
    }

    .container {
        width: 100%;
        max-width: none; /* full layar */
        margin: 0;
        padding: 2rem 3rem; /* bisa diubah sesuai kebutuhan */
    }

    h1 {
        font-size: 2.5rem;
        text-align: center;
        margin-bottom: 2rem;
        color: #333;
    }

    .card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        margin-bottom: 1.5rem;
        width: 100%; /* full width */
    }

    .card-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .card-header h2 {
        font-size: 1.5rem;
        color: #333;
    }

    .section-divider {
        border: none;
        border-top: 1px solid #e0e0e0;
        margin: 1.5rem 0;
    }

    .setting-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
    }

    .setting-info h4 {
        font-size: 1rem;
        color: #333;
        margin-bottom: 0.25rem;
    }

    .setting-info p {
        font-size: 0.875rem;
        color: #666;
    }

    /* Toggle Switch */
    .toggle {
        position: relative;
        width: 56px;
        height: 32px;
        background: #fff;
        border: 2px solid #e0e0e0;
        border-radius: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .toggle.active {
        background: #2196F3;
        border-color: #2196F3;
    }

    .toggle-thumb {
        position: absolute;
        top: 3px;
        left: 3px;
        width: 22px;
        height: 22px;
        background: #999;
        border-radius: 50%;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .toggle.active .toggle-thumb {
        transform: translateX(24px);
        background: white;
    }

    /* Slider */
    .slider-container {
        margin-bottom: 1.5rem;
    }

    .slider-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }

    .slider-label {
        font-weight: 600;
        color: #333;
    }

    .slider-value {
        font-weight: bold;
        color: #2196F3;
    }

    .slider {
        width: 100%;
        height: 8px;
        border-radius: 4px;
        background: #e0e0e0;
        outline: none;
        -webkit-appearance: none;
        cursor: pointer;
    }

    .slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #2196F3;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .slider::-moz-range-thumb {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #2196F3;
        cursor: pointer;
        border: none;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .slider-description {
        font-size: 0.875rem;
        color: #666;
        margin-top: 0.5rem;
    }

    /* Select Dropdown */
    .select-group {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    .select-container label {
        display: block;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }

    select {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 1rem;
        background: white;
        cursor: pointer;
        transition: border-color 0.3s;
    }

    select:focus {
        outline: none;
        border-color: #2196F3;
    }

    .operation-mode {
        background: #f5f5f5;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }

    .operation-mode p:first-child {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.25rem;
    }

    .operation-mode p:last-child {
        font-size: 0.875rem;
        color: #666;
    }

    .save-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background: #4CAF50;
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        opacity: 0;
        transform: translateY(-20px);
        transition: all 0.3s ease;
        pointer-events: none;
        z-index: 1000;
    }

    .save-notification.show {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<div class="container">
    <h1>SETTINGS</h1>

    <!-- Notification Section -->
    <div class="card">
        <div class="card-header">
            <span style="font-size: 1.5rem;">🔔</span>
            <h2>Notifikasi</h2>
        </div>

        <div class="setting-item">
            <div class="setting-info">
                <h4>Izinkan Notifikasi</h4>
                <p>Saklar utama untuk semua jenis notifikasi</p>
            </div>
            <div class="toggle {{ $settings->notif_enabled ? 'active' : '' }}" 
                 onclick="toggleSwitch(this, 'notif_enabled')">
                <div class="toggle-thumb"></div>
            </div>
        </div>

        <hr class="section-divider">

        <h3 style="margin-bottom: 1rem; color: #333;">Jenis Peringatan</h3>

        <div class="setting-item">
            <div class="setting-info">
                <h4>Peringatan Kapasitas Penuh</h4>
                <p>Beritahu ketika tempat sampah mencapai batas kapasitas</p>
            </div>
            <div class="toggle {{ $settings->capacity_alert ? 'active' : '' }}" 
                 onclick="toggleSwitch(this, 'capacity_alert')">
                <div class="toggle-thumb"></div>
            </div>
        </div>

        <div class="setting-item">
            <div class="setting-info">
                <h4>Peringatan Baterai Lemah</h4>
                <p>Beritahu ketika baterai surya hampir habis</p>
            </div>
            <div class="toggle {{ $settings->battery_alert ? 'active' : '' }}" 
                 onclick="toggleSwitch(this, 'battery_alert')">
                <div class="toggle-thumb"></div>
            </div>
        </div>

        <div class="setting-item">
            <div class="setting-info">
                <h4>Peringatan Perawatan</h4>
                <p>Beritahu ketika perawatan diperlukan</p>
            </div>
            <div class="toggle {{ $settings->nurse_alert ? 'active' : '' }}" 
                 onclick="toggleSwitch(this, 'nurse_alert')">
                <div class="toggle-thumb"></div>
            </div>
        </div>

        <hr class="section-divider">

        <h3 style="margin-bottom: 1rem; color: #333;">Metode Pengiriman</h3>

        <div class="setting-item">
            <div class="setting-info">
                <h4>Notifikasi Email</h4>
                <p>Kirim peringatan melalui email</p>
            </div>
            <div class="toggle {{ $settings->email_notif ? 'active' : '' }}" 
                 onclick="toggleSwitch(this, 'email_notif')">
                <div class="toggle-thumb"></div>
            </div>
        </div>

        <div class="setting-item">
            <div class="setting-info">
                <h4>Notifikasi Push</h4>
                <p>Notifikasi melalui browser</p>
            </div>
            <div class="toggle {{ $settings->push_notif ? 'active' : '' }}" 
                 onclick="toggleSwitch(this, 'push_notif')">
                <div class="toggle-thumb"></div>
            </div>
        </div>
    </div>

    <!-- System Configuration -->
    <div class="card">
        <div class="card-header">
            <span style="font-size: 1.5rem;">⚙️</span>
            <h2>System Configuration</h2>
        </div>

        <h3 style="margin-bottom: 1rem; color: #333;">Operation Mode</h3>
        <div class="operation-mode">
            <p>Automatic</p>
            <p>System automatically triggers alerts and maintenance</p>
        </div>

        <hr class="section-divider">

        <h3 style="margin-bottom: 1rem; color: #333;">Alert Threshold</h3>

        <div class="slider-container">
            <div class="slider-header">
                <span class="slider-label">Collection Threshold</span>
                <span class="slider-value" id="collectionValue">{{ $settings->collection_threshold }}%</span>
            </div>
            <input type="range" class="slider" id="collectionThreshold" 
                   min="0" max="100" value="{{ $settings->collection_threshold }}"
                   oninput="updateSlider('collectionThreshold', 'collectionValue', '%')"
                   onchange="saveSettings()">
            <p class="slider-description">Trigger collection alerts when capacity reaches this level</p>
        </div>

        <div class="slider-container">
            <div class="slider-header">
                <span class="slider-label">Battery Low Threshold</span>
                <span class="slider-value" id="batteryValue">{{ $settings->battery_threshold }}%</span>
            </div>
            <input type="range" class="slider" id="batteryThreshold" 
                   min="0" max="100" value="{{ $settings->battery_threshold }}"
                   oninput="updateSlider('batteryThreshold', 'batteryValue', '%')"
                   onchange="saveSettings()">
            <p class="slider-description">Trigger battery alerts when level below this threshold</p>
        </div>

        <div class="slider-container">
            <div class="slider-header">
                <span class="slider-label">Data Refresh Interval</span>
                <span class="slider-value" id="refreshValue">{{ $settings->refresh_interval }}s</span>
            </div>
            <input type="range" class="slider" id="refreshInterval" 
                   min="10" max="120" step="10" value="{{ $settings->refresh_interval }}"
                   oninput="updateSlider('refreshInterval', 'refreshValue', 's')"
                   onchange="saveSettings()">
            <p class="slider-description">How often to refresh data from IoT sensor</p>
        </div>
    </div>

    <!-- Display Preferences -->
    <div class="card">
        <div class="card-header">
            <span style="font-size: 1.5rem;">🎨</span>
            <h2>Display Preferences</h2>
        </div>

        <div class="select-group">
            <div class="select-container">
                <label>Theme</label>
                <select id="theme" onchange="saveSettings()">
                    <option {{ $settings->theme == 'System' ? 'selected' : '' }}>System</option>
                    <option {{ $settings->theme == 'Light' ? 'selected' : '' }}>Light</option>
                    <option {{ $settings->theme == 'Dark' ? 'selected' : '' }}>Dark</option>
                </select>
            </div>

            <div class="select-container">
                <label>Language</label>
                <select id="language" onchange="saveSettings()">
                    <option {{ $settings->language == 'English' ? 'selected' : '' }}>English</option>
                    <option {{ $settings->language == 'Bahasa Indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                    <option {{ $settings->language == '中文' ? 'selected' : '' }}>中文</option>
                </select>
            </div>

            <div class="select-container">
                <label>Units</label>
                <select id="units" onchange="saveSettings()">
                    <option {{ $settings->units == 'Metric' ? 'selected' : '' }}>Metric</option>
                    <option {{ $settings->units == 'Imperial' ? 'selected' : '' }}>Imperial</option>
                </select>
            </div>
        </div>
    </div>
</div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

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
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function showNotification() {
        const notification = document.getElementById('saveNotification');
        notification.classList.add('show');
        setTimeout(() => {
            notification.classList.remove('show');
        }, 2000);
    }
</script>
@endsection
