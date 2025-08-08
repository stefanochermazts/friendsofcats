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
        Schema::table('cats', function (Blueprint $table) {
            // Aggiungiamo il nuovo campo stato con ENUM
            $table->enum('stato', ['di_proprieta', 'adottabile', 'non_adottabile', 'adottato'])
                  ->default('di_proprieta')
                  ->after('disponibile_adozione');
            
            $table->index(['stato']);
        });
        
        // Popoliamo il nuovo campo basandoci sui dati esistenti
        DB::statement("
            UPDATE cats SET stato = CASE
                WHEN data_adozione IS NOT NULL THEN 'adottato'
                WHEN disponibile_adozione = true THEN 'adottabile'
                ELSE 'di_proprieta'
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cats', function (Blueprint $table) {
            $table->dropIndex(['stato']);
            $table->dropColumn('stato');
        });
    }
};