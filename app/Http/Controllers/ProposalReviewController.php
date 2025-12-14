<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProposalReview;   // <- WAJIB
use Illuminate\Support\Facades\Auth; 
use App\Models\ProgressReport;
use App\Models\FinalReport;
use App\Models\Proposal;

class ProposalReviewController extends Controller
{
    public function store(Request $request, $proposalId)
    {
        
        $request->validate([
            'sections' => 'required|array',
            'sections.*.name' => 'required|string',
            'sections.*.score' => 'required|numeric|min:1|max:10',
            'sections.*.notes' => 'nullable|string',
        ]);

        // Hitung total skor
        $scores = collect($request->sections)->pluck('score');
        $total = $scores->avg();

        // Update atau create
        $review = ProposalReview::updateOrCreate(
            [
                'proposal_id' => $proposalId,
                'user_id' => Auth::id(),
            ],
            [
                'sections' => $request->sections,
                'total_score' => $total,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Review saved successfully.',
            'total_score' => $total,
            'sections' => $review->sections,
        ]);
    }

    public function getReview($proposalId)
    {
        $review = ProposalReview::where('proposal_id', $proposalId)
            ->where('user_id', Auth::id())
            ->first();

        return response()->json([
            'success' => true,
            'review' => $review,
        ]);
    }
    public function submitReview(Request $request, $id)
{
    // proses simpan review...

    return redirect('/proposalsel/list')->with('success', 'Review submitted!');
}

public function reviewPage()
{
    $reports = ProgressReport::whereNull('status')
                ->orderBy('report_date', 'desc')
                ->get();

    return view('admin.review-progress', compact('reports'));
}

public function updateNotes(Request $request, $id)
{
    $request->validate([
        'admin_notes' => 'nullable|string'
    ]);

    $report = ProgressReport::findOrFail($id);
    
    // Update admin notes dan review status
    $report->admin_notes = $request->admin_notes;
    $report->review_status = ProgressReport::REVIEW_REVIEWED;
    
    // Status peneliti tetap tidak berubah (IN_PROGRESS atau COMPLETED)
    
    $report->save();

    // Redirect ke halaman progress list setelah submit
    return redirect()->route('proposalsel.progress')
        ->with('success', 'Progress report berhasil direview!');
}

public function approve($id)
{
    $report = ProgressReport::findOrFail($id);
    $report->status = 'approved';
    $report->save();

    return back()->with('success', 'Progress report approved!');
}

public function reject($id)
{
    $report = ProgressReport::findOrFail($id);
    $report->status = 'rejected';
    $report->save();

    return back()->with('success', 'Progress report rejected.');
}

  public function create($progressReportId)
    {
        $progressReport = ProgressReport::with([
            'proposal.teamMembers',
            'proposal.owner'
        ])->findOrFail($progressReportId);

        $proposal = $progressReport->proposal;

        return view('proposalsel.progress_review', compact(
            'proposal',
            'progressReport'
        ));
    }   
    public function action($id, $action)
{
    $progressReport = ProgressReport::findOrFail($id);

    switch ($action) {
        case 'ok':
            $progressReport->update([
                'admin_notes' => 'Disetujui admin',
            ]);
            break;

        case 'cancel':
            $progressReport->update([
                'status' => 'Cancelled',
            ]);
            break;

        case 'complete':
            $progressReport->update([
                'status' => 'Complete',
                'completed_at' => now(),
            ]);
            break;
    }

    return back()->with('success', 'Aksi berhasil diproses.');
}
public function complete(Request $request, $id)
{
    try {
        $progressReport = ProgressReport::findOrFail($id);
        
        // Update status atau logic yang diperlukan
        $progressReport->status = 'COMPLETE';
        $progressReport->save();
        
        // Return JSON untuk AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Progress report berhasil diselesaikan!'
            ]);
        }
        
        // Fallback untuk non-AJAX
        return redirect()->route('proposalsel.progress')
            ->with('success', 'Progress report berhasil diselesaikan!');
            
    } catch (\Exception $e) {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyelesaikan progress report'
            ], 500);
        }
        
        return back()->with('error', 'Terjadi kesalahan');
    }
}
public function updateStatus($id, $action)
{
    $report = ProgressReport::findOrFail($id);

    if ($action === 'complete') {
        if ($report->percentage_complete < 100) {
            return back()->with('error', 'Progress belum 100%');
        }

        $report->update([
            'status' => 'Complete'
        ]);
    }

    return back()->with('success', 'Progress berhasil diselesaikan');
}

public function finalReview($id)
{
    $finalReport = \App\Models\FinalReport::with([
        'proposal.teamMembers',
        'proposal.budget'
    ])->findOrFail($id);

    $proposal = $finalReport->proposal;

    $budgetPlanning = 0;
    $budgetRealization = 0;

    if ($proposal->budget) {
        $budgetPlanning =
            ($proposal->budget->direct_personnel_cost_proposal ?? 0) +
            ($proposal->budget->non_personnel_cost_proposal ?? 0) +
            ($proposal->budget->indirect_cost_proposal ?? 0);

        $budgetRealization =
            ($proposal->budget->direct_personnel_cost_fundrealization ?? 0) +
            ($proposal->budget->non_personnel_cost_fundrealization ?? 0) +
            ($proposal->budget->indirect_cost_fundrealization ?? 0);

        $remainingFund = $budgetPlanning - $budgetRealization;
    }

    $remainingFund = $budgetPlanning - $budgetRealization;

    return view('proposalsel.finalreview', compact(
        'finalReport',
        'proposal',
        'budgetPlanning',
        'budgetRealization',
        'remainingFund'
    ));
}


// Function untuk submit review final report
public function finalReviewSubmit(Request $request, $id)
{
    $request->validate([
        'review_notes' => 'required|string',
        'rating' => 'required|integer|min:1|max:5',
        'status' => 'required|in:Approved,Rejected'
    ]);
    
    try {
        $finalReport = \App\Models\FinalReport::findOrFail($id);
        
        // Update final report dengan review
        $finalReport->review_notes = $request->review_notes;
        $finalReport->rating = $request->rating;
        $finalReport->status = $request->status;
        $finalReport->reviewed_at = now();
        $finalReport->reviewed_by = auth()->id();
        $finalReport->save();
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Review berhasil disimpan!'
            ]);
        }
        
        return redirect()
            ->route('proposalsel.final')
            ->with('success', 'Review final report berhasil disimpan!');
            
    } catch (\Exception $e) {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
        
        return redirect()
            ->back()
            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

public function finishFinalReport($id)
{
    \Log::info('Finishing final report', ['id' => $id]);
    
    $finalReport = \App\Models\FinalReport::findOrFail($id);
    
    \Log::info('Before update', ['status' => $finalReport->status]);
    
    $finalReport->update([
        'status' => 'FINISHED'
    ]);
    
    \Log::info('After update', ['status' => $finalReport->fresh()->status]);

    return response()->json([
        'success' => true,
        'message' => 'Final Report finished'
    ]);
}

}
