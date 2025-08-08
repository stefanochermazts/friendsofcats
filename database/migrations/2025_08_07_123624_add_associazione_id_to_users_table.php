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
        Schema::table('users', function (Blueprint $table) {
            // Campo per collegare volontari a un'associazione (opzionale)
            $table->unsignedBigInteger('associazione_id')->nullable()->after('association_details_completed');
            
            // Chiave esterna verso la tabella users (associazioni)
            $table->foreign('associazione_id')->references('id')->on('users')->onDelete('set null');
            
            // Indice per performance
            $table->index('associazione_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['associazione_id']);
            $table->dropIndex(['associazione_id']);
            $table->dropColumn('associazione_id');
        });
    }
};