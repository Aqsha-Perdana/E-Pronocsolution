<x-layouts.app>
    <x-slot name="title">Proposal</x-slot>
    {{-- Header Background (Opsional, untuk memberi kesan modern) --}}
    <div class="absolute top-0 left-0 w-full h-64 bg-gradient-to-r from-red-700 via-red-600 to-red-800 -z-10"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        {{-- HEADER: Title & New Proposal Button --}}
        <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight drop-shadow-md">Proposal Submission</h1>
                <p class="text-red-100 mt-2 text-sm font-medium">Kelola dan pantau status pengajuan proposal penelitian Anda.</p>
            </div>
            
            <a href="{{ route('proposals.create') }}" class="inline-flex items-center px-5 py-3 bg-white text-red-700 hover:bg-red-50 hover:text-red-800 rounded-xl shadow-lg transition-all transform hover:-translate-y-0.5 focus:ring-2 focus:ring-offset-2 focus:ring-red-500 font-bold text-sm">
                <div class="bg-red-100 p-1 rounded-md mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <span>Buat Proposal Baru</span>
            </a>
        </div>

        {{-- CONTENT CARD --}}
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            
            {{-- TOOLBAR: Filter & Search --}}
            <div class="flex flex-col md:flex-row justify-between items-center p-6 border-b border-gray-100 bg-white gap-4">
                
                {{-- Show Entries --}}
                <div class="flex items-center text-sm text-gray-600 bg-gray-50 px-3 py-2 rounded-lg border border-gray-200">
                    <span class="mr-2 font-medium">Tampilkan</span>
                    <select onchange="window.location.href = this.value" class="border-gray-300 rounded-md text-sm focus:border-red-500 focus:ring-red-500 py-1 pl-2 pr-8 bg-white shadow-sm cursor-pointer h-8">
                        <option value="{{ request()->fullUrlWithQuery(['per_page' => 10]) }}" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="{{ request()->fullUrlWithQuery(['per_page' => 25]) }}" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="{{ request()->fullUrlWithQuery(['per_page' => 50]) }}" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                    <span class="ml-2 font-medium">data</span>
                </div>

                {{-- Search Box --}}
                <div class="relative w-full md:w-72">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" placeholder="Cari judul proposal..." class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:border-red-500 focus:ring-red-500 shadow-sm transition duration-200 ease-in-out">
                </div>
            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-50/80">
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Judul Proposal</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal Pengajuan</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Anggaran (RAB)</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($proposals as $p)
                        <tr class="hover:bg-red-50/30 transition-colors duration-150 group">
                            
                            {{-- Title & Code --}}
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-gray-800 group-hover:text-red-700 transition-colors line-clamp-1" title="{{ $p->title }}">
                                        {{ Str::limit($p->title, 40) }}
                                    </span>
                                    <span class="text-xs text-gray-400 mt-1 font-mono bg-gray-100 w-fit px-1.5 py-0.5 rounded border border-gray-200">
                                        {{ $p->registration_code ?? 'DRAFT-CODE' }}
                                    </span>
                                </div>
                            </td>
                            
                            {{-- Date --}}
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="font-medium">{{ \Carbon\Carbon::parse($p->date)->translatedFormat('d M Y') }}</span>
                                </div>
                            </td>
                            
                            {{-- Budget --}}
                            <td class="px-6 py-5 whitespace-nowrap">
                                <span class="text-sm font-semibold text-gray-900 bg-green-50 text-green-700 px-2 py-1 rounded border border-green-100">
                                    Rp {{ number_format(($p->budget->direct_personnel_cost_proposal ?? 0) + ($p->budget->non_personnel_cost_proposal ?? 0) + ($p->budget->indirect_cost_proposal ?? 0), 0, ',', '.') }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                @if($p->total_score)
                                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    <span class="font-bold">{{ number_format($p->total_score, 2) }}</span>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 italic">Not scored</span>
                                @endif
                            </td>

                            {{-- Status Badge --}}
                            <td class="px-6 py-5 whitespace-nowrap text-center">
                                @php
                                    $statusConfig = [
                                        'APPROVED'  => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'border' => 'border-green-200', 'icon' => 'CheckCircle'],
                                        'REJECTED'  => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'border' => 'border-red-200', 'icon' => 'XCircle'],
                                        'SUBMITTED' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'border' => 'border-blue-200', 'icon' => 'PaperAirplane'],
                                        'DRAFT'     => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'border' => 'border-gray-200', 'icon' => 'Document']
                                    ];
                                    $conf = $statusConfig[$p->status] ?? $statusConfig['DRAFT'];
                                @endphp
                                <span class="px-3 py-1.5 inline-flex items-center text-xs font-bold rounded-full {{ $conf['bg'] }} {{ $conf['text'] }} border {{ $conf['border'] }}">
                                    <span class="w-2 h-2 rounded-full bg-current mr-2 opacity-75"></span>
                                    {{ ucfirst(strtolower($p->status)) }}
                                </span>
                            </td>
                            
                            {{-- Actions --}}
                            <td class="px-6 py-5 whitespace-nowrap text-center">
                                <div class="flex justify-center items-center gap-3">
                                    {{-- View Button --}}
                                    <a href="{{ route('proposals.show', $p->id) }}" 
                                       class="group relative inline-flex items-center justify-center w-9 h-9 bg-white text-gray-500 rounded-lg hover:bg-red-50 hover:text-red-600 border border-gray-200 hover:border-red-200 transition-all shadow-sm" 
                                       title="Lihat Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    {{-- Download Button --}}
                                    <a href="{{ route('proposal.download', $p->id) }}" 
                                       target="_blank"
                                       class="group relative inline-flex items-center justify-center w-9 h-9 bg-white text-gray-500 rounded-lg hover:bg-green-50 hover:text-green-600 border border-gray-200 hover:border-green-200 transition-all shadow-sm"
                                       title="Download PDF">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-gray-50 p-4 rounded-full mb-3">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-lg font-semibold text-gray-700">Belum ada proposal</p>
                                    <p class="text-sm text-gray-500 mt-1 max-w-xs mx-auto">Anda belum mengajukan proposal apapun. Mulai dengan membuat proposal baru sekarang.</p>
                                    <a href="{{ route('proposals.create') }}" class="mt-4 text-sm font-semibold text-red-600 hover:text-red-700 hover:underline">
                                        + Buat Proposal Baru
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- FOOTER --}}
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-sm text-gray-600">
                    Menampilkan <span class="font-bold text-gray-900">{{ $proposals->firstItem() ?? 0 }}</span> sampai <span class="font-bold text-gray-900">{{ $proposals->lastItem() ?? 0 }}</span> dari <span class="font-bold text-gray-900">{{ $proposals->total() }}</span> hasil
                </div>
                <div class="flex items-center">
                    {{ $proposals->links('pagination::tailwind') }} 
                </div>
            </div>

        </div>
    </div>
</x-layouts.app>