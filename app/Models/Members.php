<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    use HasFactory;

    protected $table = 'members';

    protected $fillable = [
        'nip',
        'name',
        'email',
        'role',
        // kolom lainnya
    ];

    /**
     * Get the proposal teams for the member.
     */
    public function proposalTeams()
    {
        return $this->hasMany(ProposalTeam::class, 'member_id');
    }
}