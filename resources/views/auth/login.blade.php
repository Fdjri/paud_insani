<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAUD Insani</title>
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        #shape-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }

        /* Base style untuk semua oval */
        .oval {
            position: absolute;
            background: #568AFF;
            border-radius: 50%;
        }
        
        /* Oval 1 */
        .oval-1 {
            left: -12.08%;
            right: 49.93%;
            top: 57.57%;
            bottom: -41.21%;
        }

        /* Oval 2 (Copy) */
        .oval-2 {
            left: 53.82%;
            right: -26.18%;
            top: -55.23%;
            bottom: 57.85%;
            mix-blend-mode: normal;
            opacity: 0.54;
            transform: rotate(100deg);
        }

        /* Oval 3 (Copy 3) */
        .oval-3 {
            left: -13.89%;
            right: 51.74%;
            top: -23.93%;
            bottom: 40.28%;
            mix-blend-mode: normal;
            opacity: 0.6;
            transform: rotate(160deg);
        }

        /* Oval 4 (Copy 2) */
        .oval-4 {
            left: 53.82%;
            right: -33.68%;
            top: 37.1%;
            bottom: -44.58%;
            transform: rotate(-80deg);
        }
    </style>
</head>
<body class="bg-blue-50"> <div id="shape-container">
        <div class="oval oval-1"></div>
        <div class="oval oval-2"></div>
        <div class="oval oval-3"></div>
        <div class="oval oval-4"></div>
    </div>
    
    <div class="min-h-screen flex items-center justify-center p-4">

        <div id="login-card" class="bg-white/80 backdrop-blur-sm p-8 sm:p-10 rounded-xl shadow-lg w-full max-w-md transition-transform duration-300 ease-in-out">
            
            <div class="text-center mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Login to Account</h1>
                <p class="text-gray-500 mt-2">Please enter your username and password to continue</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" id="username" name="username" required autofocus class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition" placeholder="Your Username">
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition" placeholder="••••••••">
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500">
                            <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <svg id="eye-slash-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.243 4.243L6.228 6.228" />
                            </svg>
                        </button>
                    </div>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                    Sign In
                </button>
            </form>

        </div>
    </div>

    <script>
        const loginCard = document.getElementById('login-card');
        loginCard.addEventListener('mouseenter', () => {
            loginCard.style.transform = 'scale(1.02) translateY(-5px)';
        });
        loginCard.addEventListener('mouseleave', () => {
            loginCard.style.transform = 'scale(1) translateY(0)';
        });

        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        const eyeSlashIcon = document.getElementById('eye-slash-icon');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            eyeIcon.classList.toggle('hidden');
            eyeSlashIcon.classList.toggle('hidden');
        });
    </script>

</body>
</html>