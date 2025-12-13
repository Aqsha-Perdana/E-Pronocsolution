<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model {
    protected $guarded = ['id'];

    public function proposal() {
        return $this->belongsTo(Proposal::class); 
    }

    // Hitung Total Rencana Anggaran (Proposal)
    public function getTotalPlanAttribute()
    {
        return $this->direct_personnel_cost_proposal 
             + $this->non_personnel_cost_proposal 
             + $this->indirect_cost_proposal;
    }

    // Hitung Total Realisasi (Yang sudah terpakai)
    public function getTotalRealizationAttribute()
    {
        return $this->direct_personnel_cost_fundrealization 
             + $this->non_personnel_cost_fundrealization 
             + $this->indirect_cost_fundrealization;
    }

// Tambahkan ini di dalam class Budget
    public function getStatusColorClassAttribute()
    {
        return match(strtolower($this->status ?? 'draft')) {
            'active' => 'text-orange-500 font-bold',
            'done' => 'text-green-500 font-bold',
            'submitted', 'submited' => 'text-gray-900 font-bold',
            default => 'text-gray-400',
        };
    }

    // Hitung Sisa Dana
    public function getRemainingFundAttribute()
    {
        return $this->total_plan - $this->total_realization;
    }
}
