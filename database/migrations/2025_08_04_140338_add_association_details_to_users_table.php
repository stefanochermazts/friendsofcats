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
            // Campi per dettagli associazione
            $table->string('ragione_sociale')->nullable();
            $table->string('indirizzo')->nullable();
            $table->string('citta')->nullable();
            $table->string('cap', 10)->nullable();
            $table->string('provincia', 3)->nullable();
            $table->string('paese')->nullable()->default('Italia');
            $table->string('telefono')->nullable();
            $table->text('descrizione')->nullable();
            $table->string('sito_web')->nullable();
            
            // Flag per verificare se l'associazione ha completato i dettagli
            $table->boolean('association_details_completed')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'ragione_sociale',
                'indirizzo', 
                'citta',
                'cap',
                'provincia',
                'paese',
                'telefono',
                'descrizione',
                'sito_web',
                'association_details_completed'
            ]);
        });
    }
};
