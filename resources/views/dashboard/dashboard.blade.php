<x-layouts.app>
    <x-slot name="title">Dashboard</x-slot>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Custom Style for Chart --}}
    <style>
        body { margin: 0; font-family: 'Figtree', sans-serif; background-color: #f8fafc; }
        .stat-card {
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>

    {{-- WRAPPER UTAMA (Tanpa Fixed Header) --}}
    <div class="min-h-screen bg-slate-50 pb-12">
        
        {{-- HEADER BANNER MERAH (Normal Flow / Relative) --}}
        {{-- Menghapus class 'fixed', 'top-0', 'right-0', 'z-...' agar menyatu dengan body --}}
        <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-800 border-b border-red-800 shadow-md">
            <div class="px-8 py-8">
                <div class="flex flex-col md:flex-row justify-between items-center max-w-7xl mx-auto">
                    
                    {{-- Judul Dashboard --}}
                    <div class="mb-4 md:mb-0 text-center md:text-left">
                        <h1 class="text-3xl font-extrabold text-white tracking-tight drop-shadow-sm">Dashboard</h1>
                        <p class="text-sm text-red-100 mt-1 font-medium">Ringkasan aktivitas dan status proposal Anda.</p>
                    </div>
                    
                    {{-- User Profile Section --}}
                    <div class="flex items-center gap-4 bg-white/10 backdrop-blur-md px-5 py-2.5 rounded-full border border-white/20 shadow-sm hover:bg-white/20 transition-colors cursor-pointer">
                        <div class="text-right hidden sm:block">
                            <p class="text-[10px] text-red-100 font-bold uppercase tracking-wider leading-tight">Welcome back,</p>
                            <p class="text-sm font-bold text-white leading-tight truncate max-w-[150px]">{{ Auth::user()->name ?? 'User' }}</p>
                        </div>
                        
                        {{-- Avatar Logic --}}
                        @php
                            $user = Auth::user();
                            $photoPath = $user->member->profile_photo_path ?? null;
                        @endphp

                        <div class="relative shrink-0">
                            @if($photoPath)
                                <img src="{{ asset('storage/' . $photoPath) }}" 
                                     alt="Profile" 
                                     class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm ring-2 ring-red-500/30">
                            @else
                                <div class="w-10 h-10 rounded-full bg-white text-red-600 flex items-center justify-center font-bold text-lg border-2 border-white shadow-sm ring-2 ring-red-500/30">
                                    {{ substr($user->name ?? 'U', 0, 1) }}
                                </div>
                            @endif
                            
                            {{-- Status Indicator (Online) --}}
                            <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-red-800 rounded-full shadow-sm"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- KONTEN DASHBOARD --}}
        {{-- Menghapus margin negatif (-mt-6) agar tidak overlap, atau sesuaikan jika ingin efek tumpang tindih --}}
        <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-8 mt-8">
            
            {{-- Statistik Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                {{-- Card 1: Total Proyek --}}
                <div class="stat-card bg-white p-6 rounded-2xl border border-slate-100 shadow-lg relative overflow-hidden group">
                    <div class="absolute right-0 top-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                        <svg class="w-20 h-20 text-slate-800" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/></svg>
                    </div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Proyek</p>
                    <p class="text-3xl font-extrabold text-slate-800 mt-2">{{ $totalProposals }}</p>
                    <p class="text-xs text-slate-400 mt-2">Semua proposal yang diajukan</p>
                </div>

                {{-- Card 2: Proyek Aktif --}}
                <div class="stat-card bg-white p-6 rounded-2xl border border-slate-100 shadow-lg relative overflow-hidden group">
                    <div class="absolute right-0 top-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                        <svg class="w-20 h-20 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                    </div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Proyek Aktif</p>
                    <p class="text-3xl font-extrabold text-blue-600 mt-2">{{ $activeProposals }}</p>
                    <p class="text-xs text-slate-400 mt-2">Sedang berjalan / review</p>
                </div>

                {{-- Card 3: Dana Cair --}}
                <div class="stat-card bg-white p-6 rounded-2xl border border-slate-100 shadow-lg relative overflow-hidden group">
                    <div class="absolute right-0 top-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                        <svg class="w-20 h-20 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                    </div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Dana Cair (Approved)</p>
                    <p class="text-3xl font-extrabold text-slate-800 mt-2">
                        <span class="text-lg text-slate-500 font-medium align-top">Rp</span> 
                        {{ number_format($danaCair / 1000000, 1, ',', '.') }}
                        <span class="text-lg text-slate-500 font-medium align-baseline">Jt</span>
                    </p>
                </div>

                {{-- Card 4: Sisa Pagu --}}
                <div class="stat-card bg-gradient-to-br from-green-50 to-white p-6 rounded-2xl border border-green-100 shadow-lg relative overflow-hidden group">
                    <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg class="w-20 h-20 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"/><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"/></svg>
                    </div>
                    <p class="text-xs font-bold text-green-600 uppercase tracking-wider">Sisa Pagu (Alokasi)</p>
                    <p class="text-3xl font-extrabold text-green-600 mt-2">
                        <span class="text-lg text-green-500 font-medium align-top">Rp</span> 
                        {{ number_format($sisaDana / 1000000, 1, ',', '.') }}
                        <span class="text-lg text-green-500 font-medium align-baseline">Jt</span>
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Kolom Kiri: Grafik & Tabel --}}
                <div class="lg:col-span-2 space-y-8">
                    
                    {{-- Grafik Proposal --}}
                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-bold text-slate-800">Aktivitas Proposal</h3>
                                <p class="text-xs text-slate-500">Statistik pengajuan proposal tahun {{ date('Y') }}</p>
                            </div>
                        </div>
                        <div style="height: 300px; width: 100%;">
                            <canvas id="proposalChart"></canvas>
                        </div>
                    </div>

                    {{-- Recent Projects --}}
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                            <h3 class="text-lg font-bold text-slate-800">Proyek Terbaru</h3>
                            <a href="/proposalutama" class="text-xs font-semibold text-red-600 hover:text-red-700 hover:underline">Lihat Semua</a>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-100">
                                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Project Title</th>
                                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($recentProposals as $p)
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-6 py-4">
                                                <p class="text-sm font-semibold text-slate-700 truncate max-w-xs" title="{{ $p->title }}">{{ $p->title }}</p>
                                            </td>
                                            <td class="px-6 py-4">
                                                <p class="text-sm text-slate-500">{{ \Carbon\Carbon::parse($p->date)->format('d M, Y') }}</p>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                @php
                                                    $statusStyles = [
                                                        'APPROVED' => 'bg-green-100 text-green-700 border-green-200',
                                                        'REJECTED' => 'bg-red-100 text-red-700 border-red-200',
                                                        'SUBMITTED' => 'bg-blue-100 text-blue-700 border-blue-200',
                                                        'DRAFT' => 'bg-gray-100 text-gray-700 border-gray-200'
                                                    ];
                                                    $style = $statusStyles[$p->status] ?? 'bg-gray-100 text-gray-600 border-gray-200';
                                                @endphp
                                                <span class="px-3 py-1 text-xs font-bold rounded-full border {{ $style }}">
                                                    {{ ucfirst(strtolower($p->status)) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-10 text-center text-slate-400">
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                                                    <span class="text-sm">Belum ada proposal terbaru.</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Akses Cepat --}}
                <div class="lg:col-span-1 space-y-8">
                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                        <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Akses Cepat
                        </h3>
                        
                        <div class="space-y-3">
                            {{-- Link 1: Download Panduan (Icon Buku) --}}
                            <a href="#" class="flex items-center p-4 bg-slate-50 border border-slate-200 rounded-xl hover:bg-white hover:border-red-200 hover:shadow-md transition-all group">
                                <div class="bg-white p-2 rounded-lg border border-slate-100 group-hover:bg-red-50 group-hover:text-red-600 transition-colors mr-4">
                                    {{-- Icon Buku --}}
                                    <svg class="w-6 h-6 text-slate-500 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-700 group-hover:text-red-700">Download Panduan</p>
                                    <p class="text-xs text-slate-400">PDF, versi 2.0</p>
                                </div>
                            </a>
                            
                            {{-- Link 2: Hubungi Admin (Icon Telepon) --}}
                            <a href="#" class="flex items-center p-4 bg-slate-50 border border-slate-200 rounded-xl hover:bg-white hover:border-red-200 hover:shadow-md transition-all group">
                                <div class="bg-white p-2 rounded-lg border border-slate-100 group-hover:bg-red-50 group-hover:text-red-600 transition-colors mr-4">
                                    {{-- Icon Telepon --}}
                                    <svg class="w-6 h-6 text-slate-500 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.948V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-700 group-hover:text-red-700">Hubungi Admin</p>
                                    <p class="text-xs text-slate-400">Bantuan teknis</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            </div> 
        </div>
    </div>

    {{-- MODAL ALERT PROFILE --}}
    @if(isset($showProfileAlert) && $showProfileAlert)
        <div id="profileAlertModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm px-4 transition-opacity">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden transform transition-all scale-100 p-8 text-center relative border border-slate-100">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-red-500 to-orange-500"></div>
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-red-50 mb-6 ring-8 ring-red-50/50">
                    <svg class="h-10 w-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-2">Lengkapi Profil Anda</h3>
                <p class="text-slate-500 mb-8 leading-relaxed">
                    Halo <span class="font-bold text-slate-700">{{ Auth::user()->name }}</span>, agar dapat mengajukan proposal, mohon lengkapi data diri (NIP, No HP, dll) terlebih dahulu.
                </p>
                <div class="space-y-3">
                    <a href="{{ route('profile') }}" class="w-full inline-flex justify-center items-center rounded-xl border border-transparent shadow-lg shadow-red-200 px-4 py-3.5 bg-gradient-to-r from-red-600 to-red-700 text-base font-bold text-white hover:from-red-700 hover:to-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all transform hover:-translate-y-0.5">
                        Lengkapi Profil Sekarang
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                    <button type="button" onclick="document.getElementById('profileAlertModal').style.display='none'" class="w-full inline-flex justify-center rounded-xl border border-slate-200 shadow-sm px-4 py-3.5 bg-white text-base font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-800 focus:outline-none transition-colors">
                        Nanti Saja
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- SCRIPT CHART --}}
    <script>
        const ctx = document.getElementById('proposalChart');
        const chartData = @json($chartData);
        const labels = @json($months);

        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Proposal',
                        data: chartData,
                        backgroundColor: (context) => {
                            const ctx = context.chart.ctx;
                            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                            gradient.addColorStop(0, 'rgba(220, 38, 38, 0.2)'); // Red-600 with opacity
                            gradient.addColorStop(1, 'rgba(220, 38, 38, 0)');
                            return gradient;
                        },
                        borderColor: '#dc2626', // Red-600
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#dc2626',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 12,
                            titleFont: { size: 13, family: "'Figtree', sans-serif" },
                            bodyFont: { size: 14, family: "'Figtree', sans-serif", weight: 'bold' },
                            cornerRadius: 8,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true,
                            ticks: { stepSize: 1, font: { family: "'Figtree', sans-serif" }, color: '#94a3b8' },
                            grid: { borderDash: [4, 4], color: '#f1f5f9', drawBorder: false }
                        },
                        x: {
                            ticks: { font: { family: "'Figtree', sans-serif" }, color: '#94a3b8' },
                            grid: { display: false }
                        }
                    }
                }
            });
        }
    </script>
</x-layouts.app>