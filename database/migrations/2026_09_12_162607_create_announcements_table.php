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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')
                ->constrained('admins')
                ->cascadeOnDelete();

            $table->string('title');
            $table->text('content');

            $table->enum('priority', ['normal', 'important', 'urgent'])->default('normal');

            $table->enum('target_type', ['all', 'patients', 'doctors', 'family', 'center', 'user'])->default('all');

            $table->foreignId('target_center_id')
                ->nullable()
                ->constrained('dialysis_centers')
                ->nullOnDelete();

            $table->foreignId('target_user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->boolean('send_notification')->default(true);

            $table->dateTime('published_at')->nullable();
            $table->dateTime('expires_at')->nullable();

            $table->enum('status', ['draft','published', 'archived'])->default('draft');

            $table->timestamps();

            $table->index(['status', 'published_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
