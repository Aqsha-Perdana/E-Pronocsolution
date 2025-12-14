<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('proposal') }}
        </h2>
    </x-slot>
</x-app-layout>
@php
$finalReports = \DB::table('final_reports')
        ->join('proposals', 'final_reports.proposal_id', '=', 'proposals.id')
        ->join('progress_reports', 'progress_reports.proposal_id', '=', 'proposals.id')
        ->where('progress_reports.status', 'Complete')
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

<div class="py-24">
    <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8 min-h-[700px]">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg p-6">
            <div class="grid grid-cols-12 gap-6">

                <!-- ================= SIDEBAR KIRI ================= -->
                <div class="col-span-3 bg-gradient-to-br from-red-600 to-red-700 p-6 rounded-xl shadow-xl">
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">

                        <h1 class="text-xl font-bold text-gray-800 mb-6 pb-3 border-b-2 border-red-500">
                            Proposal Information
                        </h1>

                        <!-- Code Reg -->
                        <div class="mb-4 bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs font-medium text-gray-500 uppercase mb-1">Code Reg</p>
                            <p class="font-semibold text-gray-800 break-all">
                                {{ strip_tags($proposal->registration_code) }}
                            </p>
                        </div>

                        <!-- Title -->
                        <div class="mb-4 bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs font-medium text-gray-500 uppercase mb-1">Title</p>
                            <p class="font-semibold text-gray-800 break-words">
                                {{ strip_tags($proposal->title) }}
                            </p>
                        </div>

                        <!-- Team Members -->
                        <div class="mb-4 bg-gradient-to-r from-red-50 to-orange-50 p-4 rounded-lg border-l-4 border-red-500">
                            <p class="text-xs font-medium text-red-700 uppercase mb-3">Team Members</p>
                            <p class="text-sm font-medium text-gray-800 break-words">
                                @if($proposal->teamMembers && $proposal->teamMembers->count() > 0)
                                    {{ $proposal->teamMembers->pluck('name')->join(', ') }}
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>

                        <!-- Date Submitted -->
                        @if($finalReport->date)
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs font-medium text-gray-500 uppercase mb-1">
                                Date Submitted
                            </p>
                            <p class="font-semibold text-gray-800">
                                {{ \Carbon\Carbon::parse($finalReport->date)->format('d F Y') }}
                            </p>
                        </div>
                        @endif

                    </div>
                </div>

                <!-- ================= KONTEN UTAMA ================= -->
                <div class="col-span-9 bg-white p-8 rounded-2xl shadow-sm min-h-[500px] overflow-x-hidden">

                    <h2 class="text-4xl font-bold text-gray-800 mb-6">
                        Review Final Report
                    </h2>

                    <!-- ================= BUDGET COMPARISON ================= -->
                    @if(isset($budgetPlanning, $budgetRealization, $remainingFund))
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

    <!-- Budget Planning -->
    <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-5 rounded-xl border-l-4 border-blue-500 shadow-sm">
        <p class="text-xs font-medium text-blue-700 uppercase mb-1">
            Budget Planning
        </p>
        <p class="text-2xl font-bold text-gray-800">
            Rp {{ number_format($budgetPlanning, 0, ',', '.') }}
        </p>
    </div>
    

    <!-- Budget Realization -->
    <div class="bg-gradient-to-r from-green-50 to-green-100 p-5 rounded-xl border-l-4 border-green-500 shadow-sm">
        <p class="text-xs font-medium text-green-700 uppercase mb-1">
            Budget Realization
        </p>
        <p class="text-2xl font-bold text-gray-800">
            Rp {{ number_format($budgetRealization, 0, ',', '.') }}
        </p>
    </div>

    <!-- Remaining Fund -->
    <div class="bg-gradient-to-r from-yellow-50 to-orange-100 p-5 rounded-xl border-l-4 border-yellow-500 shadow-sm">
        <p class="text-xs font-medium text-yellow-700 uppercase mb-1">
            Remaining Fund
        </p>
        <p class="text-2xl font-bold text-gray-800">
            Rp {{ number_format($remainingFund, 0, ',', '.') }}
        </p>

        @if($remainingFund < 0)
            <p class="text-xs text-red-600 font-semibold mt-1">
                ⚠ Over Budget
            </p>
        @else
            <p class="text-xs text-green-600 font-semibold mt-1">
                Budget Safe
            </p>
        @endif
    </div>

</div>
@endif

                    <!-- ================= FINAL REPORT ================= -->
                    <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-md">

                        <x-report-section title="Abstract" color="blue" :content="$finalReport->abstract" />
                        <x-report-section title="Introduction" color="purple" :content="$finalReport->introduction" />
                        <x-report-section title="Project Method" color="green" :content="$finalReport->project_method" />
                        <x-report-section title="Results" color="yellow" :content="$finalReport->results" />
                        <x-report-section title="Note" color="gray" :content="$finalReport->note" />
                        <x-report-section title="Bibliography" color="purple" :content="$finalReport->bibliography" />

                    </div>
                    <div class="mt-8 flex items-center justify-end gap-4">

                        <!-- OK Button -->
                        <a href="{{ route('proposalsel.list') }}"
       class="px-5 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 font-semibold">
        ← Back
    </a>

    <!-- FINISHED -->
    <button onclick="finishFinalReport()"
        class="px-6 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white font-semibold">
        ✓ Finished
    </button>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function finishFinalReport() {
    Swal.fire({
        title: 'Finish Final Report?',
        text: 'Status akan diubah menjadi FINISHED',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#16a34a',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Finish!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch("{{ route('proposalsel.final.finish', $finalReport->id) }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(() => {
                Swal.fire(
                    'Finished!',
                    'Final Report berhasil diselesaikan.',
                    'success'
                ).then(() => {
                    window.location.href = "{{ route('proposalsel.list') }}";
                });
            });
        }
    });
}
</script>