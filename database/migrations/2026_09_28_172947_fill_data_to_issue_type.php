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
            'name' => ['ar'=>'مشاكل جلسات الغسيل','en'=>'Dialysis Session Issue'],
            'uuid' => 'dialysis_session_issue',
            'parent_id' =>0
        ]);


        $issues = [
            [
                'name' => ['en'=>'Dizziness', 'ar' => 'دوخة أو انخفاض في الضغط'],
                'parent_id'=>$general->id
            ],
            [
                'name' => ['en'=>'Severe Fatigue', 'ar' => 'تعب شديد'],
                'parent_id'=>$general->id
            ],
            [
                'name' => ['en'=>'Nausea Pain', 'ar' => 'غثيان أو قئ'],
                'parent_id'=>$general->id
            ],
            [
                'name' => ['en'=>'Cramps', 'ar' => 'تشنجات أو ألم'],
                'parent_id'=>$general->id
            ],
            [
                'name' => ['en'=>'Machine Problem', 'ar' => 'مشكله بجهاز الغسيل '],
                'parent_id'=>$general->id
            ],

            [
                'name' => ['en'=>'Needle Problem', 'ar' => 'مشكلة بالابر'],
                'parent_id'=>$general->id
            ],
            [
                'name' => ['en'=>'Other', 'ar' => 'أدوية ضغط الدم'],
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

    }
};
