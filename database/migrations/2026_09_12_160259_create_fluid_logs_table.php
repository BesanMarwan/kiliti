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
        Schema::create('fluid_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')
                ->constrained('patients')
                ->cascadeOnDelete();

            $table->decimal('amount_ml', 8, 2);
            $table->decimal('fluid_limit', 8, 2)->default(0);
            $table->string('fluid_type')->nullable();

            $table->dateTime('recorded_at');

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['patient_id', 'recorded_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fluid_logs');
    }
};
