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
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->text('name');

            $table->string('serving_description')->nullable();
            $table->decimal('serving_amount', 10, 2)->nullable();
            $table->string('serving_unit')->nullable();

            $table->decimal('potassium_mg', 10, 2)->nullable();
            $table->decimal('phosphorus_mg', 10, 2)->nullable();
            $table->decimal('sodium_mg', 10, 2)->nullable();

            $table->text('general_guidance')->nullable();

            $table->enum('status', ['enabled', 'disabled'])->default('enabled');

            $table->timestamps();

            $table->index('name');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
};
