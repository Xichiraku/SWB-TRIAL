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

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-100px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(100px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes slideInTop {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
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

        .card-shadow-blur {
            position: relative;
        }

        .card-shadow-blur::before {
            content: '';
            position: absolute;
            right: -60px;
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

<div class="min-h-screen flex items-center justify-center bg-white px-4 sm:px-6">

    <!-- NOTIFICATION -->
    <div class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50">
        @if($errors->has('login'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-3 rounded-lg text-sm shadow-lg animate-slide-top">
                {{ $errors->first('login') }}
            </div>
        @elseif(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-3 rounded-lg text-sm shadow-lg animate-slide-top">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <div class="max-w-5xl w-full">
        <!-- GRID RESPONSIVE -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-center">

            <!-- LEFT SIDE (HIDE DI MOBILE) -->
            <div class="hidden lg:flex flex-col w-full animate-slide-left" style="animation-delay:0.2s;">

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

                <img src="{{ asset('assets/images/gambar1.png') }}" class="w-64 mx-auto mb-2">

                <p class="italic text-gray-700 text-base">
                    "Bersih dimulai dari kesadaran."
                </p>
            </div>

            <!-- RIGHT SIDE -->
            <div class="animate-slide-right w-full">
                <div class="bg-white rounded-3xl shadow-2xl p-6 sm:p-7 w-full card-shadow-blur">

                    <div class="text-center mb-5">
                        <img src="{{ asset('assets/images/logo.png') }}" class="w-32 mx-auto mb-1">
                        <h2 class="text-xl font-bold text-gray-900 -mt-6">Smart Waste Monitor</h2>
                        <p class="text-gray-700 text-xs mt-1">
                            Selamat Datang Kembali! Silakan masuk ke akun anda
                        </p>
                    </div>

                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf

                        <!-- ROLE -->
                        <label class="block text-gray-800 font-semibold mb-1 text-sm">Role</label>
                        <select name="role" id="roleSelect"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 mb-3">
                            <option value="admin">Admin</option>
                            <option value="operator">Operator</option>
                        </select>

                        <!-- USERNAME -->
                        <label class="block text-gray-800 font-semibold mb-1 text-sm">Username</label>
                        <input name="username" type="text" placeholder="Admin1"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm mb-3 focus:ring-2 focus:ring-blue-500"
                               required>

                        <!-- PASSWORD -->
                        <label class="block text-gray-800 font-semibold mb-1 text-sm">Password</label>
                        <div class="relative mb-5">
                            <input id="passwordField" name="password" type="password"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 pr-10 text-sm focus:ring-2 focus:ring-blue-500"
                                   required>

                            <button type="button" onclick="togglePassword()"
                                    class="absolute right-3 top-2.5 text-gray-500">
                                👁
                            </button>
                        </div>

                        <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg font-semibold text-sm transition">
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
    const f = document.getElementById('passwordField');
    f.type = f.type === 'password' ? 'text' : 'password';
}
</script>

</body>
</html>
