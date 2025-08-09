<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('taxonomies', function (Blueprint $table): void {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 255)->nullable();
            $table->timestamps();
        });

        Schema::create('news_taxonomy', function (Blueprint $table): void {
            $table->foreignId('news_id')->constrained('news')->cascadeOnDelete();
            $table->foreignId('taxonomy_id')->constrained('taxonomies')->cascadeOnDelete();
            $table->primary(['news_id', 'taxonomy_id']);
        });

        // Seed initial taxonomies
        $items = [
            ['slug' => 'guide', 'name' => 'Guide', 'description' => 'How-to, step-by-step, checklist'],
            ['slug' => 'salute', 'name' => 'Salute', 'description' => 'Prevenzione, sintomi, quando chiamare il veterinario'],
            ['slug' => 'alimentazione', 'name' => 'Alimentazione', 'description' => 'Diete, porzioni, etichette, alimenti consentiti/vietati'],
            ['slug' => 'comportamento', 'name' => 'Comportamento', 'description' => 'Socializzazione, gioco, arricchimento'],
            ['slug' => 'cura', 'name' => 'Cura', 'description' => 'Igiene, lettiera, toelettatura, viaggio'],
            ['slug' => 'adozioni', 'name' => 'Adozioni', 'description' => 'Procedure, requisiti, integrazione in famiglia'],
            ['slug' => 'razze', 'name' => 'Razze', 'description' => 'Schede razza standardizzate'],
            ['slug' => 'curiosita', 'name' => 'Curiosità', 'description' => 'Miti da sfatare, cultura pop, ricorrenze'],
        ];
        foreach ($items as $it) {
            \DB::table('taxonomies')->insert(array_merge($it, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('news_taxonomy');
        Schema::dropIfExists('taxonomies');
    }
};


