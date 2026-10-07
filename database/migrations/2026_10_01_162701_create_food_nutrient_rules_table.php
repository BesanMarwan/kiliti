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
        Schema::create('food_nutrient_rules', function (Blueprint $table) {
            $table->id();
            $table->enum('nutrient', ['potassium', 'phosphorus', 'sodium']);

            $table->decimal('low_max', 10, 2);
            $table->decimal('moderate_max', 10, 2);

            $table->string('unit')->default('mg');

            $table->boolean('status')->default(true);

            $table->timestamps();

            $table->unique('nutrient');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_nutrient_rules');
    }
};
