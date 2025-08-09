<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // news.excerpt -> text
        Schema::table('news', function (Blueprint $table): void {
            // For PostgreSQL / MySQL compatible change
            $table->text('excerpt')->nullable()->change();
        });

        // news_translations.excerpt -> text
        Schema::table('news_translations', function (Blueprint $table): void {
            $table->text('excerpt')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Revert back to string(500)
        Schema::table('news', function (Blueprint $table): void {
            $table->string('excerpt', 500)->nullable()->change();
        });

        Schema::table('news_translations', function (Blueprint $table): void {
            $table->string('excerpt', 500)->nullable()->change();
        });
    }
};


