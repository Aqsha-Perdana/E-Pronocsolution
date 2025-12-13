<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-PRONOC Register</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('image/tab1.png') }}" />

    <script src="https://cdn.tailwindcss.com"></script>
    <!-- <script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script> -->
    <!-- <script>
        grecaptcha.ready(function() {
            grecaptcha.execute("{{ env('RECAPTCHA_SITE_KEY') }}", {action: "register"})
                .then(function(token) {
            document.getElementById('recaptcha_token').value = token;
                });
            });
    </script> -->
    
<style>
    /* Set a custom background image with fallback color */
        .office-bg {
            /* Placeholder image URL for the background */
            background-image: url('{{ asset('image/background.jpeg') }}'); 
            background-position: center; 
            background-size: cover;
            background-repeat: no-repeat;
        }
</style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pronoc-red': '#d62828',
                        'pronoc-red-dark': '#b71d23',
                    },
                }
            }
        }
    </script>
</head>
<body class="antialiased">

<div class="office-bg flex justify-center items-center min-h-screen relative p-4 sm:p-6">

    <div class="login-card w-full max-w-md bg-white p-8 sm:p-10 rounded-xl shadow-2xl backdrop-blur-sm bg-opacity-95">
        
        <h1 class="text-3xl font-extrabold text-gray-800 mb-2">
            Register <span class="text-pronoc-red">E-PRONOC</span>
        </h1>

        <p class="text-sm text-gray-600 mb-6 leading-relaxed">
            Isi data berikut untuk membuat akun baru.
        </p>

        <form method="POST" action="/researcher/create">
            @csrf

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Name -->
            <div class="mb-5">
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       placeholder="Enter your full name"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-pronoc-red focus:ring focus:ring-pronoc-red focus:ring-opacity-50 transition"
                       required>
            </div>

            <!-- Email -->
            <div class="mb-5">
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       placeholder="example@email.com"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-pronoc-red focus:ring focus:ring-pronoc-red focus:ring-opacity-50 transition"
                       required>
            </div>

            <div class="mb-5">
                <label for="institution" class="block text-sm font-semibold text-gray-700 mb-2">Institution</label>
                <input type="text" name="institution" value="{{ old('institution') }}"
                       placeholder="Enter Institution"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-pronoc-red focus:ring focus:ring-pronoc-red focus:ring-opacity-50 transition"
                       required>
            </div>

            <!-- notelp -->
            <div class="mb-5">
                <label for="notelp" class="block text-sm font-semibold text-gray-700 mb-2">Number</label>
                <input type="text" name="notelp" value="{{ old('notelp') }}"
                       placeholder="08xxxxxxxxxx"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-pronoc-red focus:ring focus:ring-pronoc-red focus:ring-opacity-50 transition">
            </div>


            <!-- Password -->
            <div class="mb-5">
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <input type="password" name="password"
                       placeholder="Enter your password"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-pronoc-red focus:ring focus:ring-pronoc-red focus:ring-opacity-50 transition"
                       required>
            </div>

            <!-- Confirm Password -->
            <div class="mb-5">
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                    Confirm Password
                </label>
                <input type="password" name="password_confirmation"
                       placeholder="Re-enter your password"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-pronoc-red focus:ring focus:ring-pronoc-red focus:ring-opacity-50 transition"
                       required>
            </div>

            <!-- CAPTCHA (Google reCAPTCHA Placeholder) -->
            <!-- <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Security Check</label>
                    <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                        @error('g-recaptcha-response')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
            </div> -->

            <!-- Terms & Conditions -->
            <div class="mb-5 flex items-center gap-2">
                <input type="checkbox" name="terms" required class="w-4 h-4">
                <label class="text-sm text-gray-700">
                    I agree to the <a href="#" class="text-pronoc-red font-semibold">Terms & Conditions</a>.
                </label>
            </div>
            <a href="/"
            class="w-full block text-center py-3 mb-3 bg-gray-200 text-gray-700 font-semibold rounded-lg shadow hover:bg-gray-300 transition duration-200"
>               ← Back
            </a>
            <button type="submit"
                    class="w-full py-3 mt-4 bg-pronoc-red text-white font-bold text-lg rounded-lg shadow-md hover:bg-pronoc-red-dark focus:outline-none focus:ring-4 focus:ring-red-300 transition duration-200 transform hover:scale-[1.01]">
                Register
            </button>
        </form>

    </div>
</div>

</body>
</html>