<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class LoginController extends Controller
{
    // ==========================================================
    // BAGIAN ADMIN
    // ==========================================================

    // Tampilkan form login admin
    public function showAdminLogin()
    {
        return view('admin.login');
    }

    // Proses login admin
    public function showResearcherLogin()
    {
        return view('researcher.login');
    }


    // Proses login researcher
    public function loginAdmin(Request $request){
    Session::flash('email', $request->email);

    $request->validate([
        'email' => 'required',
        'password' => 'required'
    ], [
        'email.required' => 'Email wajib diisi',
        'password.required' => 'Password wajib diisi'
    ]);

    $credentials = [
        'email' => $request->email,
        'password' => $request->password
    ];

    // Coba login
    if (Auth::attempt($credentials)) {

        // Cek apakah user adalah admin
        if (Auth::user()->user_group === 'admin') {
            return redirect('dashboard-admin')->with('success', 'Berhasil login sebagai Admin');
        }

        // Jika bukan admin → logout dan tolak
        Auth::logout();
        return redirect('admin')->withErrors('Anda tidak memiliki akses sebagai Admin.');
    }

    return redirect('admin')->withErrors('Email atau password salah.');
    }
    public function logoutAdmin(){
        Auth::logout();
        return redirect('admin')->with('success','Berhasil Logout') ;
    }
    public function loginResearcher(Request $request)
    {
        // 1. Validasi Input
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ], [
            'email.required'    => 'Email wajib diisi',
            'password.required' => 'Password wajib diisi'
        ]);

        // 2. Coba Login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // 3. Cek user_group khusus Peneliti
            if (Auth::user()->user_group === 'peneliti') {
                return redirect()->intended('dashboard')->with('success', 'Login berhasil!');
            }

            // Jika bukan peneliti
            Auth::logout();
            return back()->withErrors(['email' => 'Akun Anda tidak terdaftar sebagai Peneliti.']);
        }

        // 4. Gagal Login
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    // Tampilkan form register
    public function register()
    {
        return view('researcher.register');
    }

    // Proses register researcher baru
    public function create(Request $request)
    {
        // 1. Validasi Input Register
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:6',
            // Field opsional
            'notelp'    => 'nullable|string|max:20',
            'institution' => 'nullable|string|max:255',
        ], [
            'name.required'     => 'Nama wajib diisi',
            'email.unique'      => 'Email sudah terdaftar',
            'password.min'      => 'Password minimal 6 karakter'
        ]);

        // 2. Simpan ke Database
        $user = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'user_group'  => 'peneliti',
            // Gunakan operator null coalescing (??) dengan string kosong atau dash
            'notelp'      => $request->notelp ?? '-', 
            'institution' => $request->institution ?? '-',
            'photo'       => null, // Photo biasanya boleh null di codingan, pastikan di DB juga null atau string kosong
        ]);

        // 3. Auto Login setelah register
        Auth::login($user);

        // 4. Redirect ke Dashboard
        return redirect('dashboard')->with('success', 'Registrasi berhasil! Selamat datang ' . $user->name);
    }

    // ==========================================================
    // LOGOUT (UMUM)
    // ==========================================================
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect default setelah logout (bisa ke login researcher atau home)
        return redirect('/')->with('success', 'Berhasil logout.');
    }

}