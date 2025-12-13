<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;

    protected $table = 'team_members'; // Sesuaikan nama tabel

    // Wajib ada agar fungsi create() di controller berjalan
    protected $fillable = [
        'nip',
        'name',
        'email',
    ];
}