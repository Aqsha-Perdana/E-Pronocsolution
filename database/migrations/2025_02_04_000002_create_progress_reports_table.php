<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('progress_reports', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke Proposal
            $table->foreignId('proposal_id')
                  ->constrained('proposals')
                  ->cascadeOnDelete();

            $table->date('report_date');
            $table->integer('percentage_complete')->default(0);
            $table->string('status')->default('In Progress'); 
            
            // --- KOLOM BARU SESUAI KONSEP PROGRES ---
            
            // 1. Kegiatan yang telah dilakukan (Ex: Abstract)
            $table->longText('activities')->nullable(); 
            
            // 2. Hasil Sementara/Output (Ex: Results)
            $table->longText('results')->nullable();
            
            // 3. Kendala & Solusi (Ex: Introduction)
            $table->longText('obstacles')->nullable();
            
            // 4. Rencana Tahap Berikutnya (Ex: Method)
            $table->longText('next_steps')->nullable();
            
            // 5. Lampiran/Bukti Dukung (Ex: Bibliography)
            $table->longText('attachments')->nullable();
            
            // Catatan Tambahan
            $table->text('notes')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('progress_reports');
    }
};