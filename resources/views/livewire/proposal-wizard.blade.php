<x-slot name="title">Create Proposal</x-slot>
    <div class="grid grid-cols-12 gap-6 p-6">
        {{-- Sidebar Navigasi --}}
        <div class="col-span-12 md:col-span-3 bg-white rounded-xl shadow-sm p-6 h-fit sticky top-24">
            <nav aria-label="Progress">
                <ol role="list" class="overflow-hidden">
                    @php
                        $steps = [
                            'General Info', 
                            'Team Member', 
                            'Output Indicator', 
                            'Research Fund', 
                            'Create Proposal', 
                            'Documents'
                        ];
                    @endphp

                    @foreach($steps as $index => $label)
                        @php
                            $stepNum = $index + 1;
                            $isLast = $loop->last;
                            // Status Logic
                            $isActive = $currentStep === $stepNum;
                            $isCompleted = $currentStep > $stepNum;
                        @endphp

                        <li class="relative {{ !$isLast ? 'pb-10' : '' }}">
                            {{-- 1. GARIS VERTIKAL PENGHUBUNG --}}
                            @if(!$isLast)
                                {{-- Jika step ini sudah dilewati (completed), garis jadi Merah. Jika belum, Abu-abu --}}
                                <div class="absolute top-4 left-4 -ml-px h-full w-0.5 {{ $isCompleted ? 'bg-red-600' : 'bg-gray-200' }}" aria-hidden="true"></div>
                            @endif

                            {{-- 2. LINGKARAN & LABEL --}}
                            <div class="relative flex items-center group">
                                
                                {{-- LINGKARAN NOMOR --}}
                                <span class="h-9 flex items-center" aria-hidden="true">
                                    <span class="relative z-10 w-8 h-8 flex items-center justify-center rounded-full border-2 bg-white transition-colors duration-200 
                                        {{ $isActive || $isCompleted ? 'border-red-600' : 'border-gray-300 group-hover:border-gray-400' }}">
                                        
                                        {{-- Tampilkan Nomor --}}
                                        <span class="text-sm font-bold {{ $isActive || $isCompleted ? 'text-red-600' : 'text-gray-500' }}">
                                            {{ $stepNum }}
                                        </span>
                                    </span>
                                </span>

                                {{-- LABEL TEKS --}}
                                <span class="ml-4 min-w-0 flex flex-col">
                                    <span class="text-sm font-medium tracking-wide transition-colors duration-200
                                        {{ $isActive ? 'text-red-600 font-bold' : ($isCompleted ? 'text-gray-800' : 'text-gray-500') }}">
                                        {{ $label }}
                                    </span>
                                    
                                    {{-- Opsional: Subtext status --}}
                                    @if($isActive)
                                        <span class="text-xs text-red-500">In Progress</span>
                                    @elseif($isCompleted)
                                        <span class="text-xs text-green-600">Completed</span>
                                    @endif
                                </span>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </nav>
        </div>

        {{-- Main Content --}}
        <div class="col-span-9 bg-white rounded-xl shadow p-6">
            
            {{-- STEP 1: GENERAL INFO --}}
            @if($currentStep === 1)
                {{-- Header Section --}}
                <div class="mb-8 border-b border-gray-200 pb-4">
                    <h2 class="text-xl font-bold text-gray-800">General Information</h2>
                    <p class="text-sm text-gray-500 mt-1">Please fill in the basic details of your proposal.</p>
                </div>

                <div class="space-y-6">
                    {{-- Registration Code (Read Only - Dibuat lebih gelap backgroundnya) --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Registration Code (auto generated)</label>
                        <input type="text" wire:model="registration_code" readonly 
                            class="w-full rounded-lg border-gray-300 bg-gray-200 text-gray-600 font-mono px-4 py-3 cursor-not-allowed shadow-inner"
                            style="background-color: #E5E7EB;"> {{-- Force warna abu-abu --}}
                    </div>

                    {{-- Proposal Title --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Proposal Title</label>
                        <input type="text" wire:model="title" 
                            class="w-full rounded-lg border-gray-400 bg-gray-50 text-gray-900 px-4 py-3 focus:bg-white focus:border-red-600 focus:ring-1 focus:ring-red-600 shadow-sm transition-all duration-200 placeholder-gray-400"
                            placeholder="Enter your research title here...">
                        @error('title') <span class="text-red-600 text-xs mt-1 font-semibold">{{ $message }}</span> @enderror
                    </div>

                    {{-- Date --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Date</label>
                        <input type="date" wire:model="date" 
                            class="w-full rounded-lg border-gray-400 bg-gray-50 text-gray-900 px-4 py-3 focus:bg-white focus:border-red-600 focus:ring-1 focus:ring-red-600 shadow-sm cursor-pointer">
                    </div>

                    {{-- Focus & Output (Grid 2 Kolom) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Focus Area --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Focus</label>
                            <div class="relative">
                                <select wire:model="focus_area" 
                                    class="w-full rounded-lg border-gray-400 bg-gray-50 text-gray-900 px-4 py-3 appearance-none focus:bg-white focus:border-red-600 focus:ring-1 focus:ring-red-600 shadow-sm">
                                    <option value="">Select Focus Area</option>
                                    <option value="Ilmu Keolahragaan">Ilmu Keolahragaan</option>
                                    <option value="Teknologi">Teknologi Olahraga</option>
                                    <option value="Manajemen">Manajemen Olahraga</option>
                                    <option value="Psikologi">Psikologi Olahraga</option>
                                    <option value="Kesehatan">Kesehatan Atlet</option>
                                    <option value="Ekonomi">Ekonomi Olahraga</option>
                                    <option value="Pendidikan">Pendidikan Olahraga</option>
                                    <option value="Sosiologi">Sosiologi Olahraga</option>
                                </select>
                                {{-- Custom Arrow Icon agar lebih terlihat --}}
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-700">
                                    <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                            @error('focus_area') <span class="text-red-600 text-xs mt-1 font-semibold">{{ $message }}</span> @enderror
                        </div>

                        {{-- Output --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Output</label>
                            <div class="relative">
                                <select wire:model="output" 
                                    class="w-full rounded-lg border-gray-400 bg-gray-50 text-gray-900 px-4 py-3 appearance-none focus:bg-white focus:border-red-600 focus:ring-1 focus:ring-red-600 shadow-sm">
                                    <option value="">Select Output Target</option>
                                    <option value="Product/Technology">Product/Technology</option>
                                    <option value="Policy Brief">Policy Brief</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-700">
                                    <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- STEP 2: TEAM MEMBERS --}}
            @if($currentStep === 2)
                <div class="mb-6 border-b border-gray-200 pb-4">
                    <h2 class="text-xl font-bold text-gray-800">Team Members</h2>
                    <p class="text-sm text-gray-500 mt-1">Cari dan tambahkan dosen/peneliti yang sudah terdaftar.</p>
                </div>

                {{-- SEARCH SECTION --}}
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-6 mb-8 relative z-50"> {{-- Tambah z-50 agar dropdown di atas elemen lain --}}
                    <label class="block text-sm font-bold text-blue-800 mb-2">Tambah Anggota Tim</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        
                        {{-- Input Search --}}
                        <input type="text" 
                            wire:model.live.debounce.300ms="searchNIP" 
                            class="block w-full pl-10 pr-4 py-3 border-blue-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition shadow-sm placeholder-blue-300" 
                            placeholder="Ketik Nama atau NIP dosen..."
                            autocomplete="off">

                        {{-- Dropdown Hasil Search --}}
                        @if(!empty($searchResults))
                            <div class="absolute z-50 w-full bg-white border border-gray-200 rounded-lg mt-2 shadow-xl max-h-60 overflow-y-auto ring-1 ring-black ring-opacity-5">
                                @foreach($searchResults as $result)
                                    <button type="button" 
                                        wire:click="selectUserForTeam({{ $result->id }})" 
                                        class="w-full text-left px-4 py-3 hover:bg-blue-50 border-b border-gray-100 last:border-0 transition-colors flex justify-between items-center group">
                                        
                                        <div>
                                            <div class="font-bold text-gray-800 group-hover:text-blue-700">{{ $result->name }}</div>
                                            {{-- Pencegahan Error: Cek apakah relasi member ada --}}
                                            <div class="text-xs text-gray-500">NIP: {{ $result->member->nip ?? '-' }}</div>
                                        </div>
                                        
                                        <div class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded group-hover:bg-white">
                                            {{ $result->email }}
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        @elseif(strlen($searchNIP) >= 2)
                            {{-- Pesan jika tidak ada hasil --}}
                            <div class="absolute z-50 w-full bg-white border border-gray-200 rounded-lg mt-2 shadow-lg p-4 text-center text-gray-500 text-sm">
                                Tidak ditemukan user dengan nama/NIP tersebut.
                            </div>
                        @endif
                    </div>
                    <p class="text-xs text-blue-600 mt-2">
                        *Pastikan anggota tim sudah memiliki akun di E-PRONOC.
                    </p>
                </div>

                {{-- LIST MEMBERS --}}
                <div class="space-y-4 relative z-0"> {{-- z-0 agar tidak menutupi dropdown --}}
                    <div class="flex justify-between items-end mb-3">
                        <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider">
                            Anggota Terpilih <span class="bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full text-xs ml-1">{{ count($teamMembers) }}</span>
                        </h3>
                    </div>

                    @forelse($teamMembers as $index => $member)
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between bg-white border border-gray-200 p-4 rounded-xl shadow-sm hover:border-blue-300 transition-all gap-4" wire:key="team-member-{{ $index }}">
                            
                            <div class="flex items-center gap-4">
                                {{-- Avatar --}}
                                <div class="h-12 w-12 rounded-full bg-gradient-to-br from-gray-700 to-gray-900 text-white flex items-center justify-center font-bold text-lg shadow-sm shrink-0">
                                    {{ substr($member['name'], 0, 1) }}
                                </div>
                                
                                <div>
                                    <p class="font-bold text-gray-900 text-base">{{ $member['name'] }}</p>
                                    <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500 mt-0.5">
                                        <span class="bg-gray-100 px-2 py-0.5 rounded border border-gray-200 font-mono">{{ $member['nip'] }}</span>
                                        <span class="hidden sm:inline">•</span>
                                        <span>{{ $member['email'] }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3 w-full sm:w-auto pl-16 sm:pl-0">
                                <select wire:model="teamMembers.{{ $index }}.role" 
                                    class="text-sm border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 py-2 pl-3 pr-8 cursor-pointer bg-gray-50 hover:bg-white transition w-full sm:w-32">
                                    <option value="Anggota">Anggota</option>
                                    <option value="Ketua">Ketua</option>
                                </select>

                                <button wire:click="removeMember({{ $index }})" 
                                    class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors border border-transparent hover:border-red-100" 
                                    title="Hapus Anggota">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 border-2 border-dashed border-gray-300 rounded-xl bg-gray-50/50">
                            <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <p class="text-sm font-medium text-gray-500">Belum ada anggota tim.</p>
                            <p class="text-xs text-gray-400 mt-1">Gunakan kolom pencarian di atas untuk menambahkan dosen/peneliti.</p>
                        </div>
                    @endforelse
                </div>
            @endif


            {{-- STEP 3: OUTPUT INDICATOR --}}
            @if($currentStep === 3)
                <div class="flex justify-between items-center mb-6 border-b border-gray-200 pb-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Output Indicators</h2>
                        <p class="text-sm text-gray-500 mt-1">Define the expected outcomes of your research.</p>
                    </div>
                    <button wire:click="addIndicator" 
                        class="group flex items-center gap-2 bg-red-50 text-red-600 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-600 hover:text-white transition-all duration-200 border border-red-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                        </svg>
                        Add Indicator
                    </button>
                </div>

                <div class="space-y-4">
                    @foreach($outputIndicators as $index => $item)
                        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm relative group hover:shadow-md transition-all">
                            {{-- Header Kecil di dalam Card --}}
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Indicator #{{ $index + 1 }}</span>
                                <button wire:click="removeIndicator({{ $index }})" class="text-gray-400 hover:text-red-600 text-sm flex items-center gap-1 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    Remove
                                </button>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <input type="text" wire:model="outputIndicators.{{ $index }}.indicator" 
                                        class="w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 px-4 py-2.5 focus:bg-white focus:border-red-600 focus:ring-1 focus:ring-red-600 font-semibold placeholder-gray-400" 
                                        placeholder="E.g. Publikasi Jurnal Internasional">
                                </div>
                                <div>
                                    <textarea wire:model="outputIndicators.{{ $index }}.description" 
                                        rows="2"
                                        class="w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 px-4 py-2.5 focus:bg-white focus:border-red-600 focus:ring-1 focus:ring-red-600 text-sm placeholder-gray-400" 
                                        placeholder="Describe the details of this indicator..."></textarea>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if(count($outputIndicators) === 0)
                        <div class="text-center py-8 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300 text-gray-500">
                            <p>No indicators added.</p>
                        </div>
                    @endif
                </div>
            @endif

            {{-- STEP 4: RESEARCH FUND --}}
            @if($currentStep === 4)
                {{-- Header --}}
                <div class="mb-8 border-b border-gray-200 pb-4">
                    <h2 class="text-xl font-bold text-gray-800">Research Fund</h2>
                    <p class="text-sm text-gray-500 mt-1">Estimate the detailed budget for your research proposal.</p>
                </div>

                <div class="space-y-6">
                    {{-- Group Input Biaya --}}
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-6">
                        
                        {{-- 1. Direct Personnel Costs --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                1. Direct Personnel Costs <span class="text-red-500">*</span>
                            </label>
                            <div class="relative rounded-lg shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                    <span class="text-gray-500 font-bold sm:text-sm">Rp.</span>
                                </div>
                                <input type="number" wire:model.live="direct_cost" 
                                    class="block w-full rounded-lg pl-14 pr-4 py-3 font-semibold text-lg transition-colors placeholder-gray-400 border border-gray-300 text-gray-900 bg-white focus:bg-white focus:border-red-600 focus:ring-1 focus:ring-red-600
                                    @error('direct_cost') border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900 @enderror"
                                    placeholder="0">
                            </div>
                            @error('direct_cost') 
                                <p class="mt-1 text-xs text-red-600 font-bold flex items-center animate-pulse">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $message }}
                                </p> 
                            @else
                                <p class="mt-1 text-xs text-gray-500">Biaya gaji, upah, honorarium peneliti dan staf.</p>
                            @enderror
                        </div>

                    {{-- 2. Direct Non-Personnel Costs --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                2. Direct Non-Personnel Costs <span class="text-red-500">*</span>
                            </label>
                            <div class="relative rounded-lg shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                    <span class="text-gray-500 font-bold sm:text-sm">Rp.</span>
                                </div>
                                
                                <input type="number" wire:model.live="non_personnel_cost" 
                                    class="block w-full rounded-lg pl-14 pr-4 py-3 font-semibold text-lg transition-colors placeholder-gray-400 
                                    @error('non_personnel_cost') 
                                        border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900 border
                                    @else 
                                        border-gray-300 focus:bg-white focus:border-red-600 focus:ring-1 focus:ring-red-600 bg-gray-50 text-gray-900 border
                                    @enderror"
                                    placeholder="0">
                            </div>

                            {{-- Pesan Error --}}
                            @error('non_personnel_cost') 
                                <p class="mt-1 text-xs text-red-600 font-bold flex items-center animate-pulse">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $message }}
                                </p> 
                            @else
                                <p class="mt-1 text-xs text-gray-500">Biaya bahan habis pakai, perjalanan, seminar, dll.</p>
                            @enderror
                        </div>

                        {{-- 3. Indirect Cost --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                3. Indirect Cost <span class="text-red-500">*</span>
                            </label>
                            <div class="relative rounded-lg shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                    <span class="text-gray-500 font-bold sm:text-sm">Rp.</span>
                                </div>
                                <input type="number" wire:model.live="indirect_cost" 
                                    class="block w-full rounded-lg pl-14 pr-4 py-3 font-semibold text-lg transition-colors placeholder-gray-400 border border-gray-300 text-gray-900 bg-white focus:bg-white focus:border-red-600 focus:ring-1 focus:ring-red-600
                                    @error('indirect_cost') border-red-500 focus:border-red-600 focus:ring-red-600 bg-red-50 text-red-700 @enderror"
                                    placeholder="0">
                            </div>
                            @error('indirect_cost') 
                                <p class="mt-1 text-xs text-red-600 font-bold flex items-center animate-pulse">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $message }}
                                </p> 
                            @else
                                <p class="mt-1 text-xs text-gray-500">Biaya operasional institusi / overhead.</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Total Summary Card --}}
                    <div class="bg-red-50 border border-red-100 rounded-xl p-6 flex flex-col md:flex-row justify-between items-center gap-4 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-white rounded-full text-red-600 shadow-sm border border-red-100">
                                {{-- Calculator Icon --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Total Budget Plan</h3>
                                <p class="text-sm text-gray-600">Calculated automatically based on inputs</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="block text-xs text-red-500 font-bold uppercase tracking-wider mb-1">Estimated Total</span>
                            <span class="text-3xl font-extrabold text-gray-900">
                                Rp. {{ number_format((float)($this->totalBudget ?? 0), 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    {{-- Upload RAB Area --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            Upload RAB (Excel) <span class="text-red-500">*</span>
                        </label>
                        
                        {{-- Container Upload dengan Error State (Conditional Class) --}}
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed rounded-xl transition-all group relative cursor-pointer
                            {{ $errors->has('rab_file') ? 'border-red-500 bg-red-50' : 'border-gray-300 hover:bg-gray-50 hover:border-red-300 bg-white' }}">
                            
                            <div class="space-y-2 text-center">
                                {{-- Icon Excel/File berubah warna jika error --}}
                                <svg class="mx-auto h-12 w-12 transition-colors duration-200 
                                    {{ $errors->has('rab_file') ? 'text-red-600' : 'text-gray-400 group-hover:text-green-600' }}" 
                                    stroke="currentColor" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="rab_file_upload" class="relative cursor-pointer rounded-md font-bold text-red-600 hover:text-red-500 focus-within:outline-none">
                                        <span>Upload a file</span>
                                        <input id="rab_file_upload" wire:model="rab_file" type="file" class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    XLS or XLSX files only (Max. 10MB)
                                </p>

                                {{-- Preview Nama File Jika Sudah Dipilih dan Valid --}}
                                @if($rab_file && !$errors->has('rab_file'))
                                    <div class="mt-4 flex items-center justify-center gap-2 text-green-600 bg-green-50 py-1 px-3 rounded-full text-sm font-semibold animate-pulse">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        {{ $rab_file->getClientOriginalName() }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- PESAN ERROR STEP 4 --}}
                        @error('rab_file') 
                            <div class="mt-2 flex items-center justify-center text-red-600 animate-pulse">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                <p class="text-xs font-bold">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>
                </div>
            @endif

            {{-- STEP 5: PROPOSAL CONTENT --}}
            @if($currentStep === 5)
                <div class="mb-8 border-b border-gray-200 pb-4">
                    <h2 class="text-xl font-bold text-gray-800">Proposal Content</h2>
                    <p class="text-sm text-gray-500 mt-1">Fill in the main content of your research proposal using the editor below.</p>
                </div>

                {{-- Tampilkan Error Global jika ada (Opsional, agar user sadar ada error) --}}
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
                        <p class="font-bold">Please check the form below for errors.</p>
                    </div>
                @endif

                <div class="space-y-10">
                    
                    {{-- 1. ABSTRACT --}}
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <div class="flex justify-between items-center mb-4">
                            <label class="text-lg font-bold text-gray-800">1. Abstract</label>
                            <span class="text-xs font-semibold px-2 py-1 bg-gray-100 text-gray-600 rounded">Max 300 words</span>
                        </div>

                        {{-- Info Box --}}
                        <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 flex gap-3 mb-4">
                            <div class="shrink-0 text-blue-500 mt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <p class="text-sm text-blue-800 leading-relaxed">
                                Write a summary containing the <strong>urgency, objectives, and main results</strong> of the research.
                            </p>
                        </div>
                        
                        {{-- Editor Container --}}
                        {{-- PENTING: wire:ignore hanya membungkus editor, JANGAN bungkus @error di dalamnya --}}
                        <div wire:ignore class="border border-gray-300 rounded-lg overflow-hidden hover:border-red-400 transition-colors focus-within:ring-1 focus-within:ring-red-500 focus-within:border-red-500">
                            <div id="abstract_editor" style="height: 300px;" class="bg-white"></div>
                        </div>
                        
                        {{-- PESAN ERROR DI SINI (Di luar wire:ignore) --}}
                        @error('abstract') 
                            <div class="mt-2 flex items-center text-red-600 text-sm font-bold animate-pulse">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- 2. INTRODUCTION --}}
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <div class="flex justify-between items-center mb-4">
                            <label class="text-lg font-bold text-gray-800">2. Introduction</label>
                            <span class="text-xs font-semibold px-2 py-1 bg-gray-100 text-gray-600 rounded">Max 1000 words</span>
                        </div>

                        <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 flex gap-3 mb-4">
                            <div class="shrink-0 text-blue-500 mt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="text-sm text-blue-800 leading-relaxed space-y-1">
                                <p class="font-semibold">Include the following points:</p>
                                <ul class="list-disc list-inside ml-1 text-blue-700">
                                    <li>Background and problem formulation</li>
                                    <li>Approach to solving problems</li>
                                </ul>
                            </div>
                        </div>

                        <div wire:ignore class="border border-gray-300 rounded-lg overflow-hidden hover:border-red-400 transition-colors focus-within:ring-1 focus-within:ring-red-500 focus-within:border-red-500">
                            <div id="introduction_editor" style="height: 400px;" class="bg-white"></div>
                        </div>
                        
                        {{-- PESAN ERROR --}}
                        @error('introduction') 
                            <div class="mt-2 flex items-center text-red-600 text-sm font-bold animate-pulse">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- 3. PROJECT METHOD --}}
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <label class="block text-lg font-bold text-gray-800 mb-4">3. Project Method</label>

                        <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 flex gap-3 mb-4">
                            <div class="shrink-0 text-blue-500 mt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <p class="text-sm text-blue-800 leading-relaxed">
                                Describe the research flow chart, clear steps, process, output, and targeted achievement indicators reflected in the budget plan (RAB).
                            </p>
                        </div>

                        <div wire:ignore class="border border-gray-300 rounded-lg overflow-hidden hover:border-red-400 transition-colors focus-within:ring-1 focus-within:ring-red-500 focus-within:border-red-500">
                            <div id="method_editor" style="height: 300px;" class="bg-white"></div>
                        </div>
                        
                        {{-- PESAN ERROR --}}
                        @error('project_method') 
                            <div class="mt-2 flex items-center text-red-600 text-sm font-bold animate-pulse">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- 4. BIBLIOGRAPHY --}}
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <label class="block text-lg font-bold text-gray-800 mb-4">4. Bibliography</label>

                        <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 flex gap-3 mb-4">
                            <div class="shrink-0 text-blue-500 mt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <p class="text-sm text-blue-800 leading-relaxed">
                                Use <strong>Vancouver format</strong>. Only include literature cited in this proposal.
                            </p>
                        </div>

                        <div wire:ignore class="border border-gray-300 rounded-lg overflow-hidden hover:border-red-400 transition-colors focus-within:ring-1 focus-within:ring-red-500 focus-within:border-red-500">
                            <div id="bibliography_editor" style="height: 300px;" class="bg-white"></div>
                        </div>
                        
                        {{-- PESAN ERROR --}}
                        @error('bibliography') 
                            <div class="mt-2 flex items-center text-red-600 text-sm font-bold animate-pulse">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div> 
            @endif

            {{-- STEP 6: DOCUMENTS --}}
            @if($currentStep === 6)
                <div class="mb-8 border-b border-gray-200 pb-4">
                    <h2 class="text-xl font-bold text-gray-800">Supporting Documents</h2>
                    <p class="text-sm text-gray-500 mt-1">Upload the required legal and administrative documents.</p>
                </div>
                
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <label class="block text-sm font-bold text-gray-700 mb-4">Surat Pernyataan (Statement Letter) <span class="text-red-500">*</span></label>
                    
                    {{-- Upload Area Modern dengan Error State --}}
                    <div class="flex justify-center px-6 pt-10 pb-10 border-2 border-dashed rounded-xl transition-all group relative cursor-pointer
                        {{ $errors->has('statement_letter') ? 'border-red-500 bg-red-50' : 'border-gray-300 hover:bg-gray-50 hover:border-red-300' }}">
                        
                        <div class="space-y-2 text-center">
                            {{-- Icon berubah warna jika error --}}
                            <svg class="mx-auto h-14 w-14 transition-colors duration-200 
                                {{ $errors->has('statement_letter') ? 'text-red-500' : 'text-gray-400 group-hover:text-red-500' }}" 
                                stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label class="relative cursor-pointer rounded-md font-bold text-red-600 hover:text-red-500 focus-within:outline-none">
                                    <span>Upload a PDF file</span>
                                    <input type="file" wire:model="statement_letter" class="sr-only">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">
                                PDF up to 5MB
                            </p>

                            {{-- Preview --}}
                            @if($statement_letter && !$errors->has('statement_letter'))
                                <div class="mt-4 flex items-center justify-center gap-2 text-green-700 bg-green-50 border border-green-200 py-2 px-4 rounded-lg text-sm font-semibold animate-pulse">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $statement_letter->getClientOriginalName() }}
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- PESAN ERROR STEP 6 --}}
                    @error('statement_letter') 
                        <div class="mt-2 flex items-center justify-center text-red-600 animate-pulse">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <p class="text-xs font-bold">{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            @endif

            {{-- TOMBOL NAVIGASI --}}
            <div class="mt-10 pt-6 border-t border-gray-100 flex justify-between items-center">
                {{-- Tombol Back --}}
                @if($currentStep > 1)
                    <button wire:click="previousStep" 
                        class="group flex items-center gap-2 px-6 py-2.5 bg-white border border-gray-300 text-gray-700 font-semibold rounded-lg shadow-sm hover:bg-gray-50 hover:text-gray-900 transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                        Back
                    </button>
                @else
                    <a href="/proposalutama" 
                    class="group flex items-center gap-2 px-6 py-2.5 bg-white border border-gray-300 text-gray-700 font-semibold rounded-lg shadow-sm hover:bg-gray-50 hover:text-gray-900 transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                    Back
                    </a>
                @endif

                {{-- Tombol Next / Submit --}}
                @if($currentStep < 6) 
                    <button wire:click="nextStep" 
                        class="group flex items-center gap-2 px-8 py-2.5 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 hover:shadow-lg transition-all duration-200">
                        Next Step
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </button>
                @else
                    <button type="button" onclick="confirmSubmit()" {{-- Panggil fungsi JS, bukan wire:click --}} wire:loading.attr="disabled" wire:target="submitProposal" class="px-6 py-2 bg-green-600 text-white rounded shadow hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed">            
                        {{-- Loading State tetap jalan --}}
                        <span wire:loading.remove wire:target="submitProposal">
                            Generate and Submit Proposal
                        </span>
                        <span wire:loading wire:target="submitProposal">
                            Processing...
                        </span>
                    </button>
                @endif
            </div>
        </div>
    </div>

    {{-- SCRIPT DILETAKKAN DI LUAR @IF AGAR SELALU ADA --}}
    {{-- SCRIPT KHUSUS TINYMCE --}}
    <script>
    // 1. FUNGSI KONFIRMASI (Dipanggil saat tombol diklik)
        function confirmSubmit() {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Pastikan semua data terisi dengan benar sebelum mengirim proposal.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#16a34a', // Warna Hijau (sesuai tombol)
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Submit Proposal!',
                cancelButtonText: 'Batal, cek lagi'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika user klik Ya, panggil method Livewire
                    // @this.call memanggil method PHP dari JavaScript
                    @this.call('submitProposal');
                }
            });
        }

        // 2. LISTENER SUKSES (Dipanggil setelah PHP selesai memproses)
        window.addEventListener('proposal-submitted', event => {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Proposal telah berhasil dibuat dan disimpan.',
                icon: 'success',
                confirmButtonText: 'OK',
                confirmButtonColor: '#16a34a',
                allowOutsideClick: false // User wajib klik OK
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect manual menggunakan JavaScript setelah user klik OK
                    window.location.href = '/proposalutama'; 
                }
            });
        });

    // 2. FUNGSI QUIL (Dipanggil saat tombol diklik)

        function initQuill(elementId, propertyName) {
            // Cek elemen dulu
            var el = document.getElementById(elementId);
            if (!el) return;

            // Cek jika editor sudah ada agar tidak duplikat toolbar
            if (el.classList.contains('ql-container')) return;

            // Konfigurasi Toolbar
            var toolbarOptions = [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'], 
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'align': [] }],
                ['link', 'image'], // Support Image Base64 bawaan Quill
                ['clean']
            ];

            // Inisialisasi Quill
            var quill = new Quill('#' + elementId, {
                theme: 'snow',
                modules: {
                    toolbar: toolbarOptions
                }
            });

            // 1. Load Data Awal dari Livewire
            // Kita ambil data dari properti Livewire menggunakan @this
            var initialContent = @this.get(propertyName);
            if (initialContent) {
                // pasteHTML digunakan untuk memasukkan HTML ke editor
                quill.clipboard.dangerouslyPasteHTML(initialContent);
            }

            // 2. Sinkronisasi Data ke Livewire saat mengetik
            quill.on('text-change', function() {
                // Ambil HTML dari dalam editor
                var html = quill.root.innerHTML;
                
                // Kirim ke Livewire (debounce opsional bisa diatur di sini jika mau)
                @this.set(propertyName, html);
            });
        }

        // Listener Livewire (Logic penunggu elemen tetap sama)
        window.addEventListener('init-ckeditor', event => {
            // Meski nama eventnya 'init-ckeditor', isinya kita jalankan Quill
            let attempts = 0;
            const tryInit = () => {
                const el = document.getElementById('abstract_editor');
                if (el) {
                    initQuill('abstract_editor', 'abstract');
                    initQuill('introduction_editor', 'introduction');
                    initQuill('method_editor', 'project_method');
                    initQuill('bibliography_editor', 'bibliography');
                } else if (attempts < 20) {
                    attempts++;
                    setTimeout(tryInit, 100);
                }
            };
            tryInit();
        });

        // Listener untuk scroll ke abstract
        window.addEventListener('scroll-to-abstract', event => {
            const abstractSection = document.querySelector('[data-section="abstract"]');
            if (abstractSection) {
                abstractSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    </script>

