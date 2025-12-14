<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('information') }}
        </h2>
    </x-slot>
</x-app-layout>

<<div class="pt-24">
    <div class="max-w-screen-xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg p-6 min-h-[200px] flex flex-col items-center justify-start text-center">

            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4">
                USER GUIDE
            </h2>

            <p class="text-gray-600 dark:text-gray-300">
                Klik link berikut untuk mengunduh panduan pengguna:
            </p>

            <a href="{{ asset('files/user-guide.pdf') }}" 
               class="text-blue-600 hover:underline font-semibold mt-3"
               download>
                Download User Guide di sini
            </a>

        </div>
    </div>
</div>

            