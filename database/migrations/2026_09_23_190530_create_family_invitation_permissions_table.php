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
        Schema::create('family_invitation_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_invitation_id')
                ->constrained('family_invitations')
                ->cascadeOnDelete();

            $table->foreignId('permission_type_id')
                ->constrained('family_permission_types')
                ->cascadeOnDelete();
            $table->unique(['family_invitation_id', 'permission_type_id'],'invite_perm_unique');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_invitation_permissions');
    }
};
