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
        Schema::create('family_permissions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('patient_family_member_id')
                ->constrained('patient_family_members')
                ->cascadeOnDelete();

            $table->foreignId('permission_type_id')
                ->constrained('family_permission_types')
                ->cascadeOnDelete();
            $table->unique(['patient_family_member_id', 'permission_type_id'],'family_perm_unique');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
