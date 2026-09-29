<?php

use App\Models\GeneralData;
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
        $general = GeneralData::create([
            'name' => ['ar'=>'أنواع الاستشارة','en'=>'Consultation Type'],
            'uuid' => 'consultation_type',
            'parent_id' =>0
        ]);

        $issues = [
            [
                'name' => ['en'=>'Health Inquiry', 'ar' => 'استفسار صحي'],
                'parent_id'=>$general->id
            ],
            [
                'name' => ['en'=>'Medication Inquiry', 'ar' => 'استفسار عن دواء'],
                'parent_id'=>$general->id
            ],
            [
                'name' => ['en'=>'Appointment Inquiry', 'ar' => 'استفسار عن موعد'],
                'parent_id'=>$general->id
            ],
            [
                'name' => ['en'=>'Lab Results', 'ar' => 'سؤال عن نتائج الفحوصات'],
                'parent_id'=>$general->id
            ],
            [
                'name' => ['en'=>'Other', 'ar' => 'أخرى'],
                'parent_id'=>$general->id
            ],
        ];

        foreach ($issues as $issue) {
            GeneralData::updateOrCreate(
                ['name' => $issue['name']],
                $issue
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultation_type', function (Blueprint $table) {
            //
        });
    }
};
