<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinalReportController extends Controller
{
    public function index()
    {
        // Gunakan Eloquent dengan eager loading
        $progressReports = ProgressReport::with([
                'proposal.teamMembers.user', // Load team members
                'proposal.budget'             // Load budget
            ])
            ->where('status', 'Complete')
            ->whereHas('proposal') // Pastikan ada proposal
            ->get();

        // Transform data untuk menambahkan calculated fields
        $progressReports = $progressReports->map(function($report) {
            $budget = $report->proposal->budget;
            
            // Hitung total plan
            $totalPlan = $budget ? 
                ($budget->direct_personnel_cost_proposal ?? 0) + 
                ($budget->non_personnel_cost_proposal ?? 0) + 
                ($budget->indirect_cost_proposal ?? 0) : 0;
            
            // Hitung total realization
            $totalRealization = $budget ? 
                ($budget->direct_personnel_cost_fundrealization ?? 0) + 
                ($budget->non_personnel_cost_fundrealization ?? 0) + 
                ($budget->indirect_cost_fundrealization ?? 0) : 0;
            
            // Tambahkan calculated fields
            $report->total_plan = $totalPlan;
            $report->total_realization = $totalRealization;
            $report->remaining_budget = $totalPlan - $totalRealization;
            $report->budget_usage_percentage = $totalPlan > 0 ? 
                round(($totalRealization / $totalPlan) * 100, 2) : 0;
            
            // Team members sebagai string
            $report->team_members = $report->proposal->teamMembers
                ->pluck('user.name')
                ->filter()
                ->join(', ');
            
            return $report;
        });

        return view('progress-reports.index', compact('progressReports'));
    }
}
