<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use DOMDocument;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth; // PENTING: Untuk filter berdasarkan User Login

class ProposalController 
{
    /**
     * Menampilkan daftar proposal milik user yang sedang login.
     */
    public function index()
    {
        // 1. Ambil ID User yang sedang login
        $userId = Auth::id();

        // 2. Query Proposal dengan filter user via relasi teamMembers
        $proposals = Proposal::with('budget')
            ->whereHas('teamMembers', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->latest()
            ->paginate(10);

        return view('proposalutama.index', compact('proposals'));
    }

    /**
     * Menampilkan detail proposal.
     * Hanya bisa diakses jika user adalah anggota tim proposal tersebut.
     */
    public function show($id)
    {
        $proposal = Proposal::with(['teamMembers.member', 'budget', 'outputIndicators'])
            ->whereHas('teamMembers', function($q) {
                $q->where('user_id', Auth::id());
            })
            ->findOrFail($id);

        return view('proposals.show', compact('proposal'));
    }

    /**
     * Generate dan Download PDF Proposal.
     */
    public function download($id)
    {
        // 1. Ambil Data (Filter User & Eager Load Relasi)
        $proposal = Proposal::with(['teamMembers.member', 'budget', 'outputIndicators'])
                            ->whereHas('teamMembers', function($q) {
                                $q->where('user_id', Auth::id());
                            })
                            ->findOrFail($id);
                            
        // 2. Proses HTML: Ubah semua gambar (Lokal & Online) menjadi Base64
        // Ini wajib agar gambar tampil di DomPDF
        $proposal->abstract = $this->processImages($proposal->abstract);
        $proposal->introduction = $this->processImages($proposal->introduction);
        $proposal->project_method = $this->processImages($proposal->project_method);
        $proposal->bibliography = $this->processImages($proposal->bibliography);

        // 3. Load View PDF
        $pdf = Pdf::loadView('pdf.proposal_document', compact('proposal'));
        
        // 4. Konfigurasi PDF
        $pdf->setOptions([
            'isRemoteEnabled' => true, 
            'isHtml5ParserEnabled' => true
        ]);
        $pdf->setPaper('A4', 'portrait');

        // 5. Nama File Aman (ganti slash dengan dash)
        $safeFileName = str_replace('/', '-', $proposal->registration_code);

        return $pdf->stream('Proposal-' . $safeFileName . '.pdf');
    }

    /**
     * Helper Private: Mengubah src gambar (lokal/url) menjadi Base64 string.
     * Solusi ampuh untuk masalah gambar broken di DomPDF.
     */
    private function processImages($htmlContent)
    {
        // Jika konten kosong atau tidak ada gambar, kembalikan langsung
        if (empty($htmlContent) || strpos($htmlContent, '<img') === false) {
            return $htmlContent;
        }

        $dom = new DOMDocument();
        // Suppress error parsing HTML5 tags
        libxml_use_internal_errors(true);
        
        // Load HTML dengan encoding UTF-8
        $dom->loadHTML(
            mb_convert_encoding('<div>' . $htmlContent . '</div>', 'HTML-ENTITIES', 'UTF-8'), 
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );
        libxml_clear_errors();

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            $imageData = null;
            $type = 'jpg'; // Default fallback

            // SKENARIO 1: Gambar Lokal (/storage/...)
            if (strpos($src, '/') === 0) {
                $path = public_path($src);
                if (file_exists($path)) {
                    $imageData = file_get_contents($path);
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                }
            } 
            // SKENARIO 2: Gambar Online (https://...)
            elseif (filter_var($src, FILTER_VALIDATE_URL)) {
                try {
                    // Gunakan HTTP Client Laravel (ignore SSL verify untuk local dev)
                    $response = Http::withoutVerifying()->get($src);
                    
                    if ($response->successful()) {
                        $imageData = $response->body();
                        $contentType = $response->header('Content-Type'); 
                        if($contentType) {
                            // Ambil ekstensi dari header (contoh: image/png -> png)
                            $type = explode('/', $contentType)[1] ?? 'jpg';
                        }
                    }
                } catch (\Exception $e) {
                    continue; // Skip jika gagal download
                }
            } 
            // SKENARIO 3: Sudah Base64
            else {
                continue; // Tidak perlu diproses
            }

            // Jika berhasil mendapatkan data gambar, ubah src jadi Base64
            if ($imageData) {
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($imageData);
                $img->setAttribute('src', $base64);
                
                // Reset ukuran style agar pas di PDF (Opsional, agar tidak melebar)
                $img->removeAttribute('style'); 
                $img->setAttribute('style', 'max-width: 100%; height: auto;');
            }
        }

        // Simpan HTML yang sudah diproses (hapus wrapper div yang kita buat di awal)
        $processedHtml = $dom->saveHTML($dom->documentElement);
        return substr($processedHtml, 5, -6);
    }
}