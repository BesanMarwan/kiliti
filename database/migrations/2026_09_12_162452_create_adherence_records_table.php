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
        Schema::create('adherence_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')
                ->constrained('patients')
                ->cascadeOnDelete();

            $table->date('date');

            $table->decimal('dialysis_score', 5, 2)->default(0);
            $table->decimal('medication_score', 5, 2)->default(0);
            $table->decimal('fluid_score', 5, 2)->default(0);
            $table->decimal('measurement_score', 5, 2)->default(0);

            $table->decimal('overall_score', 5, 2)->default(0);

            $table->timestamps();

            $table->unique(['patient_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adherence_records');
    }
};
