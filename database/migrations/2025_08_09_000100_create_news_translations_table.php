<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_translations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('news_id')->constrained('news')->cascadeOnDelete();
            $table->string('locale', 5)->index();
            $table->string('title');
            $table->string('slug');
            $table->string('excerpt', 500)->nullable();
            $table->text('body');
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 255)->nullable();
            $table->unique(['news_id', 'locale']);
            $table->unique(['locale', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_translations');
    }
};


