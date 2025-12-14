<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-PRONOC{{ isset($title) ? ' | ' . $title : '' }}</title>

    <link rel="shortcut icon" type="image/png" href="{{ asset('image/tab1.png') }}" />
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Quill --}}
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @livewireStyles
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased">
    
    {{-- 1. INCLUDE SIDEBAR --}}
    {{-- PENTING: Pastikan nama folder Anda benar. 
         Jika folder Anda bernama 'component', gunakan 'component.sidebar'. 
         Jika 'components', gunakan 'components.sidebar'. --}}
    @include('components.sidebar')

{{-- 2. NAVBAR --}}
    <nav class="bg-white border-b border-gray-200 px-4 py-2.5 fixed left-0 right-0 top-0 z-50 shadow-sm">
        <div class="flex flex-wrap justify-between items-center w-full">
            <div class="flex justify-start items-center">
                {{-- TOMBOL HAMBURGER --}}
                <button id="hamburger" aria-expanded="false" class="p-2 mr-2 text-gray-600 rounded-lg cursor-pointer hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 focus:ring-2 focus:ring-gray-200 transition-colors">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                </button>

                {{-- BRANDING --}}
                <a href="/dashboard" class="flex items-center gap-3 group">
                    {{-- UBAH h-8 MENJADI h-14 (atau lebih besar sesuai selera) --}}
                    <img src="{{ asset('image/image.png') }}" 
                        alt="E-PRONOC Logo" 
                        class="h-14 w-auto object-contain group-hover:scale-105 transition-transform duration-200" />
                        
                    {{-- <span class="self-center text-2xl whitespace-nowrap select-none">
                        <span class="font-extrabold text-gray-800 tracking-tight">E-</span><span class="font-black text-red-600 tracking-tight">PRONOC</span>
                    </span> --}}
                </a>
            </div>
            
            {{-- Bagian Kanan Navbar --}}
            <div class="flex items-center gap-4 lg:order-2">
                
                {{-- LANGUAGE DROPDOWN
                <div class="relative">
                    <button id="langButton" class="flex items-center gap-2 text-gray-600 hover:text-gray-900 focus:outline-none font-medium text-sm px-3 py-2 rounded-lg hover:bg-gray-50">
                        @if(app()->getLocale() == 'id')
                            <span class="text-xl">🇮🇩</span> <span>ID</span>
                        @else
                            <span class="text-xl">🇬🇧</span> <span>EN</span>
                        @endif
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button> --}}
                    
                    {{-- Dropdown Menu
                    <div id="langDropdown" class="hidden absolute right-0 mt-2 w-32 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-50">
                        <a href="{{ route('switch.language', 'id') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                            <span class="text-lg">🇮🇩</span> Indonesia
                        </a>
                        <a href="{{ route('switch.language', 'en') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                            <span class="text-lg">🇬🇧</span> English
                        </a>
                    </div>
                </div> --}}

                {{-- Tombol Logout
                <a href="#" class="flex items-center gap-2 text-gray-600 hover:text-red-600 hover:bg-red-50 focus:ring-4 focus:ring-red-100 font-medium rounded-lg text-sm px-4 py-2 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>{{ __('Logout') }}</span>
                </a> --}}
            </div>
        </div>
    </nav>

    {{-- SCRIPT KHUSUS NAVBAR DROPDOWN --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const langBtn = document.getElementById('langButton');
            const langMenu = document.getElementById('langDropdown');

            // Toggle dropdown saat tombol diklik
            langBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                langMenu.classList.toggle('hidden');
            });

            // Tutup dropdown jika klik di luar
            document.addEventListener('click', (e) => {
                if (!langBtn.contains(e.target) && !langMenu.contains(e.target)) {
                    langMenu.classList.add('hidden');
                }
            });
        });
    </script>
    
    {{-- 3. MAIN CONTENT --}}
    <main class="min-h-screen pt-16">
        {{ $slot }}
    </main>
    
    @livewireScripts
</body>
</html>