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
        Schema::table('posts', function (Blueprint $table) {
            $table->string('locale', 5)->default('it')->after('is_active');
            $table->index(['locale']);
            $table->index(['locale', 'is_active']);
        });
        
        // Popola il campo locale con la lingua dell'utente che ha creato il post
        DB::statement("
            UPDATE posts 
            SET locale = COALESCE(
                (SELECT locale FROM users WHERE users.id = posts.user_id),
                'it'
            )
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['locale']);
            $table->dropIndex(['locale', 'is_active']);
            $table->dropColumn('locale');
        });
    }
};