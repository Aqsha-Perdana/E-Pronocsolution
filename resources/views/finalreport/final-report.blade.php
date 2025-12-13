<x-layouts.app>
    <x-slot name="title">Final Report</x-slot>

    {{-- SweetAlert2 CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="min-h-screen bg-slate-50 pb-12 relative">
        
        {{-- HEADER BACKGROUND --}}
        <div class="absolute top-0 left-0 w-full h-64 bg-gradient-to-r from-red-700 via-red-600 to-red-800 z-0"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 pt-10">
            
            {{-- Header Section --}}
            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-white tracking-tight drop-shadow-md">Final Reports</h1>
                    <p class="mt-2 text-sm text-red-100 font-medium max-w-2xl">
                        Daftar proyek yang telah disetujui. Laporan akhir dapat dibuat setelah Progress Report selesai dan Realisasi Dana tuntas.
                    </p>
                </div>
            </div>

            {{-- Main Content Card --}}
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                
                {{-- Toolbar: Search & Pagination --}}
                <div class="p-6 border-b border-gray-100 bg-white">
                    <form action="{{ route('final') }}" method="GET" class="flex flex-col md:flex-row justify-between items-center gap-4">
                        
                        {{-- Show Entries --}}
                        <div class="flex items-center gap-3 bg-gray-50 px-4 py-2 rounded-lg border border-gray-200 w-full md:w-auto">
                            <span class="text-sm font-medium text-gray-600">Show</span>
                            <select name="perPage" onchange="this.form.submit()" class="border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md text-sm py-1 pl-2 pr-8 bg-white shadow-sm cursor-pointer">
                                <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                            </select>
                            <span class="text-sm font-medium text-gray-600">entries</span>
                        </div>

                        {{-- Search Input --}}
                        <div class="relative w-full md:w-72">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                class="block w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 sm:text-sm transition duration-150 ease-in-out shadow-sm" 
                                placeholder="Search project title...">
                        </div>
                    </form>
                </div>

                {{-- Table Data --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50/80">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Project Title</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Prerequisites</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Final Status</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($approvedProposals as $proposal)
                                @php
                                    $progressStatus = strtolower($proposal->progressReport->status ?? 'pending');
                                    $fundStatus = strtolower($proposal->fundRealization->status ?? 'pending');
                                    
                                    $isReady = ($progressStatus === 'complete' && $fundStatus === 'done');
                                    $final = $proposal->finalReport;
                                @endphp

                                <tr class="hover:bg-red-50/30 transition-colors duration-200 group">
                                    
                                    {{-- Project Title --}}
                                    <td class="px-6 py-5">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-gray-900 group-hover:text-red-700 transition-colors line-clamp-2" title="{{ $proposal->title }}">
                                                {{ $proposal->title }}
                                            </span>
                                            <span class="text-[10px] uppercase tracking-wide font-mono text-gray-400 mt-1 bg-gray-50 w-fit px-1.5 rounded border border-gray-200">
                                                {{ $proposal->registration_code ?? 'NO-CODE' }}
                                            </span>
                                        </div>
                                    </td>

                                    {{-- Prerequisites Status --}}
                                    <td class="px-6 py-5">
                                        <div class="flex flex-col gap-2">
                                            {{-- Progress Check --}}
                                            <div class="flex items-center text-xs">
                                                <span class="w-20 font-medium text-gray-500">Progress:</span>
                                                @if($progressStatus === 'complete')
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                                        Complete
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-500 border border-gray-200">
                                                        {{ ucfirst($progressStatus) }}
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            {{-- Fund Check --}}
                                            <div class="flex items-center text-xs">
                                                <span class="w-20 font-medium text-gray-500">Fund:</span>
                                                @if($fundStatus === 'done')
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                                        Done
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-500 border border-gray-200">
                                                        {{ ucfirst($fundStatus) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Final Status --}}
                                    <td class="px-6 py-5 text-center">
                                        @if($final)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700 border border-blue-200 shadow-sm">
                                                <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Submitted
                                            </span>
                                            <div class="text-[10px] text-gray-400 mt-1 font-medium">
                                                {{ \Carbon\Carbon::parse($final->date)->format('d M Y') }}
                                            </div>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-500 border border-gray-200">
                                                Pending
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Action Buttons --}}
                                    <td class="px-6 py-5 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            
                                            @if($final) 
                                                {{-- View Button --}}
                                                <a href="{{ route('final.view', $final->id) }}" 
                                                   class="group relative inline-flex items-center justify-center w-9 h-9 bg-white text-gray-500 rounded-lg hover:bg-gray-100 border border-gray-200 transition-all shadow-sm" 
                                                   title="Lihat Laporan Akhir">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>

                                                {{-- Download Button --}}
                                                <a href="{{ route('final.download', $final->id) }}" 
                                                   class="group relative inline-flex items-center justify-center w-9 h-9 bg-white text-green-600 rounded-lg hover:bg-green-50 border border-gray-200 hover:border-green-200 transition-all shadow-sm" 
                                                   title="Download PDF">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                </a>
                                            @else 
                                                @if($isReady)
                                                    {{-- Create Button (Active) --}}
                                                    <a href="{{ route('final.edit', $proposal->id) }}" 
                                                       class="inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-lg transition-all shadow-md shadow-red-200 transform hover:-translate-y-0.5 gap-2"
                                                       title="Buat Laporan Akhir">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                        </svg>
                                                        Create Report
                                                    </a>
                                                @else
                                                    {{-- Create Button (Disabled/Locked) --}}
                                                    <button type="button" 
                                                            class="inline-flex items-center justify-center w-10 h-10 bg-gray-100 text-gray-400 rounded-xl cursor-not-allowed border border-gray-200" 
                                                            title="Prerequisites not met (Progress must be Complete & Fund must be Done)"
                                                            onclick="Swal.fire({ icon: 'warning', title: 'Belum Siap', text: 'Anda harus menyelesaikan Progress Report dan Realisasi Dana terlebih dahulu.', confirmButtonColor: '#d33' })">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="bg-gray-50 p-4 rounded-full mb-3">
                                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-900">Tidak ada data ditemukan</h3>
                                            <p class="text-sm text-gray-500 mt-1">Coba sesuaikan kata kunci pencarian Anda.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Footer: Pagination Info --}}
                @if($approvedProposals->count() > 0)
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-gray-600">
                        Menampilkan <span class="font-bold text-gray-900">{{ $approvedProposals->firstItem() }}</span> sampai <span class="font-bold text-gray-900">{{ $approvedProposals->lastItem() }}</span> dari <span class="font-bold text-gray-900">{{ $approvedProposals->total() }}</span> hasil
                    </div>
                    
                    {{-- Pagination Links --}}
                    <div>
                        {{ $approvedProposals->appends(request()->query())->links() }}
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>

    {{-- Script untuk menampilkan SweetAlert --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#166534',
                    timer: 3000
                });
            @endif
            
            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Akses Ditolak',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#d33'
                });
            @endif
        });
    </script>
</x-layouts.app>