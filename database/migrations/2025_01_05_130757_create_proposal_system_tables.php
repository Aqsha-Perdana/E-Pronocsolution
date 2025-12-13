<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Table: members
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke User
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); 
            
            $table->string('nip')->unique()->nullable(); // Boleh null saat awal register
            $table->string('phone_number')->nullable();
            $table->string('university')->nullable(); 
            $table->string('functional_position')->nullable(); 
            $table->text('bio')->nullable(); 
            $table->string('profile_photo_path')->nullable(); 
            $table->timestamps();
        });

        // 2. Table: proposals
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            
            // --- [TAMBAHAN PENTING] HUBUNGKAN KE USER PEMBUAT ---
            // Ini agar kita tahu proposal ini milik siapa secara langsung
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            // -----------------------------------------------------

            $table->string('registration_code')->unique()->nullable();
            $table->string('title');
            $table->date('date');
            $table->string('focus_area');
            $table->string('output');
            $table->longText('abstract')->nullable();
            $table->longText('introduction')->nullable();
            $table->longText('project_method')->nullable();
            $table->longText('bibliography')->nullable();
            $table->string('statement_letter')->nullable();
            $table->enum('status', ['DRAFT', 'SUBMITTED', 'APPROVED', 'REJECTED'])->default('DRAFT');
            $table->timestamps();
        });

        // 3. Table: output_indicators
        Schema::create('output_indicators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained()->cascadeOnDelete();
            $table->string('indicator');
            $table->text('indicator_description')->nullable();
            $table->timestamps();
        });
        
        // 4. Table: budgets
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained()->cascadeOnDelete();
            $table->decimal('direct_personnel_cost_proposal', 15, 2)->default(0);
            $table->decimal('non_personnel_cost_proposal', 15, 2)->default(0);
            $table->decimal('indirect_cost_proposal', 15, 2)->default(0);
            $table->string('document_rab_proposal')->nullable();
            $table->decimal('direct_personnel_cost_fundrealization', 15, 2)->default(0);
            $table->decimal('non_personnel_cost_fundrealization', 15, 2)->default(0);
            $table->decimal('indirect_cost_fundrealization', 15, 2)->default(0);
            $table->string('document_rab_fundrealization')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });

        // 5. Table: proposal_teams (Pivot)
        Schema::create('proposal_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposals')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('role'); // Ketua, Anggota
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposal_teams');
        Schema::dropIfExists('budgets');
        Schema::dropIfExists('output_indicators');
        Schema::dropIfExists('proposals');
        Schema::dropIfExists('members');
    }
};