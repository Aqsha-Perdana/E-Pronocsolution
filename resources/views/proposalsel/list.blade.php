@php
    $page = $page ?? 'list';
    
    $proposals = \App\Models\Proposal::with(['progressReport', 'finalReport'])
        ->orderBy('created_at', 'desc')
        ->get();
    
    // Hitung statistik status proposal
    $totalProposals = $proposals->count();
    $approvedCount = $proposals->where('status', 'APPROVED')->count();
    $pendingCount = $proposals->where('status', 'SUBMITTED')->count();
    $rejectedCount = $proposals->where('status', 'REJECTED')->count();
    
    // Hitung statistik progress report
    $inProgressCount = $proposals->filter(function($p) {
        return $p->progressReport && $p->progressReport->status === 'In Progress';
    })->count();
    $completeCount = $proposals->filter(function($p) {
        return $p->progressReport && $p->progressReport->status === 'Complete';
    })->count();
    
    // Hitung statistik final report
    $doneCount = $proposals->filter(function($p) {
        return $p->finalReport && $p->finalReport->status === 'Done';
    })->count();
    $finalPendingCount = $proposals->filter(function($p) {
        return $p->finalReport && $p->finalReport->status === 'Pending';
    })->count();
@endphp

<!-- Info Banner -->
<div class="mb-6 p-5 bg-gradient-to-r from-indigo-50 to-purple-50 border-l-4 border-indigo-600 rounded-lg shadow-sm">
    <div class="flex items-start gap-4">
        <div class="flex-shrink-0">
            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
        </div>
        <div class="flex-1">
            <h3 class="text-lg font-semibold text-gray-800 mb-1">Project Management</h3>
            <p class="text-sm text-gray-600 leading-relaxed mb-3">
                Kelola dan pantau semua proposal proyek penelitian beserta progress dan final report. Gunakan filter untuk melihat berdasarkan status.
            </p>
            
            <!-- Proposal Statistics -->
            <div class="mb-4">
                <h4 class="text-sm font-semibold text-gray-700 mb-2">Proposal Status</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <div class="bg-white rounded-lg p-3 shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Total Projects</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $totalProposals }}</p>
                            </div>
                            <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg p-3 shadow-sm border border-green-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-green-600 mb-1">Approved</p>
                                <p class="text-2xl font-bold text-green-700">{{ $approvedCount }}</p>
                            </div>
                            <svg class="w-8 h-8 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg p-3 shadow-sm border border-yellow-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-yellow-600 mb-1">Submitted</p>
                                <p class="text-2xl font-bold text-yellow-700">{{ $pendingCount }}</p>
                            </div>
                            <svg class="w-8 h-8 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg p-3 shadow-sm border border-red-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-red-600 mb-1">Rejected</p>
                                <p class="text-2xl font-bold text-red-700">{{ $rejectedCount }}</p>
                            </div>
                            <svg class="w-8 h-8 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Report Statistics -->
            <div class="mb-4">
                <h4 class="text-sm font-semibold text-gray-700 mb-2">Progress Report Status</h4>
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-white rounded-lg p-3 shadow-sm border border-blue-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-blue-600 mb-1">In Progress</p>
                                <p class="text-2xl font-bold text-blue-700">{{ $inProgressCount }}</p>
                            </div>
                            <svg class="w-8 h-8 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg p-3 shadow-sm border border-green-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-green-600 mb-1">Complete</p>
                                <p class="text-2xl font-bold text-green-700">{{ $completeCount }}</p>
                            </div>
                            <svg class="w-8 h-8 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Final Report Statistics -->
            <div>
                <h4 class="text-sm font-semibold text-gray-700 mb-2">Final Report Status</h4>
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-white rounded-lg p-3 shadow-sm border border-purple-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-purple-600 mb-1">Done</p>
                                <p class="text-2xl font-bold text-purple-700">{{ $doneCount }}</p>
                            </div>
                            <svg class="w-8 h-8 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg p-3 shadow-sm border border-orange-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-orange-600 mb-1">Pending</p>
                                <p class="text-2xl font-bold text-orange-700">{{ $finalPendingCount }}</p>
                            </div>
                            <svg class="w-8 h-8 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<h2 class="text-2xl font-bold mb-4">Project List</h2>
