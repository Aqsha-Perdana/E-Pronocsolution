<x-layouts.app>
    <x-slot name="title">Progress Report</x-slot>

    {{-- HEADER BACKGROUND --}}
    <div class="absolute top-0 left-0 w-full h-64 bg-gradient-to-r from-red-700 via-red-600 to-red-800 -z-10"></div>

    <div class="py-10 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- HEADER SECTION --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-white tracking-tight drop-shadow-md">Progress Reports</h1>
                    <p class="mt-2 text-sm text-red-100 font-medium max-w-2xl">
                        Pantau dan perbarui perkembangan proyek penelitian Anda yang telah disetujui secara berkala di sini.
                    </p>
                </div>
            </div>

            {{-- CONTENT CARD --}}
            <div class="bg-white shadow-xl rounded-2xl border border-gray-100 overflow-hidden">
                
                {{-- TOOLBAR --}}
                <div class="p-6 border-b border-gray-100 bg-white flex flex-col md:flex-row justify-between items-center gap-4">
                    
                    {{-- Show Entries --}}
                    <div class="flex items-center gap-3 bg-gray-50 px-4 py-2 rounded-lg border border-gray-200">
                        <span class="text-sm font-medium text-gray-600">Tampilkan</span>
                        <select class="block w-16 py-1 px-2 text-sm border-gray-300 focus:outline-none focus:ring-red-500 focus:border-red-500 rounded-md cursor-pointer bg-white shadow-sm">
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                        </select>
                        <span class="text-sm font-medium text-gray-600">data</span>
                    </div>

                    {{-- Search Box --}}
                    <div class="relative w-full md:w-72">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" 
                            class="block w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 sm:text-sm transition duration-150 ease-in-out shadow-sm" 
                            placeholder="Cari judul proyek...">
                    </div>
                </div>

                {{-- TABLE --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50/80">
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Judul Proyek</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Bidang Fokus</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Update Terakhir</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-1/4">Progres</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($approvedProposals as $proposal)
                                @php
                                    $progress = $proposal->progressReport;
                                    $percentage = $progress->percentage_complete ?? 0;
                                    $status = $progress->status ?? 'Not Started';
                                    $lastUpdate = $progress ? \Carbon\Carbon::parse($progress->report_date)->format('d M, Y') : '-';
                                    
                                    // Status Style Mapping
                                    $statusClasses = match(strtolower($status)) {
                                        'active', 'in progress' => 'bg-orange-100 text-orange-700 border border-orange-200',
                                        'completed', 'complete' => 'bg-green-100 text-green-700 border border-green-200',
                                        'blocked' => 'bg-red-100 text-red-700 border border-red-200',
                                        'on hold' => 'bg-yellow-100 text-yellow-700 border border-yellow-200',
                                        default => 'bg-gray-100 text-gray-600 border border-gray-200',
                                    };
                                @endphp

                                <tr class="hover:bg-red-50/30 transition-colors duration-200 group">
                                    <td class="px-6 py-5">
                                        <div class="text-sm font-bold text-gray-900 group-hover:text-red-700 transition-colors line-clamp-2" title="{{ $proposal->title }}">
                                            {{ $proposal->title }}
                                        </div>
                                        <div class="text-xs text-gray-400 mt-1 font-mono bg-gray-100 inline-block px-1.5 py-0.5 rounded border border-gray-200">
                                            {{ $proposal->registration_code ?? 'NO-CODE' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                            {{ $proposal->focus_area }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <span class="font-medium">{{ $lastUpdate }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 align-middle">
                                        <div class="w-full bg-gray-200 rounded-full h-2.5 shadow-inner">
                                            <div class="bg-gradient-to-r from-red-500 to-red-600 h-2.5 rounded-full transition-all duration-700 ease-out shadow-sm" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <div class="flex justify-between items-center mt-1.5">
                                            <span class="text-xs font-semibold text-gray-700">{{ $percentage }}%</span>
                                            <span class="text-[10px] text-gray-400 uppercase tracking-wide">Selesai</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold {{ $statusClasses }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            
                                            @if($percentage == 100 || strtolower($status) == 'complete')
                                                {{-- VIEW BUTTON --}}
                                                <a href="{{ route('progress.view', $progress->id) }}" 
                                                   class="group relative inline-flex items-center justify-center w-9 h-9 bg-white text-gray-500 rounded-lg hover:bg-gray-100 hover:text-gray-700 border border-gray-200 transition-all shadow-sm" 
                                                   title="Lihat Laporan">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>

                                                {{-- DOWNLOAD BUTTON --}}
                                                <a href="{{ route('progress.download', $progress->id) }}" 
                                                   class="group relative inline-flex items-center justify-center w-9 h-9 bg-white text-green-600 rounded-lg hover:bg-green-50 border border-gray-200 hover:border-green-200 transition-all shadow-sm" 
                                                   title="Download PDF">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                </a>
                                            @else
                                                {{-- EDIT BUTTON (Utama) --}}
                                                <a href="{{ route('progress.edit', $proposal->id) }}" 
                                                   class="inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-lg transition-all shadow-md shadow-red-200 transform hover:-translate-y-0.5 gap-2" 
                                                   title="Update Progress">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    <span>Update</span>
                                                </a>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="bg-gray-50 p-4 rounded-full mb-3">
                                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-900">Belum Ada Proyek Disetujui</h3>
                                            <p class="text-sm text-gray-500 mt-1 max-w-sm mx-auto">Saat ini belum ada proposal yang berstatus <strong>Approved</strong>. Silakan tunggu proses review atau ajukan proposal baru.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                @if($approvedProposals->count() > 0)
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        Menampilkan <span class="font-bold text-gray-900">1</span> sampai <span class="font-bold text-gray-900">{{ $approvedProposals->count() }}</span> dari <span class="font-bold text-gray-900">{{ $approvedProposals->count() }}</span> hasil
                    </div>
                    {{-- Pagination links placeholder --}}
                </div>
                @endif

            </div>
        </div>
    </div>
</x-layouts.app>