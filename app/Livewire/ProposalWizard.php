<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ProposalWizard extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $totalSteps = 6;

    // Data Proposal
    public $title, $registration_code, $date, $focus_area, $output;
    
    // Data Team
    public $teamMembers = []; 
    public $searchNIP = ''; 
    public $searchResults = [];

    // Data Lainnya
    public $outputIndicators = [['indicator' => 'Skema D (Sinta/Scopus)', 'description' => '']];
    public $direct_cost = 0, $non_personnel_cost = 0, $indirect_cost = 0;
    
    // File Uploads
    public $rab_file;
    public $statement_letter;

    // Content
    public $abstract, $introduction, $project_method, $bibliography;

    public function mount()
    {
        $this->date = date('Y-m-d');
        $this->registration_code = 'RCMS/RES/' . date('Y') . '/XXXXX';
        
        $user = Auth::user();
    
        // 1. CEK KELENGKAPAN PROFIL
        // Jika user belum punya data member atau NIP kosong, redirect ke profil
        if (!$user->member || empty($user->member->nip)) {
            session()->flash('error', 'Silakan lengkapi profil Anda terlebih dahulu!');
            return redirect()->route('profile');
        }

        // 2. OTOMATIS TAMBAHKAN KETUA (USER LOGIN)
        if (empty($this->teamMembers)) {
            if ($user) {
                $nip = $user->member ? $user->member->nip : '-';

                $this->teamMembers[] = [
                    'user_id' => $user->id,
                    'nip'     => $nip,
                    'name'    => $user->name,
                    'email'   => $user->email,
                    'role'    => 'Ketua'
                ];
            }
        }
    }

    // --- REAL-TIME VALIDATION HOOKS ---
    // Agar pesan error langsung hilang saat file dipilih
    public function updatedRabFile()
    {
        $this->validate(['rab_file' => 'required|file|mimes:xls,xlsx|max:10240']);
    }

    public function updatedStatementLetter()
    {
        $this->validate(['statement_letter' => 'required|file|mimes:pdf,doc,docx|max:10240']);
    }

    // --- TEAM MANAGEMENT ---
    public function updatedSearchNIP()
    {
        if (strlen($this->searchNIP) >= 3) {
            $this->searchResults = User::query()
                ->where('user_group', 'peneliti')
                ->where(function($q) {
                    $q->where('name', 'like', '%' . $this->searchNIP . '%')
                      ->orWhereHas('member', function ($query) {
                          $query->where('nip', 'like', '%' . $this->searchNIP . '%');
                      });
                })
                ->with('member') 
                ->take(5)
                ->get();
        } else {
            $this->searchResults = [];
        }
    }

    public function selectUserForTeam($userId)
    {
        $user = User::with('member')->find($userId);

        if ($user) {
            // Cek Duplikasi
            $exists = collect($this->teamMembers)->contains('user_id', $user->id);

            if (!$exists) {
                $this->teamMembers[] = [
                    'user_id' => $user->id,
                    'nip'     => $user->member->nip ?? '-',
                    'name'    => $user->name,
                    'email'   => $user->email,
                    'role'    => 'Anggota'
                ];
            }
        }
        
        $this->searchNIP = '';
        $this->searchResults = [];
    }

    public function removeMember($index) 
    { 
        unset($this->teamMembers[$index]); 
        $this->teamMembers = array_values($this->teamMembers); 
    }

    // --- DYNAMIC INPUTS ---
    public function addIndicator() { $this->outputIndicators[] = ['indicator' => '', 'description' => '']; }
    public function removeIndicator($index) { unset($this->outputIndicators[$index]); $this->outputIndicators = array_values($this->outputIndicators); }
    
    // Computed Property for Budget
    public function getTotalBudgetProperty() { 
        return (float)$this->direct_cost + (float)$this->non_personnel_cost + (float)$this->indirect_cost; 
    }

    // --- VALIDASI PER STEP ---
    public function validateStep()
    {
        if ($this->currentStep == 1) {
            $this->validate([
                'title' => 'required|min:5',
                'focus_area' => 'required',
                'output' => 'required',
                'date' => 'required|date',
            ]);
        }
        
        if ($this->currentStep == 2) {
            $this->validate([
                'teamMembers' => 'required|array|min:1',
                'teamMembers.*.role' => 'required',
            ]);
        }
        
        if ($this->currentStep == 3) {
            $this->validate(['outputIndicators.*.indicator' => 'required']);
        }
        
        if ($this->currentStep == 4) {
            $this->validate([
                'direct_cost' => 'required|numeric|min:0', 
                'rab_file' => 'required|file|mimes:xls,xlsx|max:10240'
            ], [
                'rab_file.required' => 'Dokumen RAB wajib diunggah.',
                'rab_file.mimes' => 'Format file harus Excel (.xls, .xlsx).',
            ]);
        }
        
        // --- [VALIDASI STEP 5: MIN 50 CHAR] ---
        if ($this->currentStep == 5) {
            $this->validate([
                'abstract'       => 'required|string|min:50',
                'introduction'   => 'required|string|min:50',
                'project_method' => 'required|string|min:50',
                'bibliography'   => 'required|string|min:50',
            ], [
                'abstract.min'       => 'Abstract harus memiliki minimal 50 karakter.',
                'introduction.min'   => 'Introduction harus memiliki minimal 50 karakter.',
                'project_method.min' => 'Project Method harus memiliki minimal 50 karakter.',
                'bibliography.min'   => 'Bibliography harus memiliki minimal 50 karakter.',
            ]);
        }

        if ($this->currentStep == 6) {
            $this->validate([
                'statement_letter' => 'required|file|mimes:pdf,doc,docx|max:10240'
            ], [
                'statement_letter.required' => 'Dokumen pendukung wajib diunggah.'
            ]);
        }
    }

    public function nextStep()
    {
        $this->validateStep();
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
            // Re-init CKEditor jika masuk ke step konten
            if ($this->currentStep == 5) {
                $this->dispatch('init-ckeditor');
            }
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
            if ($this->currentStep == 5) {
                $this->dispatch('init-ckeditor');
            }
        }
    }

    // --- SUBMIT FINAL ---
    public function submitProposal()
    {
        // 1. Validasi Akhir sebelum Transaksi
        $this->validate([
            'title' => 'required',
            'teamMembers' => 'required|array|min:1',
            'statement_letter' => 'required|file|mimes:pdf,doc,docx|max:10240', // Pastikan file ada
        ], [
            'statement_letter.required' => 'Gagal Submit: Dokumen Pendukung wajib diunggah.'
        ]);

        DB::transaction(function () {
            // Generate Unique Code
            do {
                $uniqueCode = 'RCMS/RES/' . date('Y') . '/' . strtoupper(Str::random(5));
            } while (Proposal::where('registration_code', $uniqueCode)->exists());
            
            // Simpan Proposal (Link ke User Login)
            $proposal = Proposal::create([
                'user_id'           => Auth::id(), // ID Pemilik
                'registration_code' => $uniqueCode, 
                'title'             => $this->title,
                'date'              => $this->date,
                'focus_area'        => $this->focus_area,
                'output'            => $this->output, 
                'abstract'          => $this->abstract,
                'introduction'      => $this->introduction,
                'project_method'    => $this->project_method,
                'bibliography'      => $this->bibliography,
                'status'            => 'SUBMITTED',
                // Simpan File Statement
                'statement_letter'  => $this->statement_letter->store('proposals/letters', 'public'),
            ]);

            // Simpan Tim (Pivot)
            foreach ($this->teamMembers as $memberData) {
                $proposal->teamMembers()->attach($memberData['user_id'], [
                    'role' => $memberData['role']
                ]);
            }
            
            // Simpan Output Indicators
            $proposal->outputIndicators()->createMany($this->outputIndicators);
            
            // Simpan Budget & File RAB
            $proposal->budget()->create([
                'direct_personnel_cost_proposal' => $this->direct_cost,
                'non_personnel_cost_proposal'    => $this->non_personnel_cost,
                'indirect_cost_proposal'         => $this->indirect_cost,
                'document_rab_proposal'          => $this->rab_file ? $this->rab_file->store('proposals/rab', 'public') : null,
                'status'                         => 'Pending',
            ]);

            // Buat Progress Report Awal
            $proposal->progressReport()->create(['report_date' => now()]);
        });

        // Trigger Event Sukses
        $this->dispatch('proposal-submitted');
    }

    public function render()
    {
        return view('livewire.proposal-wizard');
    }
}