<div class="mb-4 flex gap-3 flex-wrap">
    <!-- Filter Proposal Status -->
    <div class="relative inline-block w-64">
        <button onclick="toggleDropdown('proposal')" class="w-full px-4 py-2 text-sm text-left rounded-lg border border-gray-300 bg-white flex justify-between items-center hover:border-gray-400 transition">
            <span id="selectedFilterProposal">Proposal: All</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        
        <div id="dropdownMenuProposal" class="hidden absolute mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-lg z-10">
            <button onclick="filterByProposal('all')" class="w-full px-4 py-2 text-sm text-left hover:bg-gray-100 transition">All</button>
            <button onclick="filterByProposal('APPROVED')" class="w-full px-4 py-2 text-sm text-left hover:bg-gray-100 transition flex items-center">
                <span class="w-3 h-3 rounded-full mr-2 bg-green-500"></span>Approved
            </button>
            <button onclick="filterByProposal('Submitted')" class="w-full px-4 py-2 text-sm text-left hover:bg-gray-100 transition flex items-center">
                <span class="w-3 h-3 rounded-full mr-2 bg-yellow-500"></span>Submitted
            </button>
            <button onclick="filterByProposal('REJECTED')" class="w-full px-4 py-2 text-sm text-left hover:bg-gray-100 transition flex items-center">
                <span class="w-3 h-3 rounded-full mr-2 bg-red-500"></span>Rejected
            </button>
        </div>
    </div>

    <!-- Filter Progress Report Status -->
    <div class="relative inline-block w-64">
        <button onclick="toggleDropdown('progress')" class="w-full px-4 py-2 text-sm text-left rounded-lg border border-gray-300 bg-white flex justify-between items-center hover:border-gray-400 transition">
            <span id="selectedFilterProgress">Progress: All</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        
        <div id="dropdownMenuProgress" class="hidden absolute mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-lg z-10">
            <button onclick="filterByProgress('all')" class="w-full px-4 py-2 text-sm text-left hover:bg-gray-100 transition">All</button>
            <button onclick="filterByProgress('In Progress')" class="w-full px-4 py-2 text-sm text-left hover:bg-gray-100 transition flex items-center">
                <span class="w-3 h-3 rounded-full mr-2 bg-blue-500"></span>In Progress
            </button>
            <button onclick="filterByProgress('Complete')" class="w-full px-4 py-2 text-sm text-left hover:bg-gray-100 transition flex items-center">
                <span class="w-3 h-3 rounded-full mr-2 bg-green-500"></span>Complete
            </button>
            <button onclick="filterByProgress('N/A')" class="w-full px-4 py-2 text-sm text-left hover:bg-gray-100 transition flex items-center">
                <span class="w-3 h-3 rounded-full mr-2 bg-gray-400"></span>No Progress Report
            </button>
        </div>
    </div>

    <!-- Filter Final Report Status -->
    <div class="relative inline-block w-64">
        <button onclick="toggleDropdown('final')" class="w-full px-4 py-2 text-sm text-left rounded-lg border border-gray-300 bg-white flex justify-between items-center hover:border-gray-400 transition">
            <span id="selectedFilterFinal">Final: All</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        
        <div id="dropdownMenuFinal" class="hidden absolute mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-lg z-10">
            <button onclick="filterByFinal('all')" class="w-full px-4 py-2 text-sm text-left hover:bg-gray-100 transition">All</button>
            <button onclick="filterByFinal('FINISHED')" class="w-full px-4 py-2 text-sm text-left hover:bg-gray-100 transition flex items-center">
                <span class="w-3 h-3 rounded-full mr-2 bg-purple-500"></span>Done
            </button>
            <button onclick="filterByFinal('SUBMITTED')" class="w-full px-4 py-2 text-sm text-left hover:bg-orange-100 transition flex items-center">
                <span class="w-3 h-3 rounded-full mr-2 bg-orange-500"></span>Pending
            </button>
            <button onclick="filterByFinal('N/A')" class="w-full px-4 py-2 text-sm text-left hover:bg-gray-100 transition flex items-center">
                <span class="w-3 h-3 rounded-full mr-2 bg-gray-400"></span>No Final Report
            </button>
        </div>
    </div>
</div>

