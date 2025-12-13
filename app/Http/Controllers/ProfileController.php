<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Profile extends Controller
{
    public function index()
{
    // Ambil user yang sedang login beserta data member-nya
    $user = Auth::user()->load('member');
    
    return view('profile.show', compact('user'));
}

public function update(Request $request)
{
    $user = Auth::user();
    
    // Update data dasar (User table)
    $user->update([
        'name' => $request->name,
        'email' => $request->email
    ]);

    // Update atau Buat data profil (Member table)
    // updateOrCreate akan mengecek apakah user_id sudah ada di table members
    $user->member()->updateOrCreate(
        ['user_id' => $user->id],
        [
            'nip' => $request->nip,
            'department' => $request->department,
            'functional_position' => $request->functional_position,
            'phone_number' => $request->phone_number,
        ]
    );

    return back()->with('success', 'Profile updated!');
}
}
