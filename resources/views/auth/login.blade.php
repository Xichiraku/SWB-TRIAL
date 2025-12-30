<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Waste Monitor - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        /* Animasi masuk dari kiri */
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        /* Animasi masuk dari kanan */
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Animasi masuk dari atas untuk notification */
        @keyframes slideInTop {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-slide-left {
            animation: slideInLeft 0.8s ease-out forwards;
        }
        
        .animate-slide-right {
            animation: slideInRight 0.8s ease-out forwards;
            opacity: 0;
        }

        .animate-slide-top {
            animation: slideInTop 0.5s ease-out forwards;
        }

        /* Shadow blur effect untuk login card - BIRU DI SISI KIRI */
        .card-shadow-blur {
            position: relative;
        }
        
        .card-shadow-blur::before {
            content: '';
            position: absolute;
            left: -60px;
            top: 50%;
            transform: translateY(-50%);
            width: 120px;
            height: 80%;
            background: radial-gradient(ellipse, rgba(3, 106, 202, 0.5), rgba(59, 130, 246, 0.2));
            border-radius: 50%;
            filter: blur(50px);
            z-index: -1;
            opacity: 0.9;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50">
<div class="min-h-screen flex items-center justify-center bg-white px-4">

    <!-- NOTIFICATION CONTAINER - DI ATAS TENGAH -->
    <div class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50">
        @if($errors->has('login'))
            <!-- ERROR MESSAGE -->
            <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-3 rounded-lg text-sm shadow-lg animate-slide-top inline-block">
                {{ $errors->first('login') }}
            </div>
        @elseif(session('success'))
            <!-- SUCCESS MESSAGE -->
            <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-3 rounded-lg text-sm shadow-lg animate-slide-top inline-block">
                {{ session('success') }}
            </div>
        @else
            <!-- PREVIEW DEMO - Hapus bagian ini pas di Laravel -->
            <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-3 rounded-lg text-sm shadow-lg animate-slide-top inline-block">
                Login berhasil! Mengalihkan...
            </div>
        @endif
    </div>

    <div class="max-w-5xl w-full">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-center">

        <!-- LEFT SIDE -->
        <div class="flex flex-col w-full animate-slide-left" style="animation-delay: 0.2s;">
            <!-- GAMBAR UTAMA / ILUSTRATION -->
            <img src="{{ asset('assets/images/recycle.png') }}" 
                class="w-24 mx-auto mb-2"
                style="filter: brightness(0) saturate(100%) invert(29%) sepia(92%) saturate(3000%) hue-rotate(190deg) brightness(95%) contrast(100%);">

            <h1 class="text-3xl font-extrabold text-gray-800 mb-2">
                Smart Waste Monitor
            </h1>

            <p class="text-gray-700 text-base leading-relaxed mb-3">
                Kelola sampah dengan cerdas, Pantau volume secara real-time,<br>
                dan bantu bumi menjadi lebih bersih.
            </p>

            <!-- GAMBAR KEDUA -->
            <img src="{{ asset('assets/images/gambar1.png') }}" 
                alt="additional illustration" 
                class="w-64 mx-auto mb-2">

            <p class="italic text-gray-700 text-base">
                "Bersih dimulai dari kesadaran."
            </p>

        </div>

        <!-- RIGHT SIDE - LOGIN BOX -->
        <div class="animate-slide-right lg:ml-4">
            <div class="bg-white rounded-3xl shadow-2xl p-7 w-full card-shadow-blur">
                <div class="text-center mb-5">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="logo" class="w-32 mx-auto mb-0.5">
                    <h2 class="text-xl font-bold text-gray-900 mt-[-30px]">Smart Waste Monitor</h2>
                    <p class="text-gray-700 text-xs mt-1">Selamat Datang Kembali! Silakan masuk ke akun anda</p>
                </div>

                <!-- ERROR MESSAGE -->
                @if($errors->has('login'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                        {{ $errors->first('login') }}
                    </div>
                @endif

                <!-- SUCCESS MESSAGE -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    
                    <label class="block text-gray-800 font-semibold mb-1 text-sm">Role</label>
                    <select name="role" id="roleSelect" 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-left focus:outline-none focus:ring-2 focus:ring-blue-500 mb-3">
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="operator" {{ old('role') == 'operator' ? 'selected' : '' }}>Operator</option>
                    </select>

                    <!-- USERNAME -->
                    <label class="block text-gray-800 font-semibold mb-1 text-sm">Username</label>
                    <div class="relative mb-3">
                        <input 
                            id="usernameInput"
                            name="username"
                            type="text" 
                            placeholder="Admin1"
                            value="{{ old('username') }}"
                            required
                            class="w-full border border-gray-300 rounded-lg px-3 pr-10 py-2 text-sm text-left focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        
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
                    </div>

                    <!-- PASSWORD -->
                    <label class="block text-gray-800 font-semibold mb-1 text-sm">Password</label>
                    <div class="relative mb-5">
                        <input id="passwordField" 
                               name="password"
                               type="password" 
                               placeholder="•••••••"
                               required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

                        <!-- EYE ICON (SHOW/HIDE) -->
                        <button type="button" onclick="togglePassword()" 
                                class="absolute right-3 top-2.5 text-gray-500 cursor-pointer hover:text-gray-700">
                            <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" 
                                class="w-5 h-5" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" 
                                class="w-5 h-5 hidden" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a21.77 21.77 0 0 1 5.06-5.94"/>
                                <path d="M1 1l22 22"/>
                            </svg>
                        </button>
                    </div>

                    <!-- LOGIN BUTTON -->
                    <button type="submit" id="loginButton" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg font-semibold text-sm transition-all duration-200 transform hover:scale-[1.02]">
                        Login
                    </button>
                </form>
            </div>
        </div>
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
        input.placeholder = "Admin1";
    } else if (role === "operator") {
        input.placeholder = "Operator1";
    }
});

// Handle login berhasil - tampilkan notifikasi dulu baru redirect
document.querySelector('form').addEventListener('submit', function(e) {
    // Kalau mau tampilin "Login berhasil" sebelum redirect,
    // ini harus dihandle dari backend Laravel dengan:
    // 1. Set session success
    // 2. Redirect ke halaman login lagi sebentar dengan pesan
    // 3. Auto redirect ke dashboard setelah 1-2 detik
    
    // Atau bisa pakai JavaScript redirect dengan delay
    // Tapi lebih baik handle dari backend Laravel
});
</script>
</body>
</html>