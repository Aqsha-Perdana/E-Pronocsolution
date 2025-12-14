<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Budget;
use Illuminate\Support\Facades\Auth;

class FundRealizationReportShow extends Component
{
    public $budget;

    public function mount($id)
    {
        $userId = Auth::id();

        $this->budget = Budget::with('proposal')
            ->whereHas('proposal.teamMembers', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.fund-realization-report-show');
    }


}