<header class="fixed top-0 left-0 w-full z-50 bg-white shadow-md py-3 px-6 flex items-center justify-between h-16">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>E-PRONOC - Kolaborasi Lebih Mudah, Persetujuan Lebih Cepat</title>
    <link rel="shortcut icon" type="image/png" href="image/tab1.png" />
    <script src="//unpkg.com/alpinejs" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>[x-cloak]{ display:none !important }</style>

    {{-- Logo --}}
    <div class="flex items-center gap-3">
        <img src="/images/image.png" alt="Logo" class="h-12 w-auto transition-transform duration-300 hover:scale-105">
    </div>

    {{-- Navigation --}}
    <nav class="hidden md:flex items-center gap-3">
        @php
            $links = [
                ['route' => 'dashboard-admin', 'icon' => 'fa-house', 'label' => 'Dashboard'],
                ['route' => 'proposal', 'icon' => 'fa-folder', 'label' => 'Proposal: Selection'],
                ['route' => 'information', 'icon' => 'fa-circle-info', 'label' => 'Information Center'],
                ['route' => 'profileadmin', 'icon' => 'fa-user', 'label' => 'Profile'],
            ];
        @endphp

        @foreach($links as $link)
            <a href="{{ route($link['route']) }}"
               class="px-4 py-2 rounded-md flex items-center gap-2 transition-all duration-200
               {{ request()->routeIs($link['route']) ? 'bg-red-600 text-white shadow-lg' : 'bg-gray-200 text-black hover:bg-gray-300 hover:shadow-md transform hover:-translate-y-0.5' }}">
                <i class="fa-solid {{ $link['icon'] }} {{ request()->routeIs($link['route']) ? 'text-white' : 'text-black transition-transform duration-200 hover:scale-110' }}"></i>
                {{ $link['label'] }}
            </a>
        @endforeach
    </nav>

    {{-- User actions --}}
    <div class="flex items-center gap-3">
        {{-- Notification --}}
        <button class="p-2 rounded-full bg-gray-200 hover:bg-gray-300 transition-all duration-200 hover:scale-110">
            <i class="fa-solid fa-bell"></i>
        </button>

        {{-- Settings / Profile Dropdown --}}
    </div>

    {{-- Mobile Hamburger --}}
    <div class="md:hidden" x-data="{ open: false }">
        <button @click="open = !open" class="p-2 rounded-md bg-gray-200 hover:bg-gray-300 transition duration-200">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div x-show="open" @click.outside="open = false" x-cloak
             class="absolute top-full left-0 w-full bg-white shadow-md flex flex-col gap-2 p-4 z-40">
            @foreach($links as $link)
                <a href="{{ route($link['route']) }}" class="px-4 py-2 rounded-md flex items-center gap-2 
                   {{ request()->routeIs($link['route']) ? 'bg-red-600 text-white' : 'bg-gray-200 text-black hover:bg-gray-300' }}">
                    <i class="fa-solid {{ $link['icon'] }}"></i>
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>
    </div>
</header>
