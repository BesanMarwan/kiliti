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
        Schema::create('patient_centers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignId('center_id')->constrained('dialysis_centers')->cascadeOnDelete();
            $table->enum('status', ['enabled','disabled'])->default('enabled');

            $table->date('started_at')->nullable();
            $table->date('ended_at')->nullable();

            $table->timestamps();

            $table->unique(['patient_id', 'center_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_centers');
    }
};
