<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
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
        // Agar PDF tidak perlu download ulang saat render.
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

    public function list()
    {
        $proposals = Proposal::all();
        return view('proposalsel.list', compact('proposals'))->with('page', 'list');
    }

    public function review()
    {
        // Ambil semua proposal yang perlu direview
        $proposals = Proposal::where('status', 'SUBMITTED')->get();
        return view('proposalsel.review', compact('proposals'));
    }

    public function grading()
    {
        // Ambil semua proposal yang perlu direview
        $proposals = Proposal::where('status', 'APPROVED')->get();
        return view('proposalsel.done', compact('proposals'));
    }

    public function accept(Request $request, $proposal)
{
    $proposal = Proposal::findOrFail($proposal);
    $proposal->status = 'ACCEPTED';
    $proposal->save();

    return response()->json([
        'success' => true,
        'message' => 'Proposal berhasil disetujui'
    ]);
}
    
    public function reject(Request $request, $proposal)
    {
    $proposal = Proposal::findOrFail($proposal);
    $proposal->status = 'REJECTED';
    $proposal->save();

    return response()->json([
        'success' => true,
        'message' => 'Proposal berhasil ditolak'
    ]);
    }
public function graded($id)
{
    $proposal = Proposal::with('teamMembers')->findOrFail($id);
    return view('proposalsel.graded', compact('proposal'));
}
// Di ProposalController.php

public function submitReview(Request $request, $id)
{
    try {
        $proposal = \App\Models\Proposal::findOrFail($id);

        $request->validate([
            'sections' => 'required|array',
            'sections.*.name' => 'required|string',
            'sections.*.score' => 'required|numeric|min:0|max:10',
            'sections.*.notes' => 'nullable|string',
        ]);

        $totalScore = collect($request->sections)->sum('score');

        // Update proposal
        $proposal->update([
            'status' => 'APPROVED',
            'total_score' => $totalScore,
            'graded_at' => now(),
        ]);

        // SIMPAN KE proposal_reviews
        \App\Models\ProposalReview::create([
            'proposal_id' => $proposal->id,
            'users_id' => auth()->id(),
            'sections' => $request->sections, // otomatis JSON
            'total_score' => $totalScore,
            'reviewed_at' => now(),
        ]);

        return redirect()
            ->route('proposalsel.done')
            ->with('success', 'Review berhasil disimpan!');
    } catch (\Exception $e) {
        dd($e->getMessage());
        \Log::error('Submit Review Error', ['error' => $e]);

        return back()->with('error', 'Terjadi kesalahan saat menyimpan review.');
    }
}
}