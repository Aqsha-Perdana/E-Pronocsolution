<x-slot name="title">View Fund Realization Report</x-slot>
<div class="min-h-screen bg-slate-50 py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        
        {{-- Header Section --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Realization Detail</h1>
                <p class="text-slate-500 text-sm mt-1">View the details of the approved budget realization.</p>
            </div>
            <a href="{{ route('report.fund') }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-lg font-medium text-slate-700 hover:bg-slate-50 transition shadow-sm text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to List
            </a>
        </div>

        {{-- Status & Proposal Info Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-6">
            <div class="p-6 flex flex-col md:flex-row md:items-start justify-between gap-6">
                
                {{-- Proposal Details --}}
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-500 border border-slate-200">
                            {{ $budget->proposal->registration_code ?? 'NO-CODE' }}
                        </span>
                        {{-- Badge Status --}}
                        @if(strtolower($budget->status) == 'done')
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Completed
                            </span>
                        @else
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-orange-100 text-orange-700 border border-orange-200">
                                In Progress
                            </span>
                        @endif
                    </div>
                    <h2 class="text-xl font-bold text-slate-900 leading-tight">
                        {{ $budget->proposal->title }}
                    </h2>
                    <p class="text-sm text-slate-500 mt-2">
                        Submitted on {{ $budget->created_at->format('d M Y, H:i') }}
                    </p>
                </div>

                {{-- Total Remaining (Highlight) --}}
                <div class="min-w-[200px] text-right">
                    <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Remaining Fund</span>
                    <div class="text-2xl font-bold {{ $budget->remaining_fund < 0 ? 'text-red-600' : 'text-slate-800' }}">
                        <span class="text-sm font-normal text-slate-400 mr-1">Rp.</span>
                        {{ number_format($budget->remaining_fund, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- Left Column: Financial Breakdown --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Card Breakdown --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Expenditure Breakdown</h3>
                    </div>
                    <div class="divide-y divide-slate-100">
                        
                        {{-- Item 1 --}}
                        <div class="p-5 flex justify-between items-center hover:bg-slate-50 transition">
                            <div>
                                <p class="text-sm font-semibold text-slate-700">Direct Personnel Costs</p>
                                <p class="text-xs text-slate-400 mt-0.5">Biaya Tenaga Lapangan (Non Dosen)</p>
                            </div>
                            <div class="text-sm font-bold text-slate-800">
                                Rp. {{ number_format($budget->direct_personnel_cost_fundrealization, 0, ',', '.') }}
                            </div>
                        </div>

                        {{-- Item 2 --}}
                        <div class="p-5 flex justify-between items-center hover:bg-slate-50 transition">
                            <div>
                                <p class="text-sm font-semibold text-slate-700">Direct Non-Personnel Costs</p>
                                <p class="text-xs text-slate-400 mt-0.5">Barang Habis Pakai (Non Aset)</p>
                            </div>
                            <div class="text-sm font-bold text-slate-800">
                                Rp. {{ number_format($budget->non_personnel_cost_fundrealization, 0, ',', '.') }}
                            </div>
                        </div>

                        {{-- Item 3 --}}
                        <div class="p-5 flex justify-between items-center hover:bg-slate-50 transition">
                            <div>
                                <p class="text-sm font-semibold text-slate-700">Indirect Costs</p>
                                <p class="text-xs text-slate-400 mt-0.5">Biaya Perjalanan Dinas & Pengelolaan</p>
                            </div>
                            <div class="text-sm font-bold text-slate-800">
                                Rp. {{ number_format($budget->indirect_cost_fundrealization, 0, ',', '.') }}
                            </div>
                        </div>

                        {{-- Total Realization Row --}}
                        <div class="p-5 bg-red-50 flex justify-between items-center border-t border-red-100">
                            <p class="text-sm font-bold text-red-800">Total Realization</p>
                            <div class="text-lg font-bold text-red-700">
                                Rp. {{ number_format($budget->total_realization, 0, ',', '.') }}
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            {{-- Right Column: Summary & Attachments --}}
            <div class="space-y-6">

                {{-- Fund Plan Summary --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 3.666A5.106 5.106 0 0112 16c-2.757 0-5-2.299-5-6.416M9 21h6a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-700">Budget Overview</h3>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Initial Plan</span>
                            <span class="font-medium text-slate-900">Rp. {{ number_format($budget->total_plan, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Total Used</span>
                            <span class="font-medium text-red-600">- Rp. {{ number_format($budget->total_realization, 0, ',', '.') }}</span>
                        </div>
                        <div class="pt-3 border-t border-slate-100 flex justify-between items-center">
                            <span class="text-xs font-bold text-slate-400 uppercase">Balance</span>
                            <span class="font-bold text-slate-900">Rp. {{ number_format($budget->remaining_fund, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Attachment Card --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                        <h3 class="text-sm font-bold text-slate-800">Attachments</h3>
                    </div>
                    <div class="p-6">
                        @if($budget->document_rab_fundrealization)
                            <div class="flex items-start gap-4 p-4 border border-slate-200 rounded-lg bg-slate-50/50 group hover:border-blue-300 hover:bg-blue-50/30 transition">
                                <div class="flex-shrink-0">
                                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-slate-900 truncate">
                                        RAB Document
                                    </p>
                                    <p class="text-xs text-slate-500 truncate">
                                        {{ basename($budget->document_rab_fundrealization) }}
                                    </p>
                                </div>
                                <a href="{{ asset('storage/' . $budget->document_rab_fundrealization) }}" target="_blank" class="p-2 text-slate-400 hover:text-blue-600 transition" title="Download">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                </a>
                            </div>
                        @else
                            <div class="text-center py-6 text-slate-400 text-sm italic">
                                No document attached.
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>