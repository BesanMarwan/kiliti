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
        Schema::create('diet_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')
                ->constrained('patients')
                ->cascadeOnDelete();

            $table->enum('meal_type', ['breakfast', 'lunch', 'dinner', 'snack']);

            $table->text('description')->nullable();

            $table->decimal('calories', 8, 2)->nullable();

            $table->dateTime('recorded_at');

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['patient_id', 'recorded_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diet_logs');
    }
};
