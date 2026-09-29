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
        Schema::create('doctor_consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained('doctors')->cascadeOnDelete();
            $table->foreignId('consultation_type')->constrained('general_data')->cascadeOnDelete();
            $table->text('message');
            $table->enum('status', ['pending', 'answered', 'closed'])->default('pending');
            $table->text('answer')->nullable();
            $table->dateTime('sent_at');
            $table->dateTime('answered_at')->nullable();
            $table->timestamps();
            $table->index(['patient_id', 'status',]);
            $table->index(['doctor_id', 'status']);
            $table->index(['sent_at',]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultation_doctors');
    }
};
