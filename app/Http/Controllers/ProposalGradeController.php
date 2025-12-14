<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use App\Models\FinalReport;
use Illuminate\Http\Request;

class ProposalGradeController extends Controller
{
    public function show($id)
    {
        try {
            // Cari proposal berdasarkan ID
            // dd("Controller berhasil dipanggil! ID: " . $id);
            $proposal = Proposal::with(['teams.member', 'budgets', 'finalReport'])
                ->findOrFail($id);
            
            // Debug: uncomment untuk testing
            // dd($proposal);
            // dd($proposal);
            return view('proposalsel.finalgrading', compact('proposal'));
            
        } catch (\Exception $e) {
            // Log error
            \Log::error('Error loading final grade page: ' . $e->getMessage());
            
            return redirect()->route('proposalsel.final')
                ->with('error', 'Proposal tidak ditemukan');
        }
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'final_grade' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        try {
            $proposal = Proposal::findOrFail($id);
            
            $proposal->update([
                'final_grade' => $request->final_grade,
                'feedback' => $request->feedback,
                'status' => 'GRADED',
            ]);

            return redirect()->route('proposalsel.final')
                ->with('success', 'Final grade berhasil ditambahkan!');
                
        } catch (\Exception $e) {
            \Log::error('Error storing final grade: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Gagal menyimpan final grade');
        }
    }
    public function gradeFinalReport(Request $request, $id)
{
    $validated = $request->validate([
        'score_abstract' => 'required|integer|min:0|max:100',
        'score_introduction' => 'required|integer|min:0|max:100',
        'score_method' => 'required|integer|min:0|max:100',
        'score_results' => 'required|integer|min:0|max:100',
        'score_bibliography' => 'required|integer|min:0|max:100',
        'score_statement' => 'required|integer|min:0|max:100',
        'note' => 'nullable|string',
    ]);

    $proposal = Proposal::findOrFail($id);

    // Simpan ke tabel final report atau tabel grade
    FinalReportGrade::updateOrCreate(
        ['proposal_id' => $proposal->id],
        $validated
    );

    return back()->with('success', 'Nilai final report berhasil disimpan.');
}
public function reviewFinalReport(Request $request, $id)
{
    $request->validate([
        'notes' => 'required|string'
    ]);

    $proposal = Proposal::findOrFail($id);

    // Simpan catatan penilaian ke final report
    $proposal->finalReport->update([
        'note' => $request->notes
    ]);

    return back()->with('success', 'Catatan penilaian berhasil disimpan.');
}
public function grade(Request $request, $id)
{
    $request->validate([
        'admin_notes' => 'nullable|string'
    ]);

    // Ambil final report berdasarkan proposal_id
    $report = FinalReport::where('proposal_id', $id)->firstOrFail();

    // Simpan catatan admin ke final_reports
    $report->admin_notes = $request->admin_notes;
    $report->save();

    // Ambil proposal
    $proposal = Proposal::findOrFail($id);

    // Update status proposal menjadi DONE
    $proposal->status = 'DONE';
    $proposal->save();

    return redirect()->route('proposalsel.final')
                     ->with('success', 'Penilaian berhasil disimpan!');
}


}