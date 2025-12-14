<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Budget;

class FundRealizationReportEdit extends Component
{
    use WithFileUploads;

    public $budget;
    
    // Form Inputs (Mapped to component properties)
    public $direct_cost_realization;
    public $non_personnel_cost_realization;
    public $indirect_cost_realization;
    public $document_rab_realization; // Temporary file upload

    public function mount($id)
    {
        // 1. Ambil data budget & proposal
        $this->budget = Budget::with('proposal')->findOrFail($id);

        // 2. Isi form dengan data database (agar tidak kosong saat edit)
        $this->direct_cost_realization = $this->budget->direct_personnel_cost_fundrealization;
        $this->non_personnel_cost_realization = $this->budget->non_personnel_cost_fundrealization;
        $this->indirect_cost_realization = $this->budget->indirect_cost_fundrealization;
    }

    // Hitung Total Realisasi (Otomatis update di view)
    public function getTotalRealizationProperty()
    {
        return (float)$this->direct_cost_realization + 
               (float)$this->non_personnel_cost_realization + 
               (float)$this->indirect_cost_realization;
    }

    // Hitung Sisa Dana
    public function getRemainingFundProperty()
    {
        // Ambil Total Plan dari kolom proposal di tabel budgets
        // Pastikan kolom ini terisi di database saat proposal dibuat
        $totalPlan = ($this->budget->direct_personnel_cost_proposal ?? 0) + 
                     ($this->budget->non_personnel_cost_proposal ?? 0) + 
                     ($this->budget->indirect_cost_proposal ?? 0);
                     
        return $totalPlan - $this->totalRealization;
    }

    public function save()
    {
        // --- VALIDASI KETAT ---
        
        // Cek apakah file sudah ada di database sebelumnya?
        // Jika SUDAH ada, upload baru opsional ('nullable').
        // Jika BELUM ada, upload baru wajib ('required').
        $fileRule = $this->budget->document_rab_fundrealization ? 'nullable' : 'required';

        $this->validate([
            'direct_cost_realization'        => 'required|numeric|min:0',
            'non_personnel_cost_realization' => 'required|numeric|min:0',
            'indirect_cost_realization'      => 'required|numeric|min:0',
            'document_rab_realization'       => [$fileRule, 'file', 'mimes:xlsx,xls,pdf', 'max:10240'], // Max 10MB
        ], [
            // Pesan Error Bahasa Indonesia yang Jelas
            'direct_cost_realization.required'        => 'Biaya Personil wajib diisi (masukkan 0 jika tidak ada).',
            'non_personnel_cost_realization.required' => 'Biaya Non-Personil wajib diisi (masukkan 0 jika tidak ada).',
            'indirect_cost_realization.required'      => 'Biaya Tidak Langsung wajib diisi (masukkan 0 jika tidak ada).',
            
            'document_rab_realization.required'       => 'Dokumen Pendukung (RAB Realisasi) wajib diunggah!',
            'document_rab_realization.mimes'          => 'Format file harus Excel (.xlsx, .xls) atau PDF.',
            'document_rab_realization.max'            => 'Ukuran file terlalu besar (Maksimal 10MB).',
        ]);

        // --- PROSES SIMPAN ---

        // 1. Tentukan path file (Gunakan yang lama jika tidak ada upload baru)
        $filePath = $this->budget->document_rab_fundrealization;
        
        if ($this->document_rab_realization) {
            // Simpan file baru ke storage
            $filePath = $this->document_rab_realization->store('realization_docs', 'public');
        }

        // 2. Update Database
        $this->budget->update([
            'direct_personnel_cost_fundrealization' => $this->direct_cost_realization,
            'non_personnel_cost_fundrealization'    => $this->non_personnel_cost_realization,
            'indirect_cost_fundrealization'         => $this->indirect_cost_realization,
            'document_rab_fundrealization'          => $filePath, // Path file (baru atau lama)
            'status'                                => 'Done'
        ]);

        // 3. Feedback & Redirect
        session()->flash('message', 'Laporan Realisasi Dana berhasil disimpan.');
        return redirect()->route('report.fund');
    }

    public function render()
    {
        return view('livewire.fund-realization-report-edit');
    }
}