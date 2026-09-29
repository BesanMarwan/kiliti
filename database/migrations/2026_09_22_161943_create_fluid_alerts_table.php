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
        Schema::create('fluid_alerts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();

            $table->date('date');

            $table->enum('type', ['approaching', 'warning', 'exceeded']);

            $table->decimal('consumed_ml', 8, 2);
            $table->decimal('limit_ml', 8, 2);

            $table->timestamps();

            $table->unique(['patient_id', 'date', 'type']); // to prevent send notification more than once
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fluid_alerts');
    }
};
