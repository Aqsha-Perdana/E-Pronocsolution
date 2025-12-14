<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalReview extends Model
{
    use HasFactory;

    protected $table = 'proposal_reviews';

    protected $fillable = [
        'proposal_id',
        'users_id',   // ⬅️ INI YANG KURANG
        'sections',
        'total_score'
    ];

    protected $casts = [
        'sections' => 'array',
        'total_score' => 'decimal:2'
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}