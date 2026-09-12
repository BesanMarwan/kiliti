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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->enum('blood_type', ['A+','A-','B+', 'B-', 'AB+', 'AB-', 'O+', 'O-',])->nullable();
            $table->string('kidney_disease_type')->nullable();

            $table->enum('dialysis_type', ['hemodialysis', 'peritoneal','other'])->nullable();
            $table->date('dialysis_start_date')->nullable();
            $table->unsignedTinyInteger('sessions_per_week')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();

            $table->text('medical_notes')->nullable();

            $table->timestamps();
        });



    }



};
