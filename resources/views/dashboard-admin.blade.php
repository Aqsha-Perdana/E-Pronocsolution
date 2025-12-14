<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('dashboard') }}
        </h2>
    </x-slot>
</x-app-layout>

@php
    // Jika $skills belum didefinisikan oleh controller, ambil dari user yang login (jika tersedia).
    if (!isset($skills)) {
        if (auth()->check() && method_exists(auth()->user(), 'skills')) {
            $skills = auth()->user()->skills()->get();
        } else {
            $skills = collect();
        }
    }

    // Normalisasi: dukung Collection of models, array, atau plain strings.
    $skillsData = collect($skills)->map(function ($s) {
        if (is_array($s)) {
            return [
                'id' => $s['id'] ?? null,
                'skill' => $s['skill'] ?? ($s[0] ?? '')
            ];
        }
        if (is_object($s)) {
            // Model instance
            return [
                'id' => $s->id ?? null,
                'skill' => $s->skill ?? ''
            ];
        }
        // plain string
        return [
            'id' => null,
            'skill' => (string) $s
        ];
    })->values()->toArray();

    // Ambil proposal terbaru dengan status SUBMITTED
    $recentProposals = \App\Models\Proposal::where('status', 'SUBMITTED')
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();
    
    // Ambil progress report terbaru HANYA dari proposal yang APPROVED
    $recentProgressReports = \App\Models\ProgressReport::with('proposal')
        ->whereNotNull('proposal_id')
        ->whereHas('proposal', function($query) {
            $query->where('status', 'APPROVED'); // Hanya proposal yang approved
        })
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();
    
    // Gabungkan dan urutkan
    $allNotifications = collect();
    
    foreach($recentProposals as $proposal) {
        $allNotifications->push([
            'type' => 'proposal',
            'data' => $proposal,
            'created_at' => $proposal->created_at
        ]);
    }
    
    foreach($recentProgressReports as $report) {
        // Skip jika proposal tidak ada atau status bukan APPROVED
        if ($report->proposal && $report->proposal->status === 'APPROVED') {
            $allNotifications->push([
                'type' => 'progress_report',
                'data' => $report,
                'created_at' => $report->created_at
            ]);
        }
    }
    
    $allNotifications = $allNotifications->sortByDesc('created_at')->take(8);
    
    // Total proposals dengan status SUBMITTED
    $totalProposals = \App\Models\Proposal::where('status', 'SUBMITTED')->count();
    
    // Total progress reports HANYA dari proposal yang APPROVED
    $totalReports = \App\Models\ProgressReport::whereHas('proposal', function($query) {
        $query->where('status', 'APPROVED');
    })->count();

    use Carbon\Carbon;
    
    $startDate = Carbon::now()->subDays(30);
    $endDate = Carbon::now();
    
    // Statistik 30 hari terakhir
    $proposalsSubmitted = \App\Models\Proposal::where('status', 'SUBMITTED')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->count();
    
    $proposalsApproved = \App\Models\Proposal::where('status', 'APPROVED')
        ->whereBetween('updated_at', [$startDate, $endDate])
        ->count();
    
    $proposalsRejected = \App\Models\Proposal::where('status', 'REJECTED')
        ->whereBetween('updated_at', [$startDate, $endDate])
        ->count();
    
    $progressReportsSubmitted = \App\Models\ProgressReport::whereBetween('created_at', [$startDate, $endDate])
        ->count();
    
    // Data untuk chart (7 hari terakhir)
    $labels = [];
    $proposalData = [];
    $reportData = [];
    
    for ($i = 6; $i >= 0; $i--) {
        $date = Carbon::now()->subDays($i);
        $dayStart = $date->copy()->startOfDay();
        $dayEnd = $date->copy()->endOfDay();
        
        $labels[] = $date->format('D');
        $proposalData[] = \App\Models\Proposal::where('status', 'SUBMITTED')
            ->whereBetween('created_at', [$dayStart, $dayEnd])
            ->count();
        $reportData[] = \App\Models\ProgressReport::whereBetween('created_at', [$dayStart, $dayEnd])
            ->count();
    }
    $percentage = $notification['data']->percentage_complete ?? 0;
    $progressColor = $percentage >= 80 ? 'bg-green-500' : ($percentage >= 50 ? 'bg-yellow-500' : 'bg-red-500');
    $progressGlow = $percentage >= 80 ? 'shadow-green-500/50' : ($percentage >= 50 ? 'shadow-yellow-500/50' : 'shadow-red-500/50');
