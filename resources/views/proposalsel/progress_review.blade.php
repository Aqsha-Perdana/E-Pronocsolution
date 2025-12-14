<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('proposal') }}
        </h2>
    </x-slot>
</x-app-layout>

@php    
    $reports = $progressReport;
    $radius = 58;
    $circumference = 2 * pi() * $radius;
    $progress = $progressReport->percentage_complete;
    $offset = $circumference - ($progress / 100) * $circumference;
@endphp

<style>
.progress-circle {
    stroke: #ef4444;
    transition: stroke-dashoffset 1.5s ease-out;
    transform-origin: 50% 50%;
}

.progress-0   { stroke: #9ca3af; }
.progress-50  { stroke: #f59e0b; }
.progress-80  { stroke: #10b981; }
.progress-100 { stroke: #dc2626; }

.fade-out {
    animation: fadeOut 0.5s ease-out forwards;
}

@keyframes fadeOut {
    to {
        opacity: 0;
        transform: translateX(100px);
    }
}
</style>

<div class="py-24">
    <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8 min-h-[700px]">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg p-6">
            <div class="grid grid-cols-12 gap-6">

                <!-- Sidebar Kiri -->
                <div class="col-span-3 bg-gradient-to-br from-red-600 to-red-700 dark:bg-gray-700 p-6 rounded-xl shadow-xl">
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <h1 class="text-xl font-bold text-gray-800 mb-6 pb-3 border-b-2 border-red-500">Proposal Information</h1>

                        <!-- Code Reg -->
                        <div class="mb-4 bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Code Reg</p>
                            <p class="font-semibold text-gray-800 break-words">
                                {{ strip_tags($proposal->registration_code) }}
                            </p>
                        </div>

                        <!-- Title -->
                        <div class="mb-4 bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Title</p>
                            <p class="font-semibold text-gray-800 break-words">
                                {{ strip_tags($proposal->title) }}
                            </p>
                        </div>

                        <!-- Focus -->
                        <div class="mb-4 bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Focus</p>
                            <p class="font-semibold text-gray-800 break-words">
                                {{ strip_tags($proposal->focus) }}
                            </p>
                        </div>

                        <!-- Abstract -->
                        <div class="mb-4 bg-gradient-to-r from-blue-50 to-indigo-50 p-3 rounded-lg border-l-4 border-blue-500">
                            <p class="text-xs font-medium text-blue-700 uppercase tracking-wide mb-2">Abstract</p>
                            <p class="text-sm text-gray-700 break-words whitespace-pre-wrap leading-relaxed">
                                {{ strip_tags($proposal->abstract) }}
                            </p>
                        </div>

                        <!-- Project Method -->
                        <div class="mb-4 bg-gradient-to-r from-green-50 to-emerald-50 p-3 rounded-lg border-l-4 border-green-500">
                            <p class="text-xs font-medium text-green-700 uppercase tracking-wide mb-2">Project Method</p>
                            <p class="text-sm text-gray-700 break-words whitespace-pre-wrap leading-relaxed">
                                {{ strip_tags($proposal->project_method) }}
                            </p>
                        </div>

                        <!-- Bibliography -->
                        <div class="mb-4 bg-gradient-to-r from-purple-50 to-pink-50 p-3 rounded-lg border-l-4 border-purple-500">
                            <p class="text-xs font-medium text-purple-700 uppercase tracking-wide mb-2">Bibliography</p>
                            <p class="text-sm text-gray-700 break-words whitespace-pre-wrap leading-relaxed">
                                {{ strip_tags($proposal->bibliography) }}
                            </p>
                        </div>

                        <!-- Team -->
                        <div class="bg-gradient-to-r from-red-50 to-orange-50 p-4 rounded-lg border-l-4 border-red-500">
                            <p class="text-xs font-medium text-red-700 uppercase tracking-wide mb-3">Team Members</p>
                            <div class="space-y-2">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-red-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <div>
                                        <span class="text-xs font-semibold text-gray-600 uppercase">Name</span>
                                        <p class="text-sm font-medium text-gray-800 break-words">
                                            @if($proposal->teamMembers && $proposal->teamMembers->count() > 0)
                                                @php
                                                    $memberNames = $proposal->teamMembers
                                                        ->map(function($member) {
                                                            return $member->name ?? 'N/A';
                                                        })
                                                        ->filter()
                                                        ->join(', ');
                                                @endphp
                                                {{ $memberNames ?: 'N/A' }}
                                            @else
                                                N/A
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>

                <!-- Konten Utama -->
                <div class="col-span-9 bg-white p-8 rounded-2xl shadow-sm min-h-[500px]">
                    <h2 class="text-4xl font-bold text-gray-800 mb-8">Review Progress Report</h2>
                    <div id="progress-card-{{ $progressReport->id }}" class="bg-white border border-gray-200 p-6 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 mb-8 transform hover:-translate-y-1">
                        
                        <div class="flex items-start gap-8">

                            <div class="relative w-32 h-32 flex-shrink-0">
                                <svg class="w-32 h-32 transform -rotate-90">
                                    <!-- Background -->
                                    <circle
                                        cx="64"
                                        cy="64"
                                        r="{{ $radius }}"
                                        fill="transparent"
                                        stroke-width="10"
                                        class="text-gray-200"
                                        stroke="currentColor"
                                    />

                                    <!-- Progress -->
                                    <circle
                                        cx="64"
                                        cy="64"
                                        r="{{ $radius }}"
                                        fill="transparent"
                                        stroke-width="10"
                                        stroke-linecap="round"
                                        stroke-dasharray="{{ $circumference }}"
                                        stroke-dashoffset="{{ $offset }}"
                                        class="progress-circle
                                            {{ $progress == 100 ? 'progress-100' : '' }}
                                            {{ $progress >= 80 && $progress < 100 ? 'progress-80' : '' }}
                                            {{ $progress >= 50 && $progress < 80 ? 'progress-50' : '' }}
                                            {{ $progress < 50 ? 'progress-0' : '' }}"
                                    />
                                </svg>

                                <!-- Percentage -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="text-2xl font-extrabold text-gray-800">
                                        {{ $progress }}%
                                    </span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-600 mb-1">Aktivitas</p>
                                <div class="bg-gray-50 p-3 rounded-lg shadow-sm border mb-4 break-words whitespace-normal overflow-hidden max-w-full">
                                    {!! $progressReport->activities ?? 'Tidak ada aktivitas.' !!}
                                </div>

                                <p class="text-sm font-medium text-gray-600 mb-1">Hasil</p>
                                <div class="bg-gray-50 p-3 rounded-lg shadow-sm border mb-4 break-words whitespace-normal overflow-hidden max-w-full">
                                    {!! $progressReport->results ?? 'Tidak ada hasil.' !!}
                                </div>

                                <p class="text-sm font-medium text-gray-600 mb-1">Hambatan</p>
                                <div class="bg-gray-50 p-3 rounded-lg shadow-sm border mb-4 break-words whitespace-normal overflow-hidden max-w-full">
                                    {!! $progressReport->obstacles ?? 'Tidak ada hambatan.' !!}
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="mt-8 flex items-center justify-end gap-4">

                        <!-- OK Button -->
                        <a href="{{ route('proposalsel.progress') }}"
                            class="px-6 py-2.5 rounded-lg font-semibold text-white
                            transition-all duration-200 shadow-md
                            {{ $progressReport->percentage_complete == 100
                                ? 'bg-gray-400 cursor-not-allowed opacity-60'
                                : 'bg-blue-600 hover:bg-blue-700 hover:shadow-lg' }}"
                            {{ $progressReport->percentage_complete == 100 ? 'disabled' : '' }}>
                            OK
                        </a>

                        <!-- Complete Button -->
                        <form id="complete-form-{{ $progressReport->id }}" 
                              action="{{ route('progress.complete', ['id' => $progressReport->id, 'action' => 'complete']) }}" 
                              method="POST">
                            @csrf

                            <button type="button"
                                onclick="confirmComplete({{ $progressReport->id }})"
                                class="px-6 py-2.5 rounded-lg font-semibold text-white
                                transition-all duration-200 shadow-md
                                {{ $progressReport->percentage_complete == 100
                                    ? 'bg-green-600 hover:bg-green-700 hover:shadow-lg'
                                    : 'bg-gray-400 cursor-not-allowed opacity-60' }}"
                                {{ $progressReport->percentage_complete != 100 ? 'disabled' : '' }}>

                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Complete
                                </span>
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmComplete(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Progress report ini akan ditandai sebagai selesai!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#16a34a',
        cancelButtonColor: '#dc2626',
        confirmButtonText: 'Ya, Complete!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Tampilkan loading
            Swal.fire({
                title: 'Memproses...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Submit form
            const form = document.getElementById('complete-form-' + id);
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Tampilkan success message
                    Swal.fire({
                        title: 'Berhasil!',
                        text: data.message || 'Progress report berhasil diselesaikan!',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        // Fade out dan hilangkan card
                        const card = document.getElementById('progress-card-' + id);
                        card.classList.add('fade-out');
                        
                        setTimeout(() => {
                            // Redirect ke halaman list
                            window.location.href = "{{ route('proposalsel.progress') }}";
                        }, 500);
                    });
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: data.message || 'Terjadi kesalahan',
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat memproses',
                    icon: 'error'
                });
            });
        }
    });
}
</script>

@if(session('success'))
<script>
    Swal.fire({
        title: "Berhasil!",
        text: "{{ session('success') }}",
        icon: "success",
        timer: 1800,
        showConfirmButton: false
    });
</script>
@endif