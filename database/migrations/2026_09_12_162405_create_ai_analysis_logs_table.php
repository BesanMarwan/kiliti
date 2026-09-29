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
        Schema::create('ai_analysis_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')
                ->constrained('patients')
                ->cascadeOnDelete();

            $table->string('analysis_type');

            $table->json('input_data')->nullable();
            $table->json('result')->nullable();

            $table->decimal('confidence', 5, 2)->nullable();

            $table->timestamps();

            $table->index(['patient_id', 'analysis_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_analysis_logs');
    }
};
