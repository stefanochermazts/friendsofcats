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
        if (DB::connection()->getDriverName() === 'pgsql') {
            // 1. Rimuovi il vincolo di controllo esistente
            DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check');
            
            // 2. Aggiorna i valori esistenti
            // Converti 'user' in 'associazione' (ruolo di default per nuovi utenti)
            DB::statement("UPDATE users SET role = 'associazione' WHERE role = 'user'");
            
            // Mantieni 'admin' per gli utenti amministratori esistenti
            // (non fare nulla per 'admin')
            
            // 3. Imposta il valore di default a NULL per forzare la selezione del ruolo
            DB::statement("ALTER TABLE users ALTER COLUMN role SET DEFAULT NULL");
            
            // 4. Aggiungi il nuovo vincolo di controllo con tutti i ruoli validi
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('associazione', 'volontario', 'proprietario', 'veterinario', 'toelettatore', 'admin'))");
        } else {
            // Per MySQL
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['associazione', 'volontario', 'proprietario', 'veterinario', 'toelettatore', 'admin'])
                      ->nullable()
                      ->change();
            });
            
            // Aggiorna i valori esistenti
            DB::statement("UPDATE users SET role = 'associazione' WHERE role = 'user'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::connection()->getDriverName() === 'pgsql') {
            // Ripristina il vincolo originale
            DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check');
            DB::statement("ALTER TABLE users ALTER COLUMN role SET DEFAULT 'user'");
            DB::statement("UPDATE users SET role = 'user' WHERE role IN ('associazione', 'volontario', 'proprietario', 'veterinario', 'toelettatore')");
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('user', 'admin'))");
        } else {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['user', 'admin'])->default('user')->change();
            });
            DB::statement("UPDATE users SET role = 'user' WHERE role IN ('associazione', 'volontario', 'proprietario', 'veterinario', 'toelettatore')");
        }
    }
};
