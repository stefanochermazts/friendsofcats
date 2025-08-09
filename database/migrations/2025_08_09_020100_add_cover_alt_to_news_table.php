<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table): void {
            $table->string('cover_alt')->nullable()->after('cover_image');
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table): void {
            $table->dropColumn('cover_alt');
        });
    }
};


