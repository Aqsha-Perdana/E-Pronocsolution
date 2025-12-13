<x-layouts.app>
    <x-slot name="title">View Proposal</x-slot>
    <div class="container mx-auto px-4 py-8">
        
        {{-- Header Page --}}
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-4">
                <a href="/proposalutama" class="p-2 bg-white rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-red-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Proposal Details</h1>
                    <p class="text-sm text-gray-500">View detailed information about the proposal.</p>
                </div>
            </div>
            
            {{-- Status Badge --}}
            @php
                $statusColors = [
                    'APPROVED' => 'bg-green-100 text-green-700 border-green-200',
                    'REJECTED' => 'bg-red-100 text-red-700 border-red-200',
                    'SUBMITTED' => 'bg-blue-100 text-blue-700 border-blue-200',
                    'DRAFT' => 'bg-gray-100 text-gray-700 border-gray-200'
                ];
                $statusClass = $statusColors[$proposal->status] ?? 'bg-gray-100 text-gray-700 border-gray-200';
            @endphp
            <div class="px-4 py-2 rounded-lg border font-semibold text-sm {{ $statusClass }}">
                {{ $proposal->status }}
            </div>
        </div>

        <div class="grid grid-cols-12 gap-6">
            {{-- SIDEBAR NAVIGASI (Table of Contents) --}}
            <div class="col-span-12 md:col-span-3">
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 sticky top-24 transition-all duration-300">
                    <div class="flex items-center gap-2 mb-6 border-b border-gray-100 pb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                        <h3 class="font-bold text-gray-800 uppercase text-xs tracking-widest">Quick Navigation</h3>
                    </div>

                    <nav aria-label="Progress">
                        <ol role="list" class="overflow-hidden">
                            @php
                                $sections = [
                                    'general' => 'General Info',
                                    'team' => 'Team Member',
                                    'indicators' => 'Output Indicator',
                                    'budget' => 'Research Fund',
                                    'content' => 'Proposal Content',
                                    'documents' => 'Documents'
                                ];
                            @endphp
            
                            @foreach($sections as $id => $label)
                                <li class="relative {{ !$loop->last ? 'pb-8' : '' }}">
                                    @if(!$loop->last)
                                        <div class="absolute top-4 left-3.5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></div>
                                    @endif
                                    
                                    <a href="#{{ $id }}" class="relative flex items-center group w-full focus:outline-none">
                                        <span class="h-7 flex items-center" aria-hidden="true">
                                            <span class="relative z-10 w-7 h-7 flex items-center justify-center rounded-full border-2 border-gray-300 bg-white group-hover:border-red-500 group-hover:bg-red-50 group-focus:ring-2 group-focus:ring-red-500 transition-all duration-300 shadow-sm">
                                                <span class="h-2 w-2 bg-gray-300 rounded-full group-hover:bg-red-600 transition-colors duration-300"></span>
                                            </span>
                                        </span>
                                        
                                        <span class="ml-4 min-w-0 flex flex-col">
                                            <span class="text-sm font-medium text-gray-500 group-hover:text-red-700 group-hover:font-bold transition-all duration-300 transform group-hover:translate-x-1">
                                                {{ $label }}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ol>
                    </nav>
                </div>
            </div>

            {{-- MAIN CONTENT --}}
            <div class="col-span-12 md:col-span-9 space-y-8">
                
                {{-- 1. GENERAL INFO --}}
                <div id="general" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 scroll-mt-24">
                    <div class="flex items-center gap-3 border-b border-gray-100 pb-4 mb-6">
                        <div class="w-1 h-6 bg-red-600 rounded-full"></div>
                        <h2 class="text-lg font-bold text-gray-800">General Information</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Proposal Title</label>
                            <p class="text-xl font-bold text-gray-900 leading-snug">{{ $proposal->title }}</p>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Registration Code</label>
                            <div class="flex items-center gap-2">
                                <span class="font-mono text-sm text-gray-700 bg-gray-50 border border-gray-200 px-3 py-1.5 rounded-md">
                                    {{ $proposal->registration_code }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Submission Date</label>
                            <div class="flex items-center gap-2 text-gray-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="font-medium">{{ \Carbon\Carbon::parse($proposal->date)->format('d F Y') }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Focus Area</label>
                            <div class="flex items-center gap-2 text-gray-800 bg-white border border-gray-200 px-3 py-2 rounded-lg w-fit">
                                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                <span class="text-sm font-medium">{{ $proposal->focus_area }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Output Target</label>
                            <div class="flex items-center gap-2 text-gray-800 bg-white border border-gray-200 px-3 py-2 rounded-lg w-fit">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                <span class="text-sm font-medium">{{ $proposal->output }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. TEAM MEMBERS --}}
                <div id="team" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 scroll-mt-24">
                    <div class="flex items-center gap-3 border-b border-gray-100 pb-4 mb-6">
                        <div class="w-1 h-6 bg-red-600 rounded-full"></div>
                        <h2 class="text-lg font-bold text-gray-800">Team Members</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($proposal->teamMembers as $member)
                            <div class="flex items-start p-4 bg-white border border-gray-200 rounded-lg hover:border-red-200 transition-colors">
                                <div class="h-10 w-10 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center font-bold text-sm border border-gray-200 shrink-0">
                                    {{ substr($member->name, 0, 1) }}
                                </div>
                                
                                <div class="ml-3 flex-1 min-w-0">
                                    <div class="flex justify-between items-start">
                                        <div class="min-w-0 flex-1 mr-2">
                                            <h4 class="text-sm font-bold text-gray-900 truncate">{{ $member->name }}</h4>
                                            <p class="text-xs text-gray-500 font-mono mt-0.5 truncate">{{ $member->nip }}</p>
                                        </div>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium shrink-0 {{ $member->pivot->role == 'Ketua' ? 'text-red-700 bg-red-50 border border-red-100' : 'text-gray-600 bg-gray-50 border border-gray-200' }}">
                                            {{ $member->pivot->role }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-1 mt-2 text-xs text-gray-500 truncate">
                                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                        <span class="truncate">{{ $member->email }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- 3. OUTPUT INDICATORS --}}
                <div id="indicators" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 scroll-mt-24">
                    <div class="flex items-center gap-3 border-b border-gray-100 pb-4 mb-6">
                        <div class="w-1 h-6 bg-red-600 rounded-full"></div>
                        <h2 class="text-lg font-bold text-gray-800">Output Indicators</h2>
                    </div>

                    <div class="space-y-3">
                        @foreach($proposal->outputIndicators as $index => $indicator)
                            <div class="group flex items-start gap-4 p-4 rounded-lg border border-gray-100 hover:bg-gray-50 transition-colors">
                                <span class="shrink-0 flex items-center justify-center w-6 h-6 rounded bg-gray-100 text-gray-500 text-xs font-bold border border-gray-200">
                                    {{ $index + 1 }}
                                </span>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900 leading-snug">{{ $indicator->indicator }}</h4>
                                    @if($indicator->description)
                                        <p class="text-sm text-gray-500 mt-1 leading-relaxed">{{ $indicator->description }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- 4. RESEARCH FUND --}}
                <div id="budget" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 scroll-mt-24">
                    <div class="flex items-center gap-3 border-b border-gray-100 pb-4 mb-6">
                        <div class="w-1 h-6 bg-red-600 rounded-full"></div>
                        <h2 class="text-lg font-bold text-gray-800">Research Fund</h2>
                    </div>
                    
                    @php
                        $total = ($proposal->budget->direct_personnel_cost_proposal ?? 0) + 
                                ($proposal->budget->non_personnel_cost_proposal ?? 0) + 
                                ($proposal->budget->indirect_cost_proposal ?? 0);
                    @endphp
                    
                    <div class="bg-gray-50 rounded-lg p-5 mb-6 border border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div>
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Total Budget Plan</span>
                            <div class="flex items-baseline gap-1">
                                <span class="text-sm text-gray-500 font-medium">Rp</span>
                                <span class="text-3xl font-bold text-gray-900">{{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        
                        {{-- Tombol Download RAB --}}
                        @if($proposal->budget && $proposal->budget->document_rab_proposal)
                            <a href="{{ asset('storage/' . $proposal->budget->document_rab_proposal) }}" 
                               target="_blank" 
                               class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-red-600 hover:border-red-200 transition-all shadow-sm">
                                
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Download RAB
                            </a>
                        @else
                            <span class="text-sm text-gray-400 italic px-4 py-2 border border-gray-100 rounded-lg bg-gray-50">
                                Tidak ada dokumen RAB
                            </span>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach([
                            'Direct Personnel' => $proposal->budget->direct_personnel_cost_proposal ?? 0,
                            'Direct Non-Personnel' => $proposal->budget->non_personnel_cost_proposal ?? 0,
                            'Indirect Cost' => $proposal->budget->indirect_cost_proposal ?? 0
                        ] as $label => $amount)
                            <div class="p-4 border border-gray-100 rounded-lg hover:border-gray-300 transition-colors">
                                <p class="text-xs text-gray-400 font-bold uppercase mb-1">{{ $label }}</p>
                                <p class="text-sm font-bold text-gray-800">Rp {{ number_format($amount, 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- 5. PROPOSAL CONTENT (CORRECTED SECTION) --}}
                <div id="content" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 scroll-mt-24">
                    <div class="flex items-center gap-3 border-b border-gray-100 pb-4 mb-6">
                        <div class="w-1 h-6 bg-red-600 rounded-full"></div>
                        <h2 class="text-lg font-bold text-gray-800">Proposal Content</h2>
                    </div>

                    <div class="space-y-8">
                        @foreach(['Abstract' => 'abstract', 'Introduction' => 'introduction', 'Project Method' => 'project_method', 'Bibliography' => 'bibliography'] as $title => $key)
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-3 flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-gray-300 rounded-full"></span> {{ $title }}
                                </h3>
                                {{-- Added break-all and overflow-wrap classes here --}}
                                <div class="prose prose-sm max-w-none text-gray-600 bg-gray-50/50 p-4 rounded-lg border border-gray-100 break-words overflow-hidden">
                                    {!! $proposal->$key !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- 6. DOCUMENTS --}}
                <div id="documents" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 scroll-mt-24">
                    <div class="flex items-center gap-3 border-b border-gray-100 pb-4 mb-6">
                        <div class="w-1 h-6 bg-red-600 rounded-full"></div>
                        <h2 class="text-lg font-bold text-gray-800">Supporting Documents</h2>
                    </div>

                    @if($proposal->statement_letter)
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg bg-white hover:border-red-200 hover:shadow-sm transition-all group">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 bg-red-50 text-red-600 rounded-lg flex items-center justify-center border border-red-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900 group-hover:text-red-600 transition-colors">Surat Pernyataan</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">PDF Document • Statement Letter</p>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $proposal->statement_letter) }}" target="_blank" class="p-2 text-gray-400 hover:text-red-600 transition-colors" title="Download">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            </a>
                        </div>
                    @else
                        <div class="text-center py-10 px-4 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
                            <svg class="mx-auto h-8 w-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <p class="mt-2 text-sm text-gray-500">No supporting documents uploaded.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-layouts.app>