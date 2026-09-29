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
        Schema::create('dialysis_session_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dialysis_session_id')->constrained('dialysis_sessions')->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignId('issue_type')->constrained('general_data')->cascadeOnDelete();
//
//            $table->enum('issue_type', [
//                'dizziness',
//                'severe_fatigue',
//                'nausea_pain',
//                'cramps',
//                'machine_problem',
//                'needle_problem',
//                'other',
//            ]);

            $table->enum('severity', ['mild', 'moderate', 'severe']);
            $table->text('description')->nullable();
            $table->dateTime('reported_at');
            $table->enum('status', ['open', 'acknowledged', 'resolved'])->default('open');
            $table->timestamps();

            $table->index(['dialysis_session_id', 'reported_at']);
            $table->index(['patient_id', 'reported_at']);
            $table->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dialysis_session_issues');
    }
};
