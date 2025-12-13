<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Budget;
use Illuminate\Support\Facades\Auth; // Don't forget to import Auth!

class FundRealizationReport extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $search = '';

    // Reset pagination when search changes
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $userId = Auth::id(); // Get current user ID

        $budgets = Budget::with('proposal')
            // 1. FILTER BY USER (OWNERSHIP)
            ->whereHas('proposal.teamMembers', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            // 2. SEARCH FILTER
            ->whereHas('proposal', function($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            // 3. STATUS LOGIC
            ->where(function($query) {
                // Show if Budget status is 'Done' OR Proposal is 'Approved'
                $query->where('status', 'Done')
                      ->orWhereHas('proposal', function($q) {
                          $q->where('status', 'Approved'); 
                      });
            })
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.fund-realization-report', [
            'budgets' => $budgets
        ]);
    }
}