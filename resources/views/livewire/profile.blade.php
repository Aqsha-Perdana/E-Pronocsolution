<x-slot name="title">Profile</x-slot>
<div class="min-h-screen bg-gray-50/50 pb-12">
    
    {{-- Header Banner Background: Diubah dari h-64 menjadi h-56 (224px) --}}
    <div class="h-56 bg-gradient-to-r from-red-700 via-red-600 to-red-800 w-full absolute top-0 left-0 z-0">
        <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 20px 20px;"></div>
    </div>

    {{-- KONTEN UTAMA: pt-16 (64px) untuk mengangkat teks agar berada di tengah background yang kini lebih kecil --}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10 pt-16 space-y-8"> 
        
        {{-- Page Header --}}
        {{-- Hapus mb-8 agar konten di bawah (Form/Card) naik --}}
        <div class="md:flex md:items-end md:justify-between px-4 sm:px-0">
            <div class="flex-1 min-w-0">
                <h2 class="text-3xl font-extrabold text-white tracking-tight sm:text-4xl drop-shadow-md"> 
                    Profil Saya
                </h2>
                <p class="mt-2 text-white text-base font-medium drop-shadow-sm">Kelola informasi profil, data akademik, dan keamanan akun Anda di sini.</p> 
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 px-4 sm:px-0">
            
            {{-- KOLOM KIRI: Form Edit Profil & Password (lg:col-span-2) --}}
            <div class="lg:col-span-2 space-y-8">
                
                {{-- 1. Card Data Diri (Informasi Pribadi) --}}
                <div class="bg-white shadow-xl shadow-gray-200/50 rounded-2xl overflow-hidden border border-gray-100">
                    
                    {{-- Card Header --}}
                    <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between bg-white">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-red-50 rounded-lg text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Informasi Pribadi</h3>
                                <p class="text-sm text-gray-500">Update foto dan detail data diri Anda.</p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Form Konten Data Diri --}}
                    <div class="p-8">
                        @if (session()->has('message'))
                            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 text-green-700 rounded-r-lg shadow-sm flex items-start gap-3">
                                <svg class="h-5 w-5 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <div>
                                    <p class="font-bold">Berhasil Disimpan!</p>
                                    <p class="text-sm">{{ session('message') }}</p>
                                </div>
                            </div>
                        @endif

                        <form wire:submit.prevent="updateProfile" class="space-y-8" enctype="multipart/form-data">
                            
                            {{-- FOTO PROFIL SECTION --}}
                            <div class="flex flex-col sm:flex-row items-center gap-6 p-6 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                                <div class="shrink-0 relative group">
                                    @if ($photo) 
                                        <img class="h-28 w-28 object-cover rounded-full ring-4 ring-white shadow-md" src="{{ $photo->temporaryUrl() }}" alt="New Photo">
                                    @elseif($existingPhoto)
                                        <img class="h-28 w-28 object-cover rounded-full ring-4 ring-white shadow-md" src="{{ asset('storage/' . $existingPhoto) }}" alt="Current Photo">
                                    @else
                                        <div class="h-28 w-28 rounded-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center text-gray-500 font-bold text-4xl ring-4 ring-white shadow-md">
                                            {{ substr($name, 0, 1) }}
                                        </div>
                                    @endif
                                    
                                    {{-- Loading Indicator --}}
                                    <div wire:loading wire:target="photo" class="absolute inset-0 bg-white/80 rounded-full flex items-center justify-center">
                                        <svg class="animate-spin h-8 w-8 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    </div>
                                </div>
                                <div class="flex-1 text-center sm:text-left">
                                    <label class="block mb-2 text-base font-semibold text-gray-900">Foto Profil</label>
                                    <div class="flex items-center justify-center sm:justify-start gap-3">
                                        <label for="photo-upload" class="cursor-pointer inline-flex items-center px-5 py-2.5 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                            Pilih Foto Baru
                                        </label>
                                        <input id="photo-upload" type="file" wire:model="photo" class="sr-only">
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">JPG, GIF atau PNG. Maksimal 2MB.</p>
                                    @error('photo') <p class="text-red-600 text-sm mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-8">
                                {{-- Nama --}}
                                <div class="md:col-span-2">
                                    <label class="block text-base font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                    <input wire:model="name" type="text" class="w-full px-4 py-3 rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 shadow-sm text-base transition duration-150 ease-in-out placeholder-gray-400" placeholder="Masukkan nama lengkap">
                                    @error('name') <span class="text-red-500 text-sm mt-1 font-medium">{{ $message }}</span> @enderror
                                </div>

                                {{-- Email --}}
                                <div class="md:col-span-2">
                                    <label class="block text-base font-semibold text-gray-700 mb-2">Alamat Email</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                        </div>
                                        <input wire:model="email" type="email" class="w-full pl-11 px-4 py-3 rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 shadow-sm text-base transition duration-150 ease-in-out placeholder-gray-400" placeholder="nama@email.com">
                                    </div>
                                    @error('email') <span class="text-red-500 text-sm mt-1 font-medium">{{ $message }}</span> @enderror
                                </div>

                                {{-- NIP --}}
                                <div>
                                    <label class="block text-base font-semibold text-gray-700 mb-2">NIP / ID Anggota</label>
                                    <input wire:model="nip" type="text" class="w-full px-4 py-3 rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 shadow-sm text-base">
                                    @error('nip') <span class="text-red-500 text-sm mt-1 font-medium">{{ $message }}</span> @enderror
                                </div>

                                {{-- No Telp --}}
                                <div>
                                    <label class="block text-base font-semibold text-gray-700 mb-2">No. WhatsApp</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <span class="text-gray-500 text-base font-medium">+62</span>
                                        </div>
                                        <input wire:model="phone_number" type="text" class="w-full pl-14 px-4 py-3 rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 shadow-sm text-base" placeholder="81234567890">
                                    </div>
                                    @error('phone_number') <span class="text-red-500 text-sm mt-1 font-medium">{{ $message }}</span> @enderror
                                </div>

                                {{-- University --}}
                                <div>
                                    <label class="block text-base font-semibold text-gray-700 mb-2">Universitas / Instansi</label>
                                    <input wire:model="university" type="text" class="w-full px-4 py-3 rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 shadow-sm text-base">
                                    @error('university') <span class="text-red-500 text-sm mt-1 font-medium">{{ $message }}</span> @enderror
                                </div>

                                {{-- Jabatan --}}
                                <div>
                                    <label class="block text-base font-semibold text-gray-700 mb-2">Jabatan Fungsional</label>
                                    <div class="relative">
                                        <select wire:model="functional_position" class="w-full px-4 py-3 rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 shadow-sm text-base appearance-none bg-white">
                                            <option value="">Pilih Jabatan...</option>
                                            <option value="Tenaga Pengajar">Tenaga Pengajar</option>
                                            <option value="Asisten Ahli">Asisten Ahli</option>
                                            <option value="Lektor">Lektor</option>
                                            <option value="Lektor Kepala">Lektor Kepala</option>
                                            <option value="Guru Besar">Guru Besar</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                    </div>
                                    @error('functional_position') <span class="text-red-500 text-sm mt-1 font-medium">{{ $message }}</span> @enderror
                                </div>

                                {{-- Bio --}}
                                <div class="md:col-span-2">
                                    <label class="block text-base font-semibold text-gray-700 mb-2">Bio Singkat</label>
                                    <textarea wire:model="bio" rows="5" class="w-full px-4 py-3 rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 shadow-sm text-base" placeholder="Ceritakan sedikit tentang latar belakang penelitian Anda..."></textarea>
                                    @error('bio') <span class="text-red-500 text-sm mt-1 font-medium">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="flex justify-end pt-8 border-t border-gray-100">
                                <button type="submit" class="inline-flex items-center px-8 py-3.5 bg-red-600 border border-transparent rounded-lg font-bold text-base text-white uppercase tracking-wider hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all shadow-lg shadow-red-200">
                                    <svg wire:loading.remove class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <svg wire:loading class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div> {{-- End Form Konten Data Diri --}}
                </div> {{-- End Card Data Diri --}}

                {{-- 2. Card Password (Keamanan Akun) --}}
                <div class="bg-white shadow-xl shadow-gray-200/50 rounded-2xl overflow-hidden border border-gray-100">
                    
                    {{-- Card Header --}}
                    <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between bg-white">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-gray-100 rounded-lg text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Keamanan Akun</h3>
                                <p class="text-sm text-gray-500">Ubah password untuk melindungi akun Anda.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Form Konten Password --}}
                    <div class="p-8">
                        @if (session()->has('password_message'))
                            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 text-green-700 rounded-r-lg shadow-sm">
                                <p class="font-bold">Sukses!</p>
                                <p class="text-sm">{{ session('password_message') }}</p>
                            </div>
                        @endif

                        <form wire:submit.prevent="updatePassword" class="space-y-8">
                            <div>
                                <label class="block text-base font-semibold text-gray-700 mb-2">Password Saat Ini</label>
                                <input wire:model="current_password" type="password" class="w-full px-4 py-3 rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 shadow-sm text-base" placeholder="********">
                                @error('current_password') <span class="text-red-500 text-sm mt-1 font-medium">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-base font-semibold text-gray-700 mb-2">Password Baru</label>
                                    <input wire:model="new_password" type="password" class="w-full px-4 py-3 rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 shadow-sm text-base" placeholder="********">
                                    @error('new_password') <span class="text-red-500 text-sm mt-1 font-medium">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-base font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
                                    <input wire:model="new_password_confirmation" type="password" class="w-full px-4 py-3 rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 shadow-sm text-base" placeholder="********">
                                </div>
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit" class="inline-flex items-center px-8 py-3.5 bg-gray-900 border border-transparent rounded-lg font-bold text-base text-white uppercase tracking-wider hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-all shadow-lg shadow-gray-300">
                                    Ubah Password
                                </button>
                            </div>
                        </form>
                    </div> {{-- End Form Konten Password --}}
                </div> {{-- End Card Password --}}
            </div> {{-- End KOLOM KIRI --}}

            {{-- KOLOM KANAN: Kartu Profil Ringkas (Sticky) --}}
            <div class="lg:col-span-1">
                {{-- Ubah top-24 untuk memberi jarak aman di bawah Navbar fixed --}}
                <div class="bg-white shadow-xl shadow-gray-200/50 rounded-2xl overflow-hidden border border-gray-100 sticky top-24"> 
                    
                    {{-- Background Header --}}
                    <div class="bg-gradient-to-br from-red-500 to-red-700 h-36 relative overflow-hidden">
                        <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'20\' height=\'20\' viewBox=\'0 0 20 20\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\' fill-rule=\'evenodd\'%3E%3Ccircle cx=\'3\' cy=\'3\' r=\'3\'/%3E%3Ccircle cx=\'13\' cy=\'13\' r=\'3\'/%3E%3C/g%3E%3C/svg%3E');"></div>
                        
                        {{-- Status Badge --}}
                        <div class="absolute top-4 right-4">
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-sm text-white text-xs font-bold rounded-full border border-white/30 uppercase tracking-wide">
                                {{ $role }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="px-6 pb-8 text-center -mt-16 relative">
                        {{-- Avatar Ringkas --}}
                        <div class="inline-block relative">
                            <div class="h-32 w-32 rounded-full bg-white p-1.5 shadow-xl overflow-hidden ring-1 ring-gray-100">
                                @if ($existingPhoto || $photo)
                                    <img class="h-full w-full rounded-full object-cover" 
                                         src="{{ $photo ? $photo->temporaryUrl() : asset('storage/' . $existingPhoto) }}" 
                                         alt="Profile Photo">
                                @else
                                    <div class="h-full w-full rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-gray-400 font-bold text-4xl">
                                        {{ substr($name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <h3 class="mt-4 text-xl font-bold text-gray-900 leading-tight">{{ $name }}</h3>
                        <p class="text-sm text-gray-500 font-medium">{{ $email }}</p>
                        
                        @if($nip)
                            <div class="mt-4 inline-flex items-center px-4 py-1.5 bg-gray-50 text-gray-600 text-xs font-semibold rounded-full border border-gray-200">
                                <span class="text-gray-400 mr-2">ID:</span> {{ $nip }}
                            </div>
                        @endif

                        <div class="mt-8 border-t border-gray-100 pt-6 text-left space-y-4">
                            <div class="flex items-start text-sm group">
                                <div class="p-2 bg-red-50 text-red-600 rounded-lg mr-3 group-hover:bg-red-100 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Instansi</p>
                                    <p class="font-medium text-gray-800">{{ $university ?? 'Belum diisi' }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start text-sm group">
                                <div class="p-2 bg-blue-50 text-blue-600 rounded-lg mr-3 group-hover:bg-blue-100 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Jabatan</p>
                                    <p class="font-medium text-gray-800">{{ $functional_position ?? 'Belum diisi' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>