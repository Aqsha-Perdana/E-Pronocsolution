<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads; // Import trait untuk upload
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class Profile extends Component
{
    use WithFileUploads; // Gunakan trait ini

    // Data User (Akun Login)
    public $name, $email, $role;

    // Data Member (Profil Akademik)
    public $nip, $phone_number, $university, $functional_position, $bio;
    
    // Foto Profil
    public $photo; // Temporary file saat upload
    public $existingPhoto; // Path foto lama di database

    // Password
    public $current_password, $new_password, $new_password_confirmation;

    public function mount()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('researcher.login');
        }

        // 1. Data dari tabel users
        $this->name  = $user->name;
        $this->email = $user->email;
        $this->role  = $user->user_group;

        // 2. Data dari tabel members
        $member = $user->member; 
        
        if ($member) {
            $this->nip                 = $member->nip;
            $this->phone_number        = $member->phone_number;
            $this->university          = $member->university;
            $this->functional_position = $member->functional_position;
            $this->bio                 = $member->bio;
            $this->existingPhoto       = $member->profile_photo_path;
        }
    }

    public function updateProfile()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $this->validate([
            'name'                => 'required|string|max:255',
            'email'               => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            
            // Validasi data member
            'nip'                 => 'nullable|string|max:50',
            'phone_number'        => 'nullable|string|max:20',
            'university'          => 'nullable|string|max:255',
            'functional_position' => 'nullable|string|max:255',
            'bio'                 => 'nullable|string|max:1000',
            'photo'               => 'nullable|image|max:2048', // Max 2MB
        ]);

        // 1. Update Tabel Users (Hanya data akun)
        $user->update([
            'name'  => $this->name,
            'email' => $this->email,
        ]);

        // 2. Handle Foto Profil
        $photoPath = $this->existingPhoto; // Default pakai foto lama
        if ($this->photo) {
            // Hapus foto lama jika ada (opsional, untuk hemat storage)
            if ($this->existingPhoto && Storage::disk('public')->exists($this->existingPhoto)) {
                Storage::disk('public')->delete($this->existingPhoto);
            }
            // Simpan foto baru
            $photoPath = $this->photo->store('profile-photos', 'public');
        }

        // 3. Update Tabel Members (Semua data profil akademik)
        $user->member()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'nip'                 => $this->nip,
                'phone_number'        => $this->phone_number,
                'university'          => $this->university,
                'functional_position' => $this->functional_position,
                'bio'                 => $this->bio,
                'profile_photo_path'  => $photoPath,
            ]
        );

        // Update tampilan foto lama agar langsung berubah tanpa refresh
        $this->existingPhoto = $photoPath;
        $this->photo = null; // Reset input file

        session()->flash('message', 'Profil berhasil diperbarui.');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|min:8|confirmed',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        session()->flash('password_message', 'Password berhasil diubah.');
    }

    public function render()
    {
        return view('livewire.profile');
    }
}