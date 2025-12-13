<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str; // Tambahkan ini jika mau pakai Str::slug, tapi cara di bawah pakai str_replace native

class FundRealizationController extends Controller
{
    public function downloadPdf($id)
    {
        // 1. Ambil data berdasarkan ID
        $budget = Budget::with('proposal')->findOrFail($id);

        // 2. Load View khusus PDF
        $pdf = Pdf::loadView('pdf.fund-realization-document', [
            'budget' => $budget
        ]);

        // 3. Set ukuran kertas dan orientasi
        $pdf->setPaper('A4', 'portrait');

        // 4. SANITASI NAMA FILE
        // Ambil kode, default ke 'DOC' jika null
        $rawCode = $budget->proposal->registration_code ?? 'DOC';
        
        // Ganti karakter '/' dan '\' menjadi '-' agar valid sebagai nama file
        // Contoh: "RCMS/RES/2025" menjadi "RCMS-RES-2025"
        $safeCode = str_replace(['/', '\\'], '-', $rawCode);

        // Buat nama file akhir
        $filename = 'Realization-' . $safeCode . '.pdf';
        
        return $pdf->download($filename);
    }
}