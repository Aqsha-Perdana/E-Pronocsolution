@php
    $page = $page ?? 'review';

    $proposals = \App\Models\Proposal::with(['teams.member', 'budgets'])
        ->where('status', 'SUBMITTED')
        ->orderBy('created_at', 'desc')
        ->get();
@endphp
<x-layouts.app>
    <div class="container mx-auto px-4 py-8">
        
        {{-- HEADER: Title & New Proposal Button --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-800">Proposal Submission</h1>
            <a href="{{ route('proposals.create') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 shadow-sm transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                <span>New Proposal</span>
            </a>
        </div>

        {{-- CONTENT CARD --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            
            {{-- TOOLBAR: Show Entries (Hanya UI, butuh update Controller agar berfungsi real) --}}
            <div class="flex flex-col md:flex-row justify-between items-center p-6 border-b border-gray-100 bg-gray-50/50 gap-4">
                <div class="flex items-center text-sm text-gray-600">
                    <span class="mr-2">Show</span>
                    <select onchange="window.location.href = this.value" class="border-gray-300 rounded-lg text-sm focus:border-red-500 focus:ring-red-500 py-1.5 pl-3 pr-8 bg-white shadow-sm">
                        <option value="{{ request()->fullUrlWithQuery(['per_page' => 10]) }}" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="{{ request()->fullUrlWithQuery(['per_page' => 25]) }}" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="{{ request()->fullUrlWithQuery(['per_page' => 50]) }}" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                    <span class="ml-2">entries</span>
                </div>

                {{-- Optional: Search Box Placeholder --}}
                <div class="relative w-full md:w-64">
                    <input type="text" placeholder="Search proposal..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:border-red-500 focus:ring-red-500">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" /></svg>
                    </div>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Proposal Title</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Budget</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($proposals as $p)
                        <tr class="hover:bg-gray-50 transition-colors duration-150 group">
                            {{-- Title --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900 group-hover:text-red-700 transition-colors">{{ $p->title }}</div>
                                <div class="text-xs text-gray-500 mt-0.5 font-mono">{{ $p->registration_code ?? 'NO-CODE' }}</div>
                            </td>
                            
                            {{-- Date --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    {{ \Carbon\Carbon::parse($p->date)->format('d M Y') }}
                                </div>
                            </td>
                            
                            {{-- Budget --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-900">
                                    Rp. {{ number_format($proposal->budgets->sum('total_cost'), 0, ',', '.') }}
                                </span>
                            </td>
                            
                            {{-- Status Badge (Clean Pill Style) --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @php
                                    $statusClasses = [
                                        'APPROVED' => 'bg-green-100 text-green-700 border border-green-200',
                                        'REJECTED' => 'bg-red-100 text-red-700 border border-red-200',
                                        'SUBMITTED' => 'bg-blue-100 text-blue-700 border border-blue-200',
                                        'DRAFT' => 'bg-gray-100 text-gray-700 border border-gray-200'
                                    ];
                                    $class = $statusClasses[$p->status] ?? 'bg-gray-100 text-gray-700 border border-gray-200';
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $class }}">
                                    {{ ucfirst(strtolower($p->status)) }}
                                </span>
                            </td>
                            
                            {{-- Actions --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex justify-center items-center gap-2">
                                    {{-- View Button --}}
                                    <a href="{{ route('proposals.show', $p->id) }}" 
                                       class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200" 
                                       title="View Details">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    {{-- Download Button --}}
                                    <a href="{{ route('proposal.download', $p->id) }}" 
                                       target="_blank"
                                       class="p-2 text-gray-500 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200"
                                       title="Download PDF">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <p class="text-base font-medium text-gray-600">No proposals found</p>
                                    <p class="text-sm text-gray-400 mt-1">Get started by creating a new proposal.</p>
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
                    Showing <span class="font-bold">{{ $proposals->firstItem() ?? 0 }}</span> to <span class="font-bold">{{ $proposals->lastItem() ?? 0 }}</span> of <span class="font-bold">{{ $proposals->total() }}</span> results
                </div>
                <div class="flex items-center">
                    {{ $proposals->links('pagination::tailwind') }} 
                </div>
            </div>

        </div>
    </div>
</x-layouts.app>