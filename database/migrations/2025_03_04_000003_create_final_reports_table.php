<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('final_reports', function (Blueprint $table) {
            $table->id();

            // MENGHUBUNGKAN KE TABLE PROPOSALS
            $table->foreignId('proposal_id')
                  ->constrained('proposals')
                  ->cascadeOnDelete();

            $table->string('title');
            $table->date('date')->nullable();
            $table->string('status')->default('Pending');
            
            // Kolom data lengkap
            $table->string('focus_area')->nullable();
            $table->string('focus')->nullable();
            $table->text('abstract')->nullable();
            $table->text('introduction')->nullable();
            $table->text('project_method')->nullable();
            $table->text('results')->nullable();       // Sudah digabung
            $table->text('note')->nullable();          // Sudah digabung
            $table->text('bibliography')->nullable();
            $table->string('statement_letter')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('final_reports');
    }
};