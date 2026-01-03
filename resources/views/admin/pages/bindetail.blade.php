<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bin #{{ $bin->code }} - Detail</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        /* Custom scrollbar untuk kesan modern */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 4px; }
    </style>
</head>
<body class="bg-white text-slate-800 flex h-screen overflow-hidden">

    <aside class="w-64 bg-white border-r border-slate-200 flex flex-col justify-between flex-shrink-0 z-20">
        <div>
            <div class="px-6 py-5 border-b flex items-center gap-4">
            <img src="{{ asset('assets/images/logo.png') }}" class="h-12 w-auto">

            <div class="flex flex-col leading-tight">
                <span class="text-[1.15rem] font-bold text-cyan-700">Smart Waste</span>
                <span class="text-xs text-gray-500">Admin Console</span>
            </div>

            <button class="ml-auto lg:hidden text-gray-400 hover:text-gray-600 transition"
                    @click="sidebarOpen=false">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>

            <nav class="p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-700 hover:bg-slate-50 hover:text-cyan-700 rounded-xl transition-colors font-medium">
                    <i data-lucide="layout-grid" class="w-5 h-5"></i>
                    Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-slate-700 hover:bg-slate-50 hover:text-cyan-700 rounded-xl transition-colors font-medium">
                    <i data-lucide="history" class="w-5 h-5"></i>
                    History
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-slate-700 hover:bg-slate-50 hover:text-cyan-700 rounded-xl transition-colors font-medium">
                    <i data-lucide="settings" class="w-5 h-5"></i>
                    Settings
                </a>
            </nav>
        </div>

        <div class="p-6 border-t border-slate-100">
            <p class="text-xs text-slate-400 text-center">SWB Team - Politeknik Batam</p>
        </div>
    </aside>

    <main class="flex-1 overflow-y-auto bg-white relative">
        
        <header class="sticky top-0 bg-white/90 backdrop-blur-sm z-10 px-8 py-6 flex justify-between items-start border-b border-slate-100">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Bin #{{ $bin->code }}</h1>
                <div class="flex items-center gap-2 text-slate-500 mt-1">
                    <i data-lucide="map-pin" class="w-4 h-4"></i>
                    <span>{{ $bin->location ?? 'Lokasi Belum Diatur' }}</span>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button onclick="location.reload()" class="p-2 text-slate-400 hover:text-cyan-700 transition" title="Refresh Data">
                    <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                </button>
                <div class="flex items-center gap-2 px-4 py-2 bg-slate-100 rounded-lg border border-slate-200">
                    <div class="w-6 h-6 bg-slate-300 rounded-full flex items-center justify-center">
                        <i data-lucide="user" class="w-4 h-4 text-white"></i>
                    </div>
                    <span class="text-sm font-semibold text-slate-700">Admin</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400"></i>
                </div>
            </div>
        </header>

        <div class="p-8 max-w-6xl">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                
                <div class="bg-slate-100/80 p-6 rounded-2xl flex flex-col items-center justify-center h-40 border border-slate-200/50 shadow-sm">
                    <span class="text-slate-600 font-medium mb-3">Status</span>
                    @php
                        $badgeColor = 'bg-green-600 text-white'; // Default Normal
                        $iconName = 'check-circle';
                        if($bin->status === 'Full' || $bin->capacity >= 85) {
                            $badgeColor = 'bg-red-600 text-white';
                            $iconName = 'alert-triangle';
                        } elseif($bin->status === 'maintenance') {
                            $badgeColor = 'bg-orange-500 text-white';
                            $iconName = 'wrench';
                        }
                    @endphp
                    <div class="px-6 py-1.5 rounded-full font-bold text-sm flex items-center gap-2 {{ $badgeColor }}">
                        <i data-lucide="{{ $iconName }}" class="w-4 h-4"></i>
                        {{ $bin->capacity >= 85 ? 'Full' : ($bin->status == 'maintenance' ? 'Maintenance' : 'Normal') }}
                    </div>
                </div>

                <div class="bg-slate-100/80 p-6 rounded-2xl flex flex-col justify-center h-40 border border-slate-200/50 shadow-sm">
                    <span class="text-slate-600 font-medium mb-4 text-center">Battery Level</span>
                    <div class="w-full px-4">
                        <div class="w-full bg-slate-300 rounded-full h-3 mb-2">
                            <div class="bg-cyan-800 h-3 rounded-full transition-all duration-1000" style="width: {{ $bin->battery_level }}%"></div>
                        </div>
                        </div>
                </div>

                <div class="bg-slate-100/80 p-6 rounded-2xl flex flex-col items-center justify-center h-40 border border-slate-200/50 shadow-sm">
                    <span class="text-slate-600 font-medium mb-2">Last Updated</span>
                    <div class="flex items-center gap-2 mt-1 text-slate-800">
                        <i data-lucide="clock" class="w-5 h-5"></i>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($bin->updated_at)->format('Y-m-d H:i') }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-sky-100 p-8 rounded-2xl border border-sky-200 mb-6 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <i data-lucide="zap" class="w-6 h-6 text-slate-800"></i>
                    <h3 class="text-lg font-medium text-slate-900">Solar Panel Status</h3>
                </div>

                <div class="grid grid-y-4 gap-4">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-700">Power Generation</span>
                        <span class="font-bold text-green-600">Active</span>
                    </div>
                    <div class="flex justify-between items-center border-t border-sky-200 pt-4">
                        <span class="text-slate-700">Daily Energy</span>
                        <span class="font-bold text-slate-900">2.4 kWh</span>
                    </div>
                    <div class="flex justify-between items-center border-t border-sky-200 pt-4">
                        <span class="text-slate-700">Efficiency</span>
                        <span class="font-bold text-slate-900">85%</span>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-2xl border-2 border-slate-100 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <i data-lucide="trash-2" class="w-6 h-6 text-slate-600"></i>
                    <h3 class="text-lg font-medium text-slate-900">Vacuum System</h3>
                </div>

                <div class="grid grid-y-4 gap-4">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-700">Motor Status</span>
                        <span class="font-bold text-green-600">Online</span>
                    </div>
                    <div class="flex justify-between items-center border-t border-slate-100 pt-4">
                        <span class="text-slate-700">Suction Power</span>
                        <span class="font-bold text-slate-900">92%</span>
                    </div>
                    <div class="flex justify-between items-center border-t border-slate-100 pt-4">
                        <span class="text-slate-700">Filter Status</span>
                        <span class="font-bold text-slate-900">Clean</span>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>