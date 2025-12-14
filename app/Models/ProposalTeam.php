<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalTeam extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'proposal_teams';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'proposal_id',
        'member_id',
        'role',
        'email',
        // tambahkan kolom lain sesuai struktur tabel Anda
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the proposal that owns the team member.
     */
    public function proposal()
    {
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }

    public function member()
    {
        return $this->belongsTo(Members::class, 'member_id');
    }
}
