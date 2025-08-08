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
        Schema::create('cat_follows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('cat_id')->constrained()->onDelete('cascade');
            $table->boolean('notifications_enabled')->default(true);
            $table->timestamps();
            
            // Indici per performance
            $table->unique(['user_id', 'cat_id']); // Un utente può seguire un gatto una sola volta
            $table->index(['user_id']);
            $table->index(['cat_id']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_follows');
    }
};