<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-PRONOC Login </title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('image/tab1.png') }}" />
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom font for a cleaner look */
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Set a custom background image with fallback color */
        .office-bg {
            /* Placeholder image URL for the background */
            background-image: url('{{ asset('image/background.jpeg') }}'); 
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
        }

        /* Optional: Add a subtle overlay for better text contrast */
        .office-bg::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.2); /* Dark overlay */
            z-index: 0;
        }

        /* Ensure card is above the overlay */
        .login-card {
            z-index: 10;
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
    <!-- Login Card -->
    <div class="login-card w-full max-w-md bg-white p-8 sm:p-10 rounded-xl shadow-2xl backdrop-blur-sm bg-opacity-95">
        
        <!-- Header -->
        <h1 class="text-3xl font-extrabold text-gray-800 mb-2">
            Welcome to <span class="text-pronoc-red">
                E-PRONOC</span>
        </h1>

        <p class="text-sm text-gray-600 mb-6 leading-relaxed">
            Login as reviewer, NOC/KOI and partner?. Click here
            Single Account, Single Sign On login:
        </p>

        <form method="POST" action="{{ route('researcher.login.post') }}">
            @csrf

            <!-- Display errors -->
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Email Input Group -->
            <div class="mb-5">
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Enter your Email"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-pronoc-red focus:ring focus:ring-pronoc-red focus:ring-opacity-50 transition duration-150"
                    required
                >

            <!-- Password Input Group -->
            <div class="mb-5">
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter your Password"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-pronoc-red focus:ring focus:ring-pronoc-red focus:ring-opacity-50 transition duration-150"
                    required
                >
            </div>

            <!-- Sign In Button -->
            <button
                type="submit"
                class="w-full py-3 mt-4 bg-pronoc-red text-white font-bold text-lg rounded-lg shadow-md hover:bg-pronoc-red-dark focus:outline-none focus:ring-4 focus:ring-red-300 transition duration-200 transform hover:scale-[1.01]"
            >
                Sign in
            </button>

            <!-- Register Link -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Don't have an account? 
                    <a href="{{ route('researcher.register') }}" class="font-bold text-pronoc-red hover:text-pronoc-red-dark hover:underline transition duration-200">
                        Register Now
                    </a>
                </p>
            </div>

        </form>
    </div>

</div>

</body>
</html>