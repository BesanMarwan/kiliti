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
        Schema::create('dialysis_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')
                ->constrained('patients')
                ->cascadeOnDelete();

            $table->foreignId('center_id')
                ->constrained('dialysis_centers')
                ->cascadeOnDelete();

            $table->foreignId('doctor_id')
                ->nullable()
                ->constrained('doctors')
                ->nullOnDelete();

            $table->dateTime('scheduled_at');

            $table->dateTime('started_at')->nullable();
            $table->dateTime('ended_at')->nullable();

            $table->enum('status', ['scheduled', 'confirmed','checked_in','in_progress','completed', 'missed', 'cancelled'])->default('scheduled');

            $table->enum('session_type', ['hemodialysis', 'peritoneal', 'other'])->default('hemodialysis');

            $table->text('notes')->nullable();
            $table->text('doctor_instructions')->nullable();


            $table->timestamps();

            $table->index(['patient_id', 'scheduled_at']);
            $table->index(['center_id', 'scheduled_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dialysis_sessions');
    }
};
