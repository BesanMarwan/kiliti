<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('symptom_tips', function (Blueprint $table) {
            $table->id();

            $table->foreignId('symptom_id')->constrained('symptoms')->cascadeOnDelete();
            $table->text('title');
            $table->text('content');

            $table->enum('status', ['enabled', 'disabled',])->default('enabled');

            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->index(['symptom_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('symptom_tips');
    }
};
