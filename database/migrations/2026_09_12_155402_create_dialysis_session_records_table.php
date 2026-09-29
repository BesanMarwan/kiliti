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
        Schema::create('dialysis_session_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')
                ->unique()
                ->constrained('dialysis_sessions')
                ->cascadeOnDelete();

            $table->decimal('pre_weight', 6, 2)->nullable();
            $table->decimal('post_weight', 6, 2)->nullable();

            $table->unsignedSmallInteger('blood_pressure_before_systolic')->nullable();
            $table->unsignedSmallInteger('blood_pressure_before_diastolic')->nullable();

            $table->unsignedSmallInteger('blood_pressure_after_systolic')->nullable();
            $table->unsignedSmallInteger('blood_pressure_after_diastolic')->nullable();

            $table->unsignedSmallInteger('heart_rate')->nullable();

            $table->decimal('fluid_removed_ml', 8, 2)->nullable();

            $table->text('session_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dialysis_session_records');
    }
};
