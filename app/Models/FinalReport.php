<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'proposal_id', 'title', 'date', 'focus_area', 'focus', 
        'abstract', 'introduction', 'project_method', 
        'results', 'note', 'bibliography', 'statement_letter', 'status'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // 1. Relasi ke Induk (Proposal)
    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }

    // 2. Relasi "Has One Through" ke Progress Report (Opsional tapi berguna)
    // Memudahkan akses: $finalReport->progressReport
    public function progressReport()
    {
        return $this->hasOneThrough(
            ProgressReport::class,
            Proposal::class,
            'id', // Foreign key di tabel proposals (id)
            'proposal_id', // Foreign key di tabel progress_reports
            'proposal_id', // Local key di tabel final_reports
            'id' // Local key di tabel proposals
        );
    }

    // 3. Relasi "Has One Through" ke Fund Realization (Budget)
    // Memudahkan akses: $finalReport->fundRealization
    public function fundRealization()
    {
        return $this->hasOneThrough(
            Budget::class, // Asumsi model Budget adalah Fund Realization
            Proposal::class,
            'id', 
            'proposal_id', 
            'proposal_id', 
            'id'
        );
    }
}
