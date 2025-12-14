@php
    $page = $page ?? 'done';
    $proposals = \App\Models\Proposal::with('teamMembers')
        ->where('status', 'ACCEPTED')
        ->orderBy('updated_at', 'desc')
        ->get();
    
    // Hitung statistik
    $totalProposals = $proposals->count();
    $totalBudget = $proposals->sum('total_plan');
    $avgBudget = $totalProposals > 0 ? $totalBudget / $totalProposals : 0;
@endphp

<!-- Info Banner -->
<div class="mb-6 p-5 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-600 rounded-lg shadow-sm">
    <div class="flex items-start gap-4">
        <div class="flex-shrink-0">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
        </div>
        <div class="flex-1">
            <h3 class="text-lg font-semibold text-gray-800 mb-1">Proposal Review & Grading</h3>
            <p class="text-sm text-gray-600 leading-relaxed mb-3">
                Review dan berikan penilaian untuk proposal yang telah diterima. Setiap proposal dengan status <span class="font-semibold text-green-700">"ACCEPTED"</span> memerlukan penilaian dari reviewer.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div class="bg-white rounded-lg p-3 shadow-sm border border-green-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Proposals to Review</p>
                            <p class="text-2xl font-bold text-green-700">{{ $totalProposals }}</p>
                        </div>
                        <svg class="w-8 h-8 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <div class="bg-white rounded-lg p-3 shadow-sm border border-blue-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Total Budget</p>
                            <p class="text-lg font-bold text-blue-700">Rp {{ number_format($totalBudget / 1000000, 1) }}M</p>
                        </div>
                        <svg class="w-8 h-8 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <div class="bg-white rounded-lg p-3 shadow-sm border border-purple-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Avg Budget/Proposal</p>
                            <p class="text-lg font-bold text-purple-700">Rp {{ number_format($avgBudget / 1000000, 1) }}M</p>
                        </div>
                        <svg class="w-8 h-8 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<h2 class="text-2xl font-bold mb-4">Proposal Grading</h2>
<table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
    <thead>
        <tr class="bg-gray-100 border-b">
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">NO</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">PROPOSAL INFORMATION</th>
            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">ACTION</th>
        </tr>
    </thead>

    <tbody class="divide-y divide-gray-200">
        @forelse($proposals as $index => $proposal)
        <tr>
            <td class="px-6 py-4 text-gray-800 align-top">{{ $index + 1 }}</td>
            <td class="px-6 py-4 text-gray-800">
                <div class="space-y-1">
                    <div>
                        <span class="font-semibold">Code-REG</span> : {{ $proposal->registration_code ?? 'N/A' }}
                    </div>
                    <div>
                        <span class="font-semibold">Title</span> : {{ $proposal->title }}
                    </div>
                    <div>
                        <span class="font-semibold">Team</span> : 
                        @if($proposal->teamMembers && $proposal->teamMembers->count() > 0)
                        @php
                            $memberNames = $proposal->teamMembers
                                ->map(function($member) {
                                    return $member->name ?? 'N/A';
                                })
                                ->filter()
                                ->join(', ');
                        @endphp
                        {{ $memberNames ?: 'N/A' }}
                    @else
                        N/A
                    @endif
                    </div>
                    <div>
                        <span class="font-semibold">Budget Planning: </span>Rp. {{ number_format($proposal->total_plan, 0, ',', '.') }}
                    </div>

                </div>
            </td>
            <td class="px-6 py-4 text-center align-top">
                <div class="flex flex-col gap-1.5">
                    <button class="px-3 py-1.5 text-xs bg-gray-200 text-gray-900 rounded font-medium hover:bg-gray-300 transition flex items-center justify-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <span>Detail Report</span>
                    </button>
                    
                    <button onclick="window.location.href='{{ route('proposalsel.graded', $proposal->id) }}'" 
                        class="px-3 py-1.5 text-xs bg-red-600 text-white rounded font-medium hover:bg-red-700 transition flex items-center justify-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Add Review</span>
                    </button>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                Tidak ada proposal yang perlu direview
            </td>
        </tr>
        @endforelse
    </tbody>
</table>