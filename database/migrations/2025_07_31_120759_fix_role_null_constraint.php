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
            // Per PostgreSQL, dobbiamo permettere valori NULL
            DB::statement('ALTER TABLE users ALTER COLUMN role DROP NOT NULL');
            
            // Aggiorna il vincolo di controllo per permettere NULL
            DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check');
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IS NULL OR role IN ('associazione', 'volontario', 'proprietario', 'veterinario', 'toelettatore', 'admin'))");
        } else {
            // Per MySQL, modifica direttamente il tipo enum
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['associazione', 'volontario', 'proprietario', 'veterinario', 'toelettatore', 'admin'])
                      ->nullable()
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
            // Ripristina il vincolo NOT NULL
            DB::statement('ALTER TABLE users ALTER COLUMN role SET NOT NULL');
            
            // Ripristina il vincolo originale
            DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check');
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('user', 'admin'))");
        } else {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['user', 'admin'])->default('user')->change();
            });
        }
    }
};
