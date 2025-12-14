<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            Profile
        </h2>
    </x-slot>
</x-app-layout>

<div class="pt-24 min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 flex justify-center items-start">
    <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-8 max-w-xl w-full text-center transition-transform transform hover:scale-105">
        
        {{-- Avatar dengan gradient border --}}
        <div class="relative w-44 h-44 mx-auto mb-8">
            <div class="absolute inset-0 rounded-full bg-gradient-to-r from-red-500 via-pink-500 to-red-500 blur-lg opacity-40 animate-pulse"></div>
            <div class="relative w-44 h-44 rounded-full overflow-hidden border-4 border-white dark:border-gray-700 shadow-lg transition-transform duration-300 hover:scale-105">
                @if ($user->photo)
                    <img src="{{ asset('storage/profile/' . $user->photo) }}"
                         alt="Profile Photo"
                         class="w-full h-full object-cover">
                @else
                    <img src="{{ asset('images/default-avatar.png') }}"
                         alt="Default Avatar"
                         class="w-full h-full object-cover">
                @endif
            </div>
        </div>

        {{-- User Info --}}
        <div class="space-y-6 text-left mx-auto w-3/4">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-user text-red-500"></i>
                <p class="text-gray-800 dark:text-gray-200 font-semibold text-lg">{{ $user->name ?? '-' }}</p>
            </div>
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-phone text-red-500"></i>
                <p class="text-gray-800 dark:text-gray-200 font-semibold text-lg">{{ $user->notelp ?? '-' }}</p>
            </div>
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-building text-red-500"></i>
                <p class="text-gray-800 dark:text-gray-200 font-semibold text-lg">{{ $user->institution ?? '-' }}</p>
            </div>
        </div>

        {{-- Edit Button --}}
        <a href="editprofile"
           class="mt-10 inline-block px-10 py-3 rounded-xl bg-gradient-to-r from-red-500 to-red-700 text-white font-semibold shadow-lg
                  hover:scale-105 hover:shadow-2xl transition-all duration-300 transform">
            Edit My Personal Data
        </a>

        {{-- Logout --}}
        <div class="flex items-center gap-3 mt-6 justify-center">
            <a href="admin/logout"
               class="flex items-center gap-2 px-6 py-2 rounded-xl font-semibold border-2 border-red-500
                      text-red-500 bg-white dark:bg-gray-700 shadow hover:scale-105 hover:shadow-xl transition-all duration-300">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        </div>

        {{-- Decorative background shapes --}}
        <div class="absolute -top-10 -left-10 w-32 h-32 bg-red-200 rounded-full opacity-20 blur-2xl animate-pulse"></div>
        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-pink-200 rounded-full opacity-20 blur-2xl animate-pulse delay-200"></div>
    </div>
</div>
