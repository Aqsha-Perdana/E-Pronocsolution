<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'proposal_id', 'report_date', 'percentage_complete', 'status', 
        'activities', 'results', 'obstacles', 'next_steps', 'attachments', 'notes'
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
        
    // Relasi ke Final Report (Jika ingin mengecek dari sisi Progress)
    public function finalReport()
    {
        return $this->hasOne(FinalReport::class, 'proposal_id', 'proposal_id');
    }
}
