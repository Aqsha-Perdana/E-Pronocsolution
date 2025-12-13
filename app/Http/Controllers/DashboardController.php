<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgressReport;
use App\Models\FinalReport;
use App\Models\Proposal;
use App\Models\Budget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // ... (Keep existing index, progress, editProgress methods) ...
    // Note: I will include them briefly for context, but the main fix is in updateProgress

    public function index()
    {
        $userId = Auth::id(); 
        $user = Auth::user();
        $showProfileAlert = false;

        if (!$user->member) {
            $showProfileAlert = true;
        } elseif (empty($user->member->nip) || empty($user->member->phone_number)) {
            $showProfileAlert = true;
        }

        $totalProposals = Proposal::whereHas('teamMembers', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->count(); 

        $activeProposals = Proposal::whereHas('teamMembers', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->whereIn('status', ['SUBMITTED', 'APPROVED'])->count();

        $danaCair = Proposal::where('status', 'APPROVED')
            ->whereHas('teamMembers', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->with('budget')
            ->get()
            ->sum(function($proposal) {
                if (!$proposal->budget) return 0;
                return ($proposal->budget->direct_personnel_cost_proposal ?? 0) +
                       ($proposal->budget->non_personnel_cost_proposal ?? 0) +
                       ($proposal->budget->indirect_cost_proposal ?? 0);
            });

        $totalRealization = Proposal::where('status', 'APPROVED')
            ->whereHas('teamMembers', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->with('budget')
            ->get()
            ->sum(function($proposal) {
                if (!$proposal->budget) return 0;
                return ($proposal->budget->direct_personnel_cost_fundrealization ?? 0) +
                       ($proposal->budget->non_personnel_cost_fundrealization ?? 0) +
                       ($proposal->budget->indirect_cost_fundrealization ?? 0);
            });

        $totalGrant = 1000000000; 
        $hasApprovedProposal = Proposal::where('status', 'APPROVED')
            ->whereHas('teamMembers', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })->exists();

        $sisaDana = $hasApprovedProposal ? ($danaCair - $totalRealization) : 0;
        // Wait, logic correction based on previous prompt:
        // Sisa Pagu = (Total Allocation) - (Total Spent). 
        // If Dana Cair is allocation, then Sisa = Dana Cair - Total Realization.
        // If Total Grant is the global ceiling, then Sisa = Total Grant - Dana Cair (Allocated).
        // Let's stick to the prompt's specific logic: 
        // Sisa Pagu = Total Realization - Total Proposal Cost (which is negative if under budget?)
        // Actually, usually: Remaining = Budget - Realization.
        $sisaDana = $danaCair - $totalRealization; 


        $monthlyProposals = Proposal::select(
                DB::raw('COUNT(id) as count'), 
                DB::raw('MONTH(date) as month')
            )
            ->whereHas('teamMembers', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->whereYear('date', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $monthlyProposals[$i] ?? 0;
        }
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        $recentProposals = Proposal::whereHas('teamMembers', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.dashboard', compact(
            'totalProposals', 
            'activeProposals', 
            'danaCair', 
            'sisaDana', 
            'chartData', 
            'months',
            'recentProposals',
            'showProfileAlert'
        ));
    }

    public function progress()
    {
        $userId = Auth::id();
        $approvedProposals = Proposal::where('status', 'APPROVED')
            ->whereHas('teamMembers', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->with('progressReport')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('progressreport.progress', compact('approvedProposals'));
    }

    public function editProgress($id)
    {
        $proposal = Proposal::findOrFail($id);
        $report = $proposal->progressReport ?? new ProgressReport();
        return view('progressreport.progress-create', compact('proposal', 'report'));
    }

    // --- FIX: updateProgress Method ---
    public function updateProgress(Request $request, $id)
    {
        // 1. Basic Input Validation
        $request->validate([
            'percentage' => 'required|integer|min:0|max:100',
            'status'     => 'required|string',
        ]);

        $status = $request->input('status');
        
        // 2. Define Conditional Validation Rules
        $rules = [
            'notes'       => 'nullable|string',
            'activities'  => 'nullable|string',
            'results'     => 'nullable|string',
            'obstacles'   => 'nullable|string',
            'next_steps'  => 'nullable|string',
            'attachments' => 'nullable|string', 
        ];

        // If Status is 'Complete' OR Percentage is 100, make fields REQUIRED
        // Note: Ensure the value "Complete" matches exactly what is sent from the form/select option
        if ($status === 'Complete' || $request->input('percentage') == 100) {
            $rules['activities']  = 'required|string|min:10';
            $rules['results']     = 'required|string|min:10';
            $rules['obstacles']   = 'required|string';
            $rules['next_steps']  = 'required|string';
            $rules['attachments'] = 'required|string'; 
        }

        $data = $request->validate($rules);

        $proposal = Proposal::findOrFail($id);

        // 3. Save to Database
        // Columns here MUST match the database table 'progress_reports' shown in your image
        ProgressReport::updateOrCreate(
            ['proposal_id' => $proposal->id],
            [
                'report_date'         => now()->toDateString(),
                'percentage_complete' => $request->input('percentage'),
                'status'              => $status,
                // Optional fields mapped from validated data
                'notes'               => $data['notes'] ?? null,
                'activities'          => $data['activities'] ?? null,
                'results'             => $data['results'] ?? null,
                'obstacles'           => $data['obstacles'] ?? null,
                'next_steps'          => $data['next_steps'] ?? null,
                'attachments'         => $data['attachments'] ?? null,
            ]
        );

        return redirect()->route('progress.index')->with('success', 'Progress updated successfully!');
    }

    // ... (Keep existing methods: showPdf, downloadPdf, destroy, final, editFinal, storeFinal, etc.) ...
    
    public function showPdf($id)
    {
        $report = ProgressReport::with('proposal')->findOrFail($id);
        $pdf = Pdf::loadView('reports.progress-report-pdf', compact('report'));
        $pdfBase64 = base64_encode($pdf->output());
        return view('progressreport.progress-success', compact('report', 'pdfBase64'));
    }
    
    public function downloadPdf($id)
    {
        $report = ProgressReport::with('proposal')->findOrFail($id);
        $pdf = Pdf::loadView('reports.progress-report-pdf', compact('report'));
        return $pdf->download('Progress_Report_' . $report->proposal->title . '.pdf');
    }

    public function destroy($id)
    {
        $report = ProgressReport::findOrFail($id);
        $report->delete();
        return redirect('/progress')->with('success', 'Progress report deleted.');
    }

    public function final(Request $request)
    {
        $userId = Auth::id();
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10); 

        $query = Proposal::where('status', 'APPROVED')
            ->whereHas('teamMembers', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->with(['progressReport', 'fundRealization', 'finalReport']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('registration_code', 'like', "%{$search}%");
            });
        }

        $approvedProposals = $query->orderBy('updated_at', 'desc')->paginate($perPage);
        return view('finalreport.final-report', compact('approvedProposals'));
    }

    public function editFinal($id)
    {
        $proposal = Proposal::findOrFail($id);
        $progress = $proposal->progressReport;
        $fund     = $proposal->fundRealization;

        $isProgressComplete = $progress && strtolower($progress->status) === 'complete';
        $isFundDone         = $fund && strtolower($fund->status) === 'done';

        if (!$isProgressComplete || !$isFundDone) {
            return redirect()->route('final')
                ->with('error', 'Syarat belum terpenuhi: Progress Report harus COMPLETE dan Fund Realization harus DONE.');
        }

        $finalReport = $proposal->finalReport ?? new FinalReport();
        return view('finalreport.final-create', compact('proposal', 'finalReport'));
    }
    
    public function storeFinal(Request $request)
    {
        $data = $request->validate([
            'proposal_id'      => 'required|exists:proposals,id',
            'abstract'         => 'required|string|min:50',
            'introduction'     => 'required|string|min:50',
            'method'           => 'required|string|min:50',
            'results'          => 'required|string|min:50',
            'bibliography'     => 'required|string',
            'statement_letter' => 'nullable|string',
            'note'             => 'nullable|string',
        ]);

        $proposal = Proposal::findOrFail($data['proposal_id']);

        $final = FinalReport::updateOrCreate(
            ['proposal_id' => $proposal->id],
            [
                'date'             => now()->toDateString(),
                'title'            => $proposal->title,
                'focus_area'       => $proposal->focus_area, 
                'focus'            => $proposal->output,
                'abstract'         => $data['abstract'],
                'introduction'     => $data['introduction'],
                'project_method'   => $data['method'],
                'results'          => $data['results'],
                'bibliography'     => $data['bibliography'],
                'statement_letter' => $data['statement_letter'] ?? null,
                'note'             => $data['note'] ?? null,
                'status'           => 'Submitted'
            ]
        );

        return redirect()->route('final')->with('success', 'Final Report berhasil disimpan!');
    }

    public function showFinal($id)
    {
        $final = FinalReport::with('proposal')->findOrFail($id);
        $pdf = Pdf::loadView('reports.final-report-pdf', compact('final'));
        $pdfBase64 = base64_encode($pdf->output());
        return view('finalreport.final-success', compact('final', 'pdfBase64'));
    }

    public function destroyFinal($id)
    {
        $final = FinalReport::findOrFail($id);
        $final->delete();
        return redirect('/final')->with('success', 'Final report deleted.');
    }

    public function downloadFinal($id)
    {
        $final = FinalReport::with('proposal')->findOrFail($id);
        $pdf = Pdf::loadView('reports.final-report-pdf', compact('final'));
        return $pdf->download('Final_Report_' . ($final->proposal->title ?? $final->title) . '.pdf');
    }
}