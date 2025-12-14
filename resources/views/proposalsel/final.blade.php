@php
    $page = $page ?? 'final';
    
    // Debug: Cek semua progress reports yang Complete
    $progressComplete = \DB::table('progress_reports')
        ->where('status', 'Complete')
        ->get();
    
    // Debug: Cek semua final reports
    $allFinalReports = \DB::table('final_reports')->get();
    
    // Query utama
    $finalReports = \DB::table('final_reports')
        ->join('proposals', 'final_reports.proposal_id', '=', 'proposals.id')
        ->join('progress_reports', 'progress_reports.proposal_id', '=', 'proposals.id')
        ->where('progress_reports.status', 'Complete')
        ->where('final_reports.status', '!=', 'FINISHED')
        ->leftJoin('proposal_teams', 'proposal_teams.proposal_id', '=', 'proposals.id')
        ->leftJoin('users', 'users.id', '=', 'proposal_teams.user_id')
        ->leftJoin('budgets', 'budgets.proposal_id', '=', 'proposals.id')
        ->select(
            'final_reports.id',
            'final_reports.status',
            'progress_reports.status as progress_status',
            'proposals.registration_code',
            'proposals.title',
            'proposals.focus_area',
            \DB::raw('GROUP_CONCAT(DISTINCT users.name SEPARATOR ", ") as team_members'),
            \DB::raw('SUM(budgets.direct_personnel_cost_proposal + budgets.non_personnel_cost_proposal + budgets.indirect_cost_proposal) as budget_planning'),
            \DB::raw('SUM(budgets.direct_personnel_cost_fundrealization + budgets.non_personnel_cost_fundrealization + budgets.indirect_cost_fundrealization) as budget_realization')
        )
        ->groupBy(
            'final_reports.id',
            'final_reports.status',
            'progress_reports.status',
            'proposals.registration_code',
            'proposals.title',
            'proposals.focus_area'
        )
        ->get();
@endphp

<div class="mb-6 p-5 bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-indigo-500 rounded-lg shadow-sm">
    <div class="flex items-start gap-4">
        <div class="flex-shrink-0">
            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
        </div>
        <div class="flex-1">
            <h3 class="text-lg font-semibold text-gray-800 mb-1">Final Report Review</h3>
            <p class="text-sm text-gray-600 leading-relaxed">
                Halaman ini menampilkan daftar final report yang siap untuk direview. Hanya proposal dengan progress report berstatus <span class="font-semibold text-green-700">"Complete"</span> yang akan muncul di daftar ini.
            </p>
            <div class="mt-3 flex items-center gap-4 text-xs text-gray-500">
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                    </svg>
                    Total: {{ count($finalReports) }} laporan
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                    Perlu ditinjau
                </span>
            </div>
        </div>
    </div>
</div>

<h2 class="text-2xl font-bold mb-4">Final Report</h2>
<table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
    <thead>
        <tr class="bg-gray-100 border-b">
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">NO</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">PROPOSAL INFORMATION</th>
            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Budget Planning</th>
            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Fund Realization</th>
            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Status</th>
            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">ACTION</th>
        </tr>
    </thead>

    <tbody class="divide-y divide-gray-200">
        @forelse ($finalReports as $index => $report)
        <tr>
            <td class="px-6 py-4">{{ $index + 1 }}</td>

            <td class="px-6 py-4">
                <div class="space-y-1">
                    <div>
                        <span class="font-semibold">Code-REG</span> :
                        {{ $report->registration_code ?? 'N/A' }}
                    </div>

                    <div>
                        <span class="font-semibold">Title</span> :
                        {{ $report->title ?? 'N/A' }}
                    </div>
                    <div>
                        <span class="font-semibold">Focus</span> :
                        {{ $report->focus_area ?? 'N/A' }}
                    </div>
                    <div>
                        <span class="font-semibold">Teams</span> :
                        {{ $report->team_members ?? 'N/A' }}
                    </div>
                </div>
            </td>

            <td class="px-6 py-4 text-center">
                Rp {{ number_format($report->budget_planning ?? 0, 0, ',', '.') }}
            </td>

            <td class="px-6 py-4 text-center">
                Rp {{ number_format($report->budget_realization ?? 0, 0, ',', '.') }}
            </td>
            
            <td class="px-6 py-4 text-center">
                <div class="flex flex-col gap-1">
                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                        Final: {{ $report->status }}
                    </span>
                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                        Progress: {{ $report->progress_status }}
                    </span>
                </div>
            </td>
            
            <td class="px-6 py-4 text-center align-center">
                <div class="flex flex-col gap-1.5">
                    
                    <a href="{{ route('proposalsel.finalreview', $report->id) }}"
                        class="px-3 py-1.5 text-xs bg-red-600 text-white rounded font-medium 
                        hover:bg-red-700 transition flex items-center justify-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Add Review</span>
                    </a>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center py-4 text-gray-500">
                Tidak ada final report dengan progress report "Complete"
            </td>
        </tr>
        @endforelse
    </tbody>
</table>