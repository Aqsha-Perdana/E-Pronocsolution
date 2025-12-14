<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    // Pastikan fillable sesuai dengan kolom di database
    protected $fillable = [
        'user_id', 
        'nip', 
        'phone_number',
        'university',
        'department',       // Jika ada kolom ini
        'functional_position', 
        'bio',
        'profile_photo_path'
    ];

    // Relasi balik ke User (Satu Member dimiliki Satu User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}