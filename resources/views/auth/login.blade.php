<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Waste Monitor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50">
<div class="min-h-screen flex items-center justify-center bg-white px-4">

    <div class="max-w-6xl w-full grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">

        <!-- LEFT SIDE -->
       <div class="flex flex-col w-full">
            <!-- GAMBAR UTAMA / ILUSTRATION -->
            <img src="{{ asset('assets/images/recycle.png') }}" 
                class="w-40 mx-auto"
                style="filter: brightness(0) saturate(100%) invert(29%) sepia(92%) saturate(3000%) hue-rotate(190deg) brightness(95%) contrast(100%);">

            <h1 class="text-5xl font-extrabold text-gray-800 mb-3">
                Smart Waste Monitor
            </h1>

            <p class="text-gray-700 text-2xl leading-relaxed mb-6">
                Kelola sampah dengan cerdas, Pantau volume secara real-time,<br>
                dan bantu bumi menjadi lebih bersih.
            </p>

            <!-- GAMBAR KEDUA -->
            <img src="{{ asset('assets/images/gambar1.png') }}" 
                alt="additional illustration" 
                class="w-85 mx-auto mb-4">

            <p class="italic text-gray-700 text-2xl">
                "Bersih dimulai dari kesadaran."
            </p>

        </div>

        <!-- RIGHT SIDE - LOGIN BOX -->
        <div class="bg-white rounded-3xl [box-shadow:40px_40px_80px_rgba(3,106,202,0.6)] 
     p-10 w-full shadow-blue-200 lg:ml-10">
            <div class="text-center mb-8">
                <img src="{{ asset('assets/images/logo.png') }}" alt="logo" class="w-48 mx-auto mb-0.5">
                <h2 class="text-3xl font-bold text-gray-900 mt-[-50px]">Smart Waste Monitor</h2>
                <p class="text-gray-700 text-sm mt-1">Selamat Datang Kembali! Silakan masuk ke akun anda</p>
            </div>

            <form method="POST" action="{{ route('login.post') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                
                <label class="block text-gray-800 font-semibold mb-1">Role</label>
                <select name="role" id="roleSelect" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-left focus:outline-blue-500 mb-4">
                    <option value="admin">Admin</option>
                    <option value="operator">Operator</option>
                </select>

                <!-- USERNAME -->
                <label class="block text-gray-800 font-semibold mb-1">Username</label>
                <div class="relative mb-4">
                    <span class="absolute right-3 top-2.5 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                            class="w-5 h-5" 
                            fill="none" 
                            stroke="currentColor" 
                            stroke-width="2" 
                            stroke-linecap="round" 
                            stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </span>

                    <input 
                        id="usernameInput"
                        name="username"
                        type="text" 
                        placeholder="Admin 1"
                        class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2 text-left focus:outline-blue-500" />
                </div>

                <!-- PASSWORD -->
                <label class="block text-gray-800 font-semibold mb-1">Password</label>
                <div class="relative mb-4">
                    <input id="passwordField" 
                           name="password"
                           type="password" 
                           placeholder="•••••••"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 pr-10 focus:outline-blue-500">

                    <!-- EYE ICON (SHOW/HIDE) -->
                    <button type="button" onclick="togglePassword()" 
                            class="absolute right-3 top-2.5 text-gray-500 cursor-pointer">
                        <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" 
                            class="w-6 h-6" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" 
                            class="w-6 h-6 hidden" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a21.77 21.77 0 0 1 5.06-5.94"/>
                            <path d="M1 1l22 22"/>
                        </svg>
                    </button>
                </div>

                <!-- LOGIN BUTTON -->
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold">
                    Login
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const pwd = document.getElementById("passwordField");
    const eyeOpen = document.getElementById("eyeOpen");
    const eyeClosed = document.getElementById("eyeClosed");

    if (pwd.type === "password") {
        pwd.type = "text";
        eyeOpen.classList.add("hidden");
        eyeClosed.classList.remove("hidden");
    } else {
        pwd.type = "password";
        eyeClosed.classList.add("hidden");
        eyeOpen.classList.remove("hidden");
    }
}

document.getElementById("roleSelect").addEventListener("change", function () {
    const role = this.value;
    const input = document.getElementById("usernameInput");

    if (role === "admin") {
        input.placeholder = "Admin 1";
    } else if (role === "operator") {
        input.placeholder = "Operator 1";
    }
});
</script>
</body>
</html>