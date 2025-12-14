<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         Schema::table('proposals', function (Blueprint $table) {
        $table->decimal('total_score', 5, 2)->nullable()->after('status');
        $table->timestamp('graded_at')->nullable()->after('total_score');
    });
}

public function down()
{
    Schema::table('proposals', function (Blueprint $table) {
        $table->dropColumn(['total_score', 'graded_at']);
    });
    }
};
