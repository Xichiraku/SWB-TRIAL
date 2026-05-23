<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Waste Monitor - Login</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

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
            right: -40px;
            top: 50%;
            transform: translateY(-50%);
            width: 180px;
            height: 85%;
            background: rgba(93, 128, 93, 0.25);
            filter: blur(45px);
            border-radius: 50%;
            z-index: -1;
        }
    </style>
</head>

<body class="bg-[#f3f3f3]">

<div class="min-h-screen flex items-center justify-center px-6 py-10">

    <!-- NOTIFICATION -->
    <div class="fixed top-5 left-1/2 -translate-x-1/2 z-50">

        @if($errors->has('login'))
            <div class="bg-red-100 border border-red-300 text-red-700 px-6 py-3 rounded-md text-sm shadow-md animate-slide-top">
                {{ $errors->first('login') }}
            </div>

        @elseif(session('success'))
            <div class="bg-[#9AD18B] text-[#234d20] px-8 py-3 rounded-md text-sm shadow-md flex items-center gap-2 animate-slide-top">
                ✅ Login sudah berhasil, anda akan diarahkan ke dashboard →
            </div>
        @endif

    </div>

    <div class="max-w-7xl w-full">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">

            <!-- LEFT SIDE -->
            <div class="hidden lg:flex flex-col items-center text-center animate-slide-left">

                <img src="{{ asset('assets/images/recycle.png') }}"
                     class="w-28 mb-5">

                <h1 class="text-5xl font-extrabold text-[#1E3527] leading-tight mb-6">
                    Smart Waste Monitor
                </h1>

                <p class="text-[#2d2d2d] text-[22px] leading-relaxed mb-8">
                    Kelola sampah dengan cerdas,<br>
                    Pantau volume secara real-time,<br>
                    dan bantu bumi menjadi lebih bersih.
                </p>

                <img src="{{ asset('assets/images/gambar1.png') }}"
                     class="w-[430px] mb-8">

                <p class="italic text-[24px] text-[#2d2d2d]">
                    “Bersih dimulai dari kesadaran.”
                </p>

            </div>

            <!-- RIGHT SIDE -->
            <div class="animate-slide-right w-full">

                <div class="bg-[#f8f8f8] rounded-2xl p-10 shadow-xl card-shadow-blur">

                    <!-- HEADER -->
                    <div class="text-center mb-8">

                        <h2 class="text-4xl font-bold text-black mb-3">
                            Smart Waste Monitor
                        </h2>

                        <p class="text-[#2f2f2f] text-lg">
                            Selamat Datang Kembali! Silakan masuk ke akun anda
                        </p>

                    </div>

                    <!-- FORM -->
                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf

                        <!-- ROLE -->
                        <label class="block text-gray-800 font-semibold mb-2 text-base">
                            Role
                        </label>

                        <select name="role"
                                class="w-full border border-[#8BC98B] rounded-md px-4 py-3 text-base bg-white focus:outline-none focus:ring-2 focus:ring-[#2F5D2F] mb-5">

                            <option value="admin">Admin</option>
                            <option value="operator">Operator</option>

                        </select>

                        <!-- USERNAME -->
                        <label class="block text-gray-800 font-semibold mb-2 text-base">
                            Username
                        </label>

                        <input name="username"
                               type="text"
                               placeholder="Masukkan Username"
                               class="w-full border border-[#8BC98B] rounded-md px-4 py-3 text-base bg-white focus:outline-none focus:ring-2 focus:ring-[#2F5D2F] mb-5"
                               required>

                        <!-- PASSWORD -->
                        <div class="flex justify-between items-center mb-2">

                            <label class="text-gray-800 font-semibold text-base">
                                Password
                            </label>

                            <a href="#"
                               class="text-sm text-gray-600 hover:underline">
                                Forget Password?
                            </a>

                        </div>

                        <div class="relative mb-5">

                            <input id="passwordField"
                                   name="password"
                                   type="password"
                                   placeholder="Masukkan Password"
                                   class="w-full border border-[#8BC98B] rounded-md px-4 py-3 pr-12 text-base bg-white focus:outline-none focus:ring-2 focus:ring-[#2F5D2F]"
                                   required>

                            <button type="button"
                                    onclick="togglePassword()"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 text-lg">

                                👁️

                            </button>

                        </div>

                        <!-- TERM -->
                        <div class="flex items-center gap-2 mb-8">

                            <input type="checkbox"
                                   class="w-4 h-4">

                            <label class="text-sm text-gray-700">
                                I Agree to the Term & Condition
                            </label>

                        </div>

                        <!-- BUTTON -->
                        <button type="submit"
                                class="w-full bg-[#2F5D2F] hover:bg-[#234723] text-white py-3 rounded-md font-semibold text-lg transition duration-300">

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

        const passwordField = document.getElementById('passwordField');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
        } else {
            passwordField.type = 'password';
        }
    }
</script>

</body>
</html>