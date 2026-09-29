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
        Schema::create('patient_medications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')
                ->constrained('patients')
                ->cascadeOnDelete();

            $table->foreignId('medication_id')
                ->constrained('medications')
                ->cascadeOnDelete();

            $table->string('dosage')->nullable();
            $table->string('frequency')->nullable();
            $table->string('route')->nullable();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->text('instructions')->nullable();

            $table->enum('status', ['active', 'stopped', 'completed'])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_medications');
    }
};
