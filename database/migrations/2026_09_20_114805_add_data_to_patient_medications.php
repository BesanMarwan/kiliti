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
        Schema::table('patient_medications', function (Blueprint $table) {
            $table->json('reminder_times')->nullable(); // ["08:00","20:00"]
            $table->boolean('reminder_enabled')->default(1);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_medications', function (Blueprint $table) {
            //
        });
    }
};