<div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
        <thead>
            <tr class="bg-gray-100 border-b">
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">No. Reg</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Title</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Date</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Proposal Status</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Progress Status</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Final Status</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Action</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-200" id="tableBody">
            @forelse($proposals as $proposal)
            <tr class="proposal-row" 
                data-proposal-status="{{ $proposal->status }}"
                data-progress-status="{{ $proposal->progressReport->status ?? 'N/A' }}"
                data-final-status="{{ $proposal->finalReport->status ?? 'N/A' }}">
                <td class="px-6 py-4 text-gray-800">{{ $proposal->registration_code }}</td>
                <td class="px-6 py-4 text-gray-800">{{ $proposal->title }}</td>
                <td class="px-6 py-4 text-gray-800">{{ \Carbon\Carbon::parse($proposal->date ?? $proposal->created_at)->format('d M Y') }}</td>
                
                <!-- Proposal Status -->
                <td class="px-6 py-4">
                    @php
                        $statusLower = strtolower($proposal->status ?? '');
                        $statusStyles = [
                            'approved' => 'background-color: #d1fae5; color: #065f46;',
                            'submitted' => 'background-color: #fef3c7; color: #92400e;',
                            'rejected' => 'background-color: #fee2e2; color: #991b1b;',
                            'default' => 'background-color: #f3f4f6; color: #374151;'
                        ];
                        $style = $statusStyles[$statusLower] ?? $statusStyles['default'];
                    @endphp
                    <span style="{{ $style }}" class="px-3 py-1 text-sm rounded-full inline-block">
                        {{ ucfirst($proposal->status ?? 'N/A') }}
                    </span>
                </td>
                
                <!-- Progress Report Status -->
                <td class="px-6 py-4">
                    @if($proposal->progressReport)
                        @php
                            $progressStatusLower = strtolower($proposal->progressReport->status ?? '');
                            $progressStyles = [
                                'in progress' => 'background-color: #dbeafe; color: #1e40af;',
                                'complete' => 'background-color: #d1fae5; color: #065f46;',
                                'default' => 'background-color: #f3f4f6; color: #374151;'
                            ];
                            $progressStyle = $progressStyles[$progressStatusLower] ?? $progressStyles['default'];
                        @endphp
                        <span style="{{ $progressStyle }}" class="px-3 py-1 text-sm rounded-full inline-block">
                            {{ $proposal->progressReport->status }}
                        </span>
                    @else
                        <span class="px-3 py-1 text-sm rounded-full inline-block bg-gray-100 text-gray-600">
                            N/A
                        </span>
                    @endif
                </td>
                
                <!-- Final Report Status -->
                <td class="px-6 py-4">
                    @if($proposal->finalReport)
                        @php
                            $finalStatusLower = strtolower($proposal->finalReport->status ?? '');
                            $finalStyles = [
                                'done' => 'background-color: #e9d5ff; color: #6b21a8;',
                                'pending' => 'background-color: #fed7aa; color: #9a3412;',
                                'default' => 'background-color: #f3f4f6; color: #374151;'
                            ];
                            $finalStyle = $finalStyles[$finalStatusLower] ?? $finalStyles['default'];
                        @endphp
                        <span style="{{ $finalStyle }}" class="px-3 py-1 text-sm rounded-full inline-block">
                            {{ $proposal->finalReport->status }}
                        </span>
                    @else
                        <span class="px-3 py-1 text-sm rounded-full inline-block bg-gray-100 text-gray-600">
                            N/A
                        </span>
                    @endif
                </td>
                
                <td class="px-6 py-4 text-center">
                    <button class="px-4 py-2 text-sm bg-[#D31119] text-white rounded-lg hover:bg-red-800 transition">
                        View
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                    Tidak ada data proposal
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div id="noResults" class="hidden px-6 py-8 text-center text-gray-500">
        <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
        </svg>
        <p class="text-lg font-medium">Tidak ada data yang sesuai dengan filter</p>
    </div>
</div>

<script>
let currentFilters = {
    proposal: 'all',
    progress: 'all',
    final: 'all'
};

function toggleDropdown(type) {
    const dropdown = document.getElementById('dropdownMenu' + type.charAt(0).toUpperCase() + type.slice(1));
    dropdown.classList.toggle('hidden');
    
    // Close other dropdowns
    ['proposal', 'progress', 'final'].forEach(t => {
        if (t !== type) {
            const otherDropdown = document.getElementById('dropdownMenu' + t.charAt(0).toUpperCase() + t.slice(1));
            otherDropdown.classList.add('hidden');
        }
    });
}

function filterByProposal(status) {
    currentFilters.proposal = status;
    document.getElementById('selectedFilterProposal').textContent = 'Proposal: ' + (status === 'all' ? 'All' : status);
    document.getElementById('dropdownMenuProposal').classList.add('hidden');
    applyFilters();
}

function filterByProgress(status) {
    currentFilters.progress = status;
    document.getElementById('selectedFilterProgress').textContent = 'Progress: ' + (status === 'all' ? 'All' : status);
    document.getElementById('dropdownMenuProgress').classList.add('hidden');
    applyFilters();
}

function filterByFinal(status) {
    currentFilters.final = status;
    document.getElementById('selectedFilterFinal').textContent = 'Final: ' + (status === 'all' ? 'All' : status);
    document.getElementById('dropdownMenuFinal').classList.add('hidden');
    applyFilters();
}

function applyFilters() {
    const rows = document.querySelectorAll('.proposal-row');
    const noResults = document.getElementById('noResults');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const proposalStatus = row.getAttribute('data-proposal-status');
        const progressStatus = row.getAttribute('data-progress-status');
        const finalStatus = row.getAttribute('data-final-status');
        
        let showRow = true;
        
        // Filter by proposal status
        if (currentFilters.proposal !== 'all' && proposalStatus !== currentFilters.proposal) {
            showRow = false;
        }
        
        // Filter by progress status
        if (currentFilters.progress !== 'all' && progressStatus !== currentFilters.progress) {
            showRow = false;
        }
        
        // Filter by final status
        if (currentFilters.final !== 'all' && finalStatus !== currentFilters.final) {
            showRow = false;
        }
        
        if (showRow) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    // Show/hide no results message
    if (visibleCount === 0 && rows.length > 0) {
        noResults.classList.remove('hidden');
    } else {
        noResults.classList