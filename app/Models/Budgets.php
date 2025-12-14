<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Proposal;

class Budgets extends Model
{
    use HasFactory; 
    protected $table = 'budgets';
    protected $fillable = [
        'proposal_id',
        'direct_personnel_cost',
        'non_personnel_cost',
        'indirect_cost',
        'document_rab',
        'status',
    ];
    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }

    /**
     * Accessor contoh untuk total cost (opsional)
     */
    public function getTotalCostAttribute()
    {
        return $this->direct_personnel_cost + $this->non_personnel_cost + $this->indirect_cost;
    }
}

