<x-slot name="title">Fund Realization Report</x-slot>
<div class="min-h-screen bg-slate-50 pb-12 relative">
    
    {{-- HEADER BACKGROUND --}}
    <div class="absolute top-0 left-0 w-full h-64 bg-gradient-to-r from-red-700 via-red-600 to-red-800 z-0"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 pt-10">
        
        {{-- Header Section --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight drop-shadow-md">Fund Realization Report</h1>
                <p class="mt-2 text-sm text-red-100 font-medium max-w-2xl">
                    Kelola dan pantau realisasi anggaran proposal Anda. Pastikan penggunaan dana tercatat dengan akurat.
                </p>
            </div>
        </div>

        {{-- Main Card --}}
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            
            {{-- Toolbar (Filter & Search) --}}
            <div class="p-6 border-b border-gray-100 bg-white flex flex-col sm:flex-row justify-between items-center gap-4">
                
                {{-- Show Entries --}}
                <div class="flex items-center gap-3 bg-gray-50 px-4 py-2 rounded-lg border border-gray-200 w-full sm:w-auto">
                    <span class="text-sm font-medium text-gray-600">Show</span>
                    <select wire:model.live="perPage" class="border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md text-sm py-1 pl-2 pr-8 bg-white shadow-sm cursor-pointer">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span class="text-sm font-medium text-gray-600">entries</span>
                </div>

                {{-- Search Box --}}
                <div class="relative w-full sm:w-72">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="search" 
                        class="block w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 sm:text-sm transition duration-150 ease-in-out shadow-sm" 
                        placeholder="Search proposal...">
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/80">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Proposal Title</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Fund Plan</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Realization</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Remaining</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($budgets as $budget)
                            @php
                                $proposalStatus = strtolower($budget->proposal->status ?? '');
                                $budgetStatus   = strtolower($budget->status ?? '');

                                // Logika Penentuan Status Tampilan
                                if ($budgetStatus === 'done') {
                                    $displayStatus = 'done';
                                } elseif ($proposalStatus === 'approved') {
                                    $displayStatus = 'active'; 
                                } else {
                                    $displayStatus = 'waiting';
                                }
                            @endphp

                            <tr class="hover:bg-red-50/30 transition-colors duration-200 group">
                                {{-- Proposal Title --}}
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-gray-900 group-hover:text-red-700 transition-colors line-clamp-2" title="{{ $budget->proposal->title ?? '-' }}">
                                            {{ $budget->proposal->title ?? '-' }}
                                        </span>
                                        <span class="text-[10px] uppercase tracking-wide font-mono text-gray-400 mt-1 bg-gray-50 w-fit px-1.5 rounded border border-gray-200">
                                            {{ $budget->proposal->registration_code ?? 'NO-CODE' }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Fund Plan --}}
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="text-sm font-medium text-gray-700">
                                        Rp {{ number_format($budget->total_plan, 0, ',', '.') }}
                                    </span>
                                </td>

                                {{-- Fund Realization --}}
                                <td class="px-6 py-5 whitespace-nowrap">
                                    @if($budget->total_realization > 0)
                                        <span class="text-sm font-bold text-gray-900">
                                            Rp {{ number_format($budget->total_realization, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-sm text-gray-400 italic">-</span>
                                    @endif
                                </td>

                                {{-- Remaining Fund --}}
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-sm font-medium {{ $budget->remaining_fund < 0 ? 'bg-red-100 text-red-800' : 'bg-green-50 text-green-700' }}">
                                        Rp {{ number_format($budget->remaining_fund, 0, ',', '.') }}
                                    </span>
                                </td>

                                {{-- Status Column --}}
                                <td class="px-6 py-5 text-center whitespace-nowrap">
                                    @if($displayStatus === 'active')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-700 border border-orange-200 shadow-sm">
                                            <span class="w-2 h-2 bg-orange-500 rounded-full mr-1.5 animate-pulse"></span>
                                            Active
                                        </span>
                                    @elseif($displayStatus === 'done')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200 shadow-sm">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                            Done
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200">
                                            Waiting Approval
                                        </span>
                                    @endif
                                </td>

                                {{-- Action Column --}}
                                <td class="px-6 py-5 text-center whitespace-nowrap">
                                    <div class="flex justify-center items-center gap-2">
                                        
                                        {{-- ACTIVE: Edit Button --}}
                                        @if($displayStatus === 'active')
                                            <a href="{{ route('report.fund.edit', $budget->id) }}" 
                                               class="inline-flex items-center px-3 py-1.5 bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold rounded-lg transition-all shadow-md shadow-orange-200 transform hover:-translate-y-0.5" 
                                               title="Isi Realisasi">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                </svg>
                                                Input
                                            </a>

                                        {{-- DONE: View & Download Buttons --}}
                                        @elseif($displayStatus === 'done')
                                            {{-- View Button --}}
                                            <a href="{{ route('report.fund.show', $budget->id) }}" 
                                               class="group relative inline-flex items-center justify-center w-8 h-8 bg-white text-gray-500 rounded-lg hover:bg-gray-100 border border-gray-200 transition-all shadow-sm" 
                                               title="View Detail">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            {{-- Download Button --}}
                                            <a href="{{ route('report.fund.download', $budget->id) }}" 
                                               target="_blank" 
                                               class="group relative inline-flex items-center justify-center w-8 h-8 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 border border-green-200 transition-all shadow-sm" 
                                               title="Download Report PDF"> 
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </a>

                                        {{-- WAITING --}}
                                        @else
                                            <span class="text-xs text-gray-400 italic flex items-center justify-center gap-1 bg-gray-50 px-2 py-1 rounded">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Waiting
                                            </span>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="bg-gray-50 p-4 rounded-full mb-3">
                                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <p class="text-base font-medium text-gray-900">No Fund Reports Found</p>
                                        <p class="text-sm text-gray-500 mt-1">Belum ada data realisasi dana yang tersedia.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer: Pagination & Showing Info --}}
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-600">
                    Showing <span class="font-bold text-gray-900">{{ $budgets->firstItem() ?? 0 }}</span> to <span class="font-bold text-gray-900">{{ $budgets->lastItem() ?? 0 }}</span> of <span class="font-bold text-gray-900">{{ $budgets->total() }}</span> results
                </div>
                <div>
                    {{ $budgets->links() }}
                </div>
            </div>

        </div>
    </div>
</div>