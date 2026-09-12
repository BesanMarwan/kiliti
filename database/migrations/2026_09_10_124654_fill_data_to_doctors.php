<?php

use App\Models\DialysisCenter;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $centers = DialysisCenter::all();
        $doctors = [
            [
                'name' => 'د. أحمد السقا',
                'email' => 'ahmed.doctor@example.com',
                'mobile' => '0599000001',
                'specialization' => 'Nephrology',
                'license_number' => 'DOC-0001',
                'center_index' => 0,
            ],
            [
                'name' => 'د. ريم ابو العطا',
                'email' => 'reem.doctor@example.com',
                'mobile' => '0599000002',
                'specialization' => 'Nephrology',
                'license_number' => 'DOC-0002',
                'center_index' => 1,
            ],
            [
                'name' => 'د. محمد الخطيب',
                'email' => 'mohammad.doctor@example.com',
                'mobile' => '0599000003',
                'specialization' => 'Internal Medicine',
                'license_number' => 'DOC-0003',
                'center_index' => 2,
            ],
        ];

        foreach ($doctors as $doctorData) {

            $center = $centers->get($doctorData['center_index'])
                ?? $centers->first();

            $user = User::create([
                'name' => $doctorData['name'],
                'email' => $doctorData['email'],
                'mobile' => $doctorData['mobile'],
                'password' => Hash::make('password'),
                'status' => 'enabled',
                'role' => 'doctor',
                'language' => 'ar',
                'register_step' => 'finish',
                'is_register_end' => true,
            ]);

            Doctor::create([
                'user_id' => $user->id,
                'dialysis_center_id' => $center->id,
                'specialization' => $doctorData['specialization'],
                'license_number' => $doctorData['license_number'],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            //
        });
    }
};
