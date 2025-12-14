@php
    $page = $page ?? 'progress';
    $progressReports = \DB::table('progress_reports')
        ->join('proposals', 'progress_reports.proposal_id', '=', 'proposals.id')
        ->leftJoin('proposal_teams', 'proposal_teams.proposal_id', '=', 'proposals.id')
        ->leftJoin('users', 'users.id', '=', 'proposal_teams.user_id')
        ->where('progress_reports.status', 'In Progress')
        ->select(
            'progress_reports.id',
            'progress_reports.percentage_complete',
            'progress_reports.status',
            'progress_reports.notes',
            'proposals.registration_code',
            'proposals.title',
            'proposals.focus_area',
            \DB::raw('GROUP_CONCAT(DISTINCT users.name SEPARATOR ", ") as team_members')
        )
        ->groupBy(
            'progress_reports.id',
            'progress_reports.percentage_complete',
            'progress_reports.status',
            'progress_reports.notes',
            'proposals.registration_code',
            'proposals.title',
            'proposals.focus_area'
        )
        ->get();
    
    // Hitung statistik
    $totalReports = $progressReports->count();
    $avgProgress = $totalReports > 0 ? $progressReports->avg('percentage_complete') : 0;
    $nearCompletion = $progressReports->where('percentage_complete', '>=', 80)->count();
@endphp

<!-- Info Banner -->
<div class="mb-6 p-5 bg-gradient-to-r from-orange-50 to-amber-50 border-l-4 border-orange-500 rounded-lg shadow-sm">
    <div class="flex items-start gap-4">
        <div class="flex-shrink-0">
            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
        </div>
        <div class="flex-1">
            <h3 class="text-lg font-semibold text-gray-800 mb-1">Progress Report Monitoring</h3>
            <p class="text-sm text-gray-600 leading-relaxed mb-3">
                Pantau dan review progres pelaksanaan proyek penelitian yang sedang berjalan. Halaman ini menampilkan laporan dengan status <span class="font-semibold text-orange-700">"In Progress"</span>.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div class="bg-white rounded-lg p-3 shadow-sm border border-orange-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Active Projects</p>
                            <p class="text-2xl font-bold text-orange-700">{{ $totalReports }}</p>
                        </div>
                        <svg class="w-8 h-8 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <div class="bg-white rounded-lg p-3 shadow-sm border border-blue-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Average Progress</p>
                            <p class="text-2xl font-bold text-blue-700">{{ number_format($avgProgress, 1) }}%</p>
                        </div>
                        <svg class="w-8 h-8 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <div class="bg-white rounded-lg p-3 shadow-sm border border-green-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Near Completion</p>
                            <p class="text-2xl font-bold text-green-700">{{ $nearCompletion }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">≥80% progress</p>
                        </div>
                        <svg class="w-8 h-8 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<h2 class="text-2xl font-bold mb-4">Progress Report</h2>
<table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
    <thead>
        <tr class="bg-gray-100 border-b">
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">NO</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">PROPOSAL INFORMATION</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Percentage Progress</th>
            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Status</th>
            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Quick Notes</th>
            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">ACTION</th>
        </tr>
    </thead>

    <tbody class="divide-y divide-gray-200">
        @forelse ($progressReports as $index => $report)
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
        {{ $report->percentage_complete }}%
    </td>

    <td class="px-6 py-4">
        {{ $report->status }}
    </td>
            
            <td class="px-6 py-4">
                <div class="max-w-xs">
                    <p class="text-sm text-gray-600 line-clamp-2">
                        {{ $report->notes ?? 'No notes available' }}
                    </p>
                </div>
            </td>
            
            <td class="px-6 py-4 text-center align-middle">
                <a href="{{ route('proposalsel.progress_review', $report->id) }}"
                    class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 text-xs bg-red-600 text-white rounded font-medium hover:bg-red-700 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Add Review</span>
                </a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center py-4 text-gray-500">
                Tidak ada progress report "In Progress"
            </td>
        </tr>
        @endforelse
    </tbody>
</table>