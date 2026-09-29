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
        Schema::create('diet_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')
                ->constrained('patients')
                ->cascadeOnDelete();

            $table->foreignId('doctor_id')
                ->nullable()
                ->constrained('doctors')
                ->nullOnDelete();

            $table->string('title');
            $table->text('description')->nullable();

            $table->decimal('daily_fluid_limit', 8, 2)->nullable();
            $table->decimal('daily_sodium_limit', 8, 2)->nullable();
            $table->decimal('daily_potassium_limit', 8, 2)->nullable();
            $table->decimal('daily_phosphorus_limit', 8, 2)->nullable();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->enum('status', ['active', 'inactive', 'completed'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diet_plans');
    }
};
