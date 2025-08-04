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
        Schema::create('cats', function (Blueprint $table) {
            $table->id();
            
            // Informazioni base del gatto
            $table->string('nome');
            $table->string('razza')->nullable();
            $table->integer('eta')->nullable()->comment('Età in mesi');
            $table->enum('sesso', ['maschio', 'femmina'])->nullable();
            $table->decimal('peso', 4, 2)->nullable()->comment('Peso in kg');
            $table->string('colore')->nullable();
            
            // Stato sanitario e microchip
            $table->text('stato_sanitario')->nullable();
            $table->boolean('microchip')->default(false);
            $table->string('numero_microchip')->nullable();
            $table->boolean('sterilizzazione')->default(false);
            $table->json('vaccinazioni')->nullable()->comment('Array di vaccinazioni');
            
            // Comportamento e socialità
            $table->text('comportamento')->nullable();
            $table->enum('livello_socialita', ['basso', 'medio', 'alto'])->default('medio');
            $table->text('note_comportamentali')->nullable();
            
            // Adozione
            $table->boolean('disponibile_adozione')->default(true);
            $table->date('data_arrivo')->nullable();
            $table->date('data_adozione')->nullable();
            
            // Foto
            $table->string('foto_principale')->nullable();
            $table->json('galleria_foto')->nullable()->comment('Array di foto aggiuntive');
            
            // Relazioni
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->comment('Chi gestisce il gatto');
            $table->foreignId('associazione_id')->nullable()->constrained('users')->onDelete('set null')->comment('Associazione di riferimento');
            
            $table->timestamps();
            
            // Indici per performance
            $table->index(['razza', 'disponibile_adozione']);
            $table->index(['eta', 'disponibile_adozione']);
            $table->index(['livello_socialita', 'disponibile_adozione']);
            $table->index('sterilizzazione');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cats');
    }
};
