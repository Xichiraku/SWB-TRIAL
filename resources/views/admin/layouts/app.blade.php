<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin')</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <!-- WRAPPER UTAMA -->
    <div class="flex min-h-screen">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-white min-h-screen shadow-lg flex flex-col">

            <div class="px-6 py-2 border-b flex items-center justify-center">
                <img src="{{ asset('assets/images/logo.png') }}" 
                    alt="Logo" 
                    class="h-24 max-[180px] object-contain">
            </div>
            <nav class="flex-1 px-4 py-6 space-y-1">

                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg text-base font-medium transition
                    hover:bg-blue-100 hover:text-blue-700
                    {{ Request::is('admin/dashboard') ? 'bg-blue-200 text-blue-800 font-semibold' : 'text-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h4v11H3V10zm6-6h4v17h-4V4zm6 10h4v7h-4v-7z"/>
                    </svg>
                    Dashboard
                </a>

                <!-- History -->
                <a href="{{ route('admin.history') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-base font-medium transition
                   hover:bg-blue-100 hover:text-blue-700
                   {{ Request::is('admin/history') ? 'bg-blue-200 text-blue-800 font-semibold' : 'text-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7h14zM9 4h6v3H9V4z"/>
                    </svg>
                    Histori
                </a>

                <!-- SETTINGS -->
                 <a href="{{ route('admin.settings') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-base font-medium transition
                   hover:bg-blue-100 hover:text-blue-700
                   {{ Request::is('admin/setting') ? 'bg-blue-200 text-blue-800 font-semibold' : 'text-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0m-3.35 0a1.724 1.724 0 00-2.573 1.066c-1.543-.94-3.31.826-2.37 2.37m4.943-3.436L12 6m0 0l-1.447-1.447m1.447 1.447L15 6m-3 0l1.447-1.447m6.569 6.569c1.756.426 1.756 2.924 0 3.35m0-3.35a1.724 1.724 0 00-1.066-2.573m-3.436 4.943L12 18m0 0l1.447 1.447m-1.447-1.447L9 18m3 0l-1.447 1.447"/>
                    </svg>
                    Settings
                </a>

            </nav>
        
            <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                Logout
            </button>
        </form>


        </aside>

        <!-- KONTEN UTAMA -->
        <main class="flex-1 p-8">
            @yield('content')
        </main>

    </div>

</body>
</html>
