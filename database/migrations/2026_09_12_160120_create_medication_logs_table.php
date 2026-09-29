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
        Schema::create('medication_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_medication_id')
                ->constrained('patient_medications')
                ->cascadeOnDelete();

            $table->dateTime('scheduled_at');
            $table->dateTime('taken_at')->nullable();

            $table->enum('status', ['pending','taken','snoozed', 'missed', 'skipped'])->default('pending');

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['patient_medication_id', 'scheduled_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medication_logs');
    }
};
