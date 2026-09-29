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
        Schema::create('health_measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')
                ->constrained('patients')
                ->cascadeOnDelete();

            $table->enum('type', ['weight', 'blood_pressure', 'heart_rate', 'temperature', 'blood_sugar']);

            $table->decimal('value', 10, 2)->nullable();
            $table->decimal('value_secondary', 10, 2)->nullable();

            $table->string('unit')->nullable();

            $table->dateTime('measured_at');

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['patient_id', 'type', 'measured_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_measurements');
    }
};
