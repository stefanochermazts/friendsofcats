<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Per PostgreSQL, dobbiamo ricreare il tipo enum
        if (DB::connection()->getDriverName() === 'pgsql') {
            // Rimuovi il vincolo di controllo esistente
            DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check');
            
            // Aggiorna i valori esistenti 'user' e 'admin' ai nuovi valori
            DB::statement("UPDATE users SET role = 'associazione' WHERE role = 'user'");
            DB::statement("UPDATE users SET role = 'associazione' WHERE role = 'admin'");
            
            // Aggiungi il nuovo vincolo di controllo con i nuovi valori
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('associazione', 'volontario', 'proprietario', 'veterinario', 'toelettatore'))");
        } else {
            // Per MySQL, modifica direttamente il tipo enum
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['associazione', 'volontario', 'proprietario', 'veterinario', 'toelettatore'])
                      ->default('associazione')
                      ->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::connection()->getDriverName() === 'pgsql') {
            // Rimuovi il vincolo di controllo
            DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check');
            
            // Ripristina i valori originali
            DB::statement("UPDATE users SET role = 'user' WHERE role IN ('associazione', 'volontario', 'proprietario', 'veterinario', 'toelettatore')");
            
            // Aggiungi il vincolo originale
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('user', 'admin'))");
        } else {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['user', 'admin'])->default('user')->change();
            });
        }
    }
};