$totalFinalReports = $allNotifications->where('type', 'final_report')->count();
    
@endphp

<style>
@keyframes shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
}

@keyframes slide {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

.animate-shimmer {
    animation: shimmer 2s infinite;
}

.animate-slide {
    animation: slide 2s infinite;
}
</style>

<div class="pt-24">
    <div class="max-w-screen-3xl mx-auto sm:px-6 lg:px-8">

        <!-- GRID 3 KOLOM PADA DESKTOP (1:profil, 2:konten kanan) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- BAGIAN KIRI (Profil) -->
            <div class="flex justify-center">
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden w-full max-w-2xl">
        
        <!-- Header Background with Gradient -->
        <div class="relative h-32 bg-gradient-to-r from-red-600 via-red-500 to-pink-500">
            <div class="absolute inset-0 bg-black opacity-10"></div>
            <!-- Decorative Circles -->
            <div class="absolute top-4 right-8 w-20 h-20 bg-white opacity-10 rounded-full"></div>
            <div class="absolute bottom-2 right-20 w-16 h-16 bg-white opacity-10 rounded-full"></div>
            <div class="absolute top-8 left-12 w-12 h-12 bg-white opacity-10 rounded-full"></div>
        </div>

        <!-- Profile Photo - Overlapping Header -->
        <div class="relative px-6 pb-6">
            <div class="flex flex-col items-center -mt-20">
                <!-- Photo Container with Ring -->
                <div class="relative">
                    <div class="w-40 h-40 rounded-full overflow-hidden border-4 border-white shadow-2xl bg-white">
                        @if ($user->photo)
                            <img src="{{ asset('storage/profile/' . $user->photo) }}"
                                 alt="Profile Photo"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-red-400 to-pink-500 flex items-center justify-center">
                                <span class="text-white text-5xl font-bold">
                                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <!-- Online Status Badge -->
                    <div class="absolute bottom-2 right-2 w-6 h-6 bg-green-500 rounded-full border-4 border-white"></div>
                </div>

                <!-- User Name & Role -->
                <div class="text-center mt-4">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                        {{ $user->name ?? 'User Name' }}
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Admin
                    </p>
                </div>
            </div>

            <!-- Information Cards Grid -->
            <div class="mt-8 space-y-3">
                <!-- Email Card -->
                <div class="group bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all duration-300 border border-transparent hover:border-red-200 dark:hover:border-red-800">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-pink-500 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Email Address</p>
                            <p class="text-sm font-semibold text-gray-800 dark:text-white truncate mt-0.5">
                                {{ $user->email ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Phone Card -->
                <div class="group bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-300 border border-transparent hover:border-blue-200 dark:hover:border-blue-800">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Phone Number</p>
                            <p class="text-sm font-semibold text-gray-800 dark:text-white truncate mt-0.5">
                                {{ $user->notelp ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Institution Card -->
                <div class="group bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-all duration-300 border border-transparent hover:border-purple-200 dark:hover:border-purple-800">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Institution</p>
                            <p class="text-sm font-semibold text-gray-800 dark:text-white truncate mt-0.5">
                                {{ $user->institution ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 space-y-3">
                <!-- Edit Profile Button -->
                <a href="{{ route('editprofile') }}"
                   class="group relative w-full flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-red-600 to-pink-600 text-white font-semibold rounded-xl overflow-hidden transition-all duration-300 hover:shadow-lg hover:scale-[1.02] active:scale-[0.98]">
                    <div class="absolute inset-0 bg-gradient-to-r from-red-700 to-pink-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <svg class="w-5 h-5 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span class="relative z-10">Edit My Personal Data</span>
                </a>

                <!-- Logout Button -->
                <a href="admin/logout"
                   class="group relative w-full flex items-center justify-center gap-2 px-6 py-3.5 bg-white dark:bg-gray-700 text-red-600 dark:text-red-400 font-semibold rounded-xl border-2 border-red-600 dark:border-red-500 overflow-hidden transition-all duration-300 hover:bg-red-50 dark:hover:bg-red-900/20 hover:shadow-md hover:scale-[1.02] active:scale-[0.98]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </div>
</div>

            <!-- BAGIAN KANAN (Isinya 3 kotak) -->
            <div class="lg:col-span-2 flex flex-col gap-6">
<!-- Keahlian -->
<div x-data="{
        open: false,
        skills: {{ json_encode($skillsData) }},
        newSkill: ''
    }"
    class="bg-gradient-to-br from-white to-red-50 dark:from-gray-800 dark:to-gray-900 shadow-xl rounded-2xl p-6 relative border-2 border-red-100 dark:border-red-900/30 overflow-hidden"
>
    <!-- Decorative Background Elements -->
    <div class="absolute top-0 right-0 w-32 h-32 bg-red-500/5 rounded-full -mr-16 -mt-16"></div>
    <div class="absolute bottom-0 left-0 w-24 h-24 bg-rose-500/5 rounded-full -ml-12 -mb-12"></div>

    <!-- Header -->
    <div class="flex justify-between items-center mb-6 relative z-10">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Keahlian</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400" x-text="skills.length + ' skills'"></p>
            </div>
        </div>

        <button @click="open = true"
                class="group relative p-3 rounded-xl hover:bg-red-100 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400 transition-all duration-300 hover:scale-110">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full animate-ping"></span>
            <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full"></span>
        </button>
    </div>

    <!-- List Skill with Enhanced Design -->
    <div class="relative z-10">
        <template x-if="skills.length > 0">
            <div class="flex flex-wrap gap-2.5">
                <template x-for="(skill, index) in skills" :key="skill.id">
                    <span class="group relative px-4 py-2 bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/30 dark:to-red-800/30 text-red-700 dark:text-red-300 rounded-full text-sm font-medium border border-red-200 dark:border-red-700 hover:shadow-lg hover:scale-105 transition-all duration-300 cursor-default">
                        <span class="relative z-10" x-text="skill.skill"></span>
                        <div class="absolute inset-0 bg-gradient-to-r from-red-500/0 to-red-500/10 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </span>
                </template>
            </div>
        </template>

        <template x-if="skills.length === 0">
            <div class="text-center py-12">
                <div class="w-20 h-20 mx-auto mb-4 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
                <p class="text-gray-500 dark:text-gray-400 text-sm mb-3">Belum ada keahlian ditambahkan</p>
                <button @click="open = true"
                        class="text-red-600 dark:text-red-400 text-sm font-medium hover:underline">
                    + Tambah Keahlian Pertama
                </button>
            </div>
        </template>
    </div>

    <!-- MODAL with Enhanced Design -->
    <div 
        x-cloak
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[9999] flex items-center justify-center p-4"
        @click.self="open = false"
    >
        <div 
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="bg-white dark:bg-gray-900 w-full max-w-md rounded-2xl shadow-2xl overflow-hidden"
            @click.stop
        >
            <!-- Modal Header with Gradient -->
            <div class="bg-gradient-to-r from-red-500 to-red-600 p-6 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold">Edit Keahlian</h2>
                            <p class="text-xs text-red-100" x-text="skills.length + ' skills terdaftar'"></p>
                        </div>
                    </div>
                    <button @click="open = false"
                            class="w-8 h-8 rounded-lg hover:bg-white/20 flex items-center justify-center transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="p-6">
                <!-- Input with Icon -->
                <div class="relative">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <input 
                        x-ref="skillInput"
                        type="text"
                        placeholder="Tambah keahlian baru..."
                        class="w-full pl-10 pr-24 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl bg-gray-50 dark:bg-gray-800 focus:border-red-500 focus:ring-4 focus:ring-red-500/20 transition-all outline-none text-gray-900 dark:text-gray-100"
                        @keydown.enter="
                            if ($refs.skillInput.value.trim() !== '') {
                                skills.push({ id: null, skill: $refs.skillInput.value.trim() });
                                $refs.skillInput.value='';
                            }
                        "
                    >
                    <button 
                        @click="
                            if ($refs.skillInput.value.trim() !== '') {
                                skills.push({ id: null, skill: $refs.skillInput.value.trim() });
                                $refs.skillInput.value='';
                            }
                        "
                        class="absolute right-2 top-1/2 -translate-y-1/2 px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-lg text-sm font-medium shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105"
                    >
                        Tambah
                    </button>
                </div>

                <!-- Daftar skill dalam modal with Enhanced Cards -->
                <div class="mt-5">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Daftar Keahlian</h3>
                        <span class="text-xs text-gray-500 dark:text-gray-400" x-text="skills.length + ' items'"></span>
                    </div>
                    
                    <div class="space-y-2 max-h-64 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-red-500 scrollbar-track-gray-200 dark:scrollbar-track-gray-800">
                        <template x-for="(skill, index) in skills" :key="index">
                            <div class="group flex items-center justify-between bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 p-3 rounded-xl border border-gray-200 dark:border-gray-600 hover:shadow-md hover:scale-[1.02] transition-all duration-300">
                                <div class="flex items-center gap-3 flex-1 min-w-0">
                                    <div class="w-2 h-2 bg-red-500 rounded-full flex-shrink-0"></div>
                                    <span class="font-medium text-gray-800 dark:text-gray-200 truncate" x-text="skill.skill"></span>
                                </div>

                                <button 
                                    @click="skills.splice(index, 1)"
                                    class="flex-shrink-0 p-2 text-red-500 hover:text-red-600 dark:text-red-400 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all duration-300 opacity-0 group-hover:opacity-100"
                                    title="Hapus"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </template>

                        <template x-if="skills.length === 0">
                            <div class="text-center py-8 text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p class="text-sm">Belum ada keahlian</p>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex gap-3">
                    <button 
                        @click="open = false"
                        class="flex-1 px-4 py-3 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl font-medium transition-all duration-300 hover:shadow-lg"
                    >
                        Batal
                    </button>
                    <button 
                        @click="
                            fetch('{{ route('skills.updateSkills') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({ skills })
                            })
                            .then(res => res.json())
                            .then(data => {
                                console.log(data);
                                open = false;
                            });
                        "
                        class="flex-1 px-4 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-xl font-medium shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 flex items-center justify-center gap-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
                <!-- Recent Proposal -->
                <!-- Add this style section at the top of your blade file -->
<style>
@keyframes shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
}

@keyframes slide {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

.animate-shimmer {
    animation: shimmer 2s infinite;
}

.animate-slide {
    animation: slide 2s infinite;
}
</style>

<!-- Recent Activities with Tabs -->
<div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6 min-h-[200px]">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold">Recent Activities</h3>
        <div class="flex items-center gap-2">
            <span class="text-xs text-gray-500">{{ $allNotifications->count() }} recent</span>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="flex gap-2 mb-4 border-b border-gray-200 dark:border-gray-700 overflow-x-auto">
        <button onclick="filterNotifications('all')" class="filter-tab active px-4 py-2 text-sm font-medium border-b-2 border-gray-900 dark:border-white transition-colors whitespace-nowrap">
            All <span class="ml-1 text-xs text-gray-500">({{ $allNotifications->count() }})</span>
        </button>
        <button onclick="filterNotifications('proposal')" class="filter-tab px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300 transition-colors whitespace-nowrap">
            Proposals <span class="ml-1 px-1.5 py-0.5 text-xs bg-red-100 text-red-600 rounded-full">{{ $totalProposals }}</span>
        </button>
        <button onclick="filterNotifications('progress_report')" class="filter-tab px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300 transition-colors whitespace-nowrap">
            Progress Report <span class="ml-1 px-1.5 py-0.5 text-xs bg-blue-100 text-blue-600 rounded-full">{{ $totalReports }}</span>
        </button>
        <button onclick="filterNotifications('final_report')" class="filter-tab px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300 transition-colors whitespace-nowrap">
            Final Report <span class="ml-1 px-1.5 py-0.5 text-xs bg-purple-100 text-purple-600 rounded-full">{{ $totalFinalReports }}</span>
        </button>
    </div>

    <!-- Notifications List -->
    @if($allNotifications->count() > 0)
        <div class="space-y-2 max-h-[400px] overflow-y-auto">
            @foreach($allNotifications as $notification)
                <div class="notification-item" data-type="{{ $notification['type'] }}">
                    @if($notification['type'] === 'proposal')
                        {{-- Proposal Notification (Red) - CLICKABLE --}}
                        <a href="{{ route('proposalsel.review', $notification['data']->id) }}" 
                           class="group flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-all cursor-pointer border-l-4 border-red-500 hover:shadow-md">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="flex-shrink-0 w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                                    <span class="text-xs font-medium text-red-600">New Proposal</span>
                                    <span class="text-xs text-gray-400">•</span>
                                    <span class="text-xs text-gray-500">{{ $notification['data']->registration_code ?? 'N/A' }}</span>
                                </div>
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate group-hover:text-red-600 transition-colors">
                                    {{ $notification['data']->title }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                    {{ $notification['created_at']->diffForHumans() }}
                                </p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        
                    @elseif($notification['type'] === 'progress_report')
                        {{-- Progress Report Notification (Blue) - CLICKABLE --}}
                        @php
                            $progressReport = $notification['data'];
                            $percentage = $progressReport->percentage_complete ?? 0;
                            
                            if ($percentage >= 80) {
                                $progressColor = 'bg-gradient-to-r from-green-500 to-green-600';
                                $progressGlow = 'shadow-green-500/50';
                            } elseif ($percentage >= 50) {
                                $progressColor = 'bg-gradient-to-r from-yellow-500 to-yellow-600';
                                $progressGlow = 'shadow-yellow-500/50';
                            } elseif ($percentage >= 25) {
                                $progressColor = 'bg-gradient-to-r from-orange-500 to-orange-600';
                                $progressGlow = 'shadow-orange-500/50';
                            } else {
                                $progressColor = 'bg-gradient-to-r from-red-500 to-red-600';
                                $progressGlow = 'shadow-red-500/50';
                            }
                        @endphp
                        
                        <a href="{{ route('proposalsel.review', $notification['data']->id) }}" 
                           class="group flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all cursor-pointer border-l-4 border-blue-500 hover:shadow-md">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                                    <span class="text-xs font-medium text-blue-600">Progress Report</span>
                                    <span class="text-xs text-gray-400">•</span>
                                    <span class="text-xs text-gray-500">{{ $notification['data']->proposal->registration_code ?? 'N/A' }}</span>
                                </div>
                                
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate group-hover:text-blue-600 transition-colors">
                                    {{ $notification['data']->proposal->title ?? 'Unknown Proposal' }}
                                </p>
                                
                                <!-- Interactive Progress Bar -->
                                <div class="mt-3 mb-2">
                                    <div class="flex items-center justify-between mb-1.5">
                                        <span class="text-xs font-semibold text-gray-600 dark:text-gray-400">Progress</span>
                                        <span class="text-xs font-bold {{ $percentage >= 80 ? 'text-green-600' : ($percentage >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                                            {{ $percentage }}%
                                        </span>
                                    </div>
                                    
                                    <div class="relative w-full h-2.5 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden shadow-inner">
                                        <div class="absolute inset-0 opacity-20">
                                            <div class="h-full w-full bg-gradient-to-r from-transparent via-white to-transparent animate-shimmer" 
                                                 style="background-size: 200% 100%;"></div>
                                        </div>
                                        
                                        <div class="{{ $progressColor }} h-full rounded-full transition-all duration-1000 ease-out shadow-md {{ $progressGlow }} relative overflow-hidden"
                                             style="width: {{ $percentage }}%;">
                                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-30 animate-slide"></div>
                                            @if($percentage > 0)
                                            <div class="absolute right-0 top-0 h-full w-1 bg-white opacity-60 animate-pulse"></div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="flex justify-between mt-1 px-0.5">
                                        <span class="text-[10px] {{ $percentage >= 25 ? 'text-gray-600 font-medium' : 'text-gray-400' }}">25%</span>
                                        <span class="text-[10px] {{ $percentage >= 50 ? 'text-gray-600 font-medium' : 'text-gray-400' }}">50%</span>
                                        <span class="text-[10px] {{ $percentage >= 75 ? 'text-gray-600 font-medium' : 'text-gray-400' }}">75%</span>
                                        <span class="text-[10px] {{ $percentage >= 100 ? 'text-green-600 font-bold' : 'text-gray-400' }}">100%</span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-2 mt-2">
                                    @if($percentage >= 100)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-green-100 text-green-800 border border-green-200">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            Complete
                                        </span>
                                    @elseif($percentage >= 80)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-green-100 text-green-800 border border-green-200">
                                            <svg class="w-3 h-3 mr-1 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                            Almost Done
                                        </span>
                                    @elseif($percentage >= 50)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                            </svg>
                                            In Progress
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-red-100 text-red-800 border border-red-200">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                            </svg>
                                            Just Started
                                        </span>
                                    @endif
                                    
                                    <span class="text-xs text-gray-400">•</span>
                                    <span class="text-xs text-gray-500">
                                        {{ $notification['created_at']->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        
                    @else
                        {{-- Final Report Notification (Purple) - CLICKABLE --}}
                        @php
                            $finalReport = $notification['data'];
                            $reportStatus = $finalReport->status ?? 'Pending';
                            
                            $statusColor = match(strtolower($reportStatus)) {
                                'done', 'complete', 'completed' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'border' => 'border-green-200'],
                                'approved' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'border' => 'border-blue-200'],
                                'pending', 'review' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'border' => 'border-yellow-200'],
                                'revision', 'needs revision' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-800', 'border' => 'border-orange-200'],
                                default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'border' => 'border-gray-200']
                            };
                        @endphp
                        
                        <a href="{{ route('proposalsel.finalreview', $notification['data']->id) }}" 
                           class="group flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-all cursor-pointer border-l-4 border-purple-500 hover:shadow-md">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="flex-shrink-0 w-2 h-2 bg-purple-500 rounded-full animate-pulse"></span>
                                    <span class="text-xs font-medium text-purple-600">Final Report</span>
                                    <span class="text-xs text-gray-400">•</span>
                                    <span class="text-xs text-gray-500">{{ $notification['data']->proposal->registration_code ?? 'N/A' }}</span>
                                </div>
                                
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate group-hover:text-purple-600 transition-colors">
                                    {{ $notification['data']->proposal->title ?? 'Unknown Proposal' }}
                                </p>
                                
                                <div class="mt-3 grid grid-cols-2 gap-2">
                                    <div class="bg-white dark:bg-gray-800 rounded-lg p-2 border border-gray-200 dark:border-gray-600">
                                        <p class="text-[10px] text-gray-500 dark:text-gray-400 mb-1">Status</p>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium {{ $statusColor['bg'] }} {{ $statusColor['text'] }} {{ $statusColor['border'] }} border">
                                            @if(in_array(strtolower($reportStatus), ['done', 'complete', 'completed']))
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                            @elseif(strtolower($reportStatus) === 'pending')
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                </svg>
                                            @endif
                                            {{ ucfirst($reportStatus) }}
                                        </span>
                                    </div>
                                    
                                    <div class="bg-white dark:bg-gray-800 rounded-lg p-2 border border-gray-200 dark:border-gray-600">
                                        <p class="text-[10px] text-gray-500 dark:text-gray-400 mb-1">Submitted</p>
                                        <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">
                                            {{ $notification['created_at']->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                                
                                @if($finalReport->submitted_at ?? false)
                                <div class="mt-2 flex items-center gap-2 text-xs text-gray-500">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $notification['created_at']->diffForHumans() }}</span>
                                </div>
                                @endif
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-600 group-hover:translate-x-1 transition-all flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <!-- Enhanced Empty State -->
        <div class="flex flex-col items-center justify-center py-16 px-4">
            <!-- Animated Icon Container -->
            <div class="relative mb-6">
                <!-- Pulsing Background Circle -->
                <div class="absolute inset-0 bg-gradient-to-r from-blue-100 to-purple-100 rounded-full animate-pulse opacity-50"></div>
                
                <!-- Main Icon -->
                <div class="relative w-24 h-24 bg-gradient-to-br from-blue-50 to-purple-50 rounded-full flex items-center justify-center border-4 border-white shadow-lg">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                </div>
                
                <!-- Floating Decorative Elements -->
                <div class="absolute -top-2 -right-2 w-8 h-8 bg-blue-200 rounded-full opacity-60 animate-bounce" style="animation-delay: 0.1s;"></div>
                <div class="absolute -bottom-2 -left-2 w-6 h-6 bg-purple-200 rounded-full opacity-60 animate-bounce" style="animation-delay: 0.3s;"></div>
            </div>
            
            <!-- Text Content -->
            <div class="text-center max-w-md">
                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-2">
                    No Recent Activities
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 leading-relaxed">
                    It's quiet here right now. New proposals, progress reports, and final reports will appear here when they're submitted.
                </p>
                
                <!-- Info Cards -->
                <div class="grid grid-cols-3 gap-3 mt-8">
                    <!-- Proposals Card -->
                    <div class="bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 p-4 rounded-xl border border-red-200 dark:border-red-700 hover:shadow-md transition-all">
                        <div class="w-10 h-10 bg-red-200 dark:bg-red-800/50 rounded-lg flex items-center justify-center mx-auto mb-2">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <p class="text-xs font-semibold text-red-700 dark:text-red-400">Proposals</p>
                        <p class="text-[10px] text-red-600 dark:text-red-500 mt-1">0 pending</p>
                    </div>
                    
                    <!-- Progress Card -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 p-4 rounded-xl border border-blue-200 dark:border-blue-700 hover:shadow-md transition-all">
                        <div class="w-10 h-10 bg-blue-200 dark:bg-blue-800/50 rounded-lg flex items-center justify-center mx-auto mb-2">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <p class="text-xs font-semibold text-blue-700 dark:text-blue-400">Progress</p>
                        <p class="text-[10px] text-blue-600 dark:text-blue-500 mt-1">0 reports</p>
                    </div>
                    
                    <!-- Final Card -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 p-4 rounded-xl border border-purple-200 dark:border-purple-700 hover:shadow-md transition-all">
                        <div class="w-10 h-10 bg-purple-200 dark:bg-purple-800/50 rounded-lg flex items-center justify-center mx-auto mb-2">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <p class="text-xs font-semibold text-purple-700 dark:text-purple-400">Finals</p>
                        <p class="text-[10px] text-purple-600 dark:text-purple-500 mt-1">0 submitted</p>
                    </div>
                </div>
                
                <!-- Tips Section -->
                <div class="mt-8 bg-gradient-to-r from-amber-50 to-yellow-50 dark:from-amber-900/10 dark:to-yellow-900/10 border border-amber-200 dark:border-amber-700 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="text-xs font-semibold text-amber-800 dark:text-amber-300 mb-1">💡 Quick Tip</p>
                            <p class="text-xs text-amber-700 dark:text-amber-400 leading-relaxed">
                                Check back regularly to stay updated on new submissions. You'll be notified here as soon as new activities arrive!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

                <!-- Aktivitas -->
                
            </div>

        </div>
    </div>
</div>

<script>
function filterNotifications(type) {
    const items = document.querySelectorAll('.notification-item');
    const tabs = document.querySelectorAll('.filter-tab');
    
    // Update active tab
    tabs.forEach(tab => {
        tab.classList.remove('active', 'border-gray-900', 'dark:border-white', 'text-gray-900');
        tab.classList.add('text-gray-500', 'border-transparent');
    });
    
    // Find clicked button and make it active
    const clickedTab = event.currentTarget;
    clickedTab.classList.add('active', 'border-gray-900', 'dark:border-white', 'text-gray-900');
    clickedTab.classList.remove('text-gray-500', 'border-transparent');
    
    // Filter items with animation
    let visibleCount = 0;
    items.forEach(item => {
        const itemType = item.getAttribute('data-type');
        
        if (type === 'all' || itemType === type) {
            item.style.display = 'block';
            visibleCount++;
            // Fade in animation
            setTimeout(() => {
                item.style.opacity = '1';
                item.style.transform = 'translateY(0)';
            }, 10);
        } else {
            item.style.opacity = '0';
            item.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                item.style.display = 'none';
            }, 300);
        }
    });
    
    // Show/hide empty state
    const emptyState = document.getElementById('empty-state');
    const notificationsList = document.getElementById('notifications-list');
    
    if (visibleCount === 0 && emptyState) {
        emptyState.style.display = 'flex';
        if (notificationsList) notificationsList.style.display = 'none';
    } else {
        if (emptyState) emptyState.style.display = 'none';
        if (notificationsList) notificationsList.style.display = 'block';
    }
}

// Set initial transition styles
document.addEventListener('DOMContentLoaded', function() {
    const items = document.querySelectorAll('.notification-item');
    items.forEach(item => {
        item.style.transition = 'all 0.3s ease';
        item.style.opacity = '1';
        item.style.transform = 'translateY(0)';
    });
});

    function changeChartType(type) {
        document.querySelectorAll('.chart-type-btn').forEach(btn => {
            btn.classList.remove('active', 'bg-blue-600', 'text-white');
            btn.classList.add('bg-gray-200', 'text-gray-700');
        });
        event.target.classList.add('active', 'bg-blue-600', 'text-white');
        event.target.classList.remove('bg-gray-200', 'text-gray-700');

        currentChart.config.type = type;
        
        if (type === 'bar') {
            currentChart.data.datasets[0].backgroundColor = 'rgba(59, 130, 246, 0.8)';
            currentChart.data.datasets[1].backgroundColor = 'rgba(168, 85, 247, 0.8)';
        } else {
            currentChart.data.datasets[0].backgroundColor = 'rgba(59, 130, 246, 0.1)';
            currentChart.data.datasets[1].backgroundColor = 'rgba(168, 85, 247, 0.1)';
        }
        
        currentChart.update();
    }
</script>
