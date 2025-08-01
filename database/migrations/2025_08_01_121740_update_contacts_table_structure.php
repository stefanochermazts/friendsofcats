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
        Schema::table('contacts', function (Blueprint $table) {
            // Rimuovi le colonne esistenti
            $table->dropColumn(['first_name', 'last_name']);
            
            // Aggiungi la colonna name
            $table->string('name')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            // Rimuovi la colonna name
            $table->dropColumn('name');
            
            // Ripristina le colonne originali
            $table->string('first_name')->after('id');
            $table->string('last_name')->after('first_name');
        });
    }
};
