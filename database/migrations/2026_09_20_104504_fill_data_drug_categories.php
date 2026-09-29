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
                'name' => ['ar'=>'أقسام الأدوية','en'=>'Drug Categories'],
                'uuid' => 'drug_categories',
                'parent_id' =>0
            ]);

        $categories = [
            [
                'name' => ['en'=>'Blood Pressure Medications', 'ar' => 'أدوية ضغط الدم'],
                'parent_id'=>$general->id
            ],
            [
                'name' => ['en'=>'Diabetes Medications', 'ar' => 'أدوية السكري'],
                'parent_id'=>$general->id
            ],
            [
                'name' => ['en'=>'Anemia Medications', 'ar' => 'أدوية فقر الدم'],
                'parent_id'=>$general->id
            ],
            [
                'name' => ['en'=>'Phosphate Binders', 'ar' => 'رابطات الفوسفات'],
                'parent_id'=>$general->id
            ],
            [
                'name' => ['en'=>'Vitamin D Supplements', 'ar' => 'مكملات فيتامين د'],
                'parent_id'=>$general->id
            ],
            [
                'name' => ['en'=>'Iron Supplements', 'ar' => 'مكملات الحديد'],
                'parent_id'=>$general->id
            ],
            [
                'name' => ['en'=>'Pain Relievers', 'ar' => 'مسكنات الألم'],
                'parent_id'=>$general->id
            ],
            [
                'name' => ['en'=>'Antibiotics', 'ar' => 'المضادات الحيوية'],
                'parent_id'=>$general->id
            ],
            [
                'name' => ['en'=>'Anticoagulants', 'ar' => 'مضادات التخثر'],
                'parent_id'=>$general->id
            ],
            [
                'name' => ['en'=>'Diuretics', 'ar' => 'مدرات البول'],
                'parent_id'=>$general->id
            ],
            [
                'name' => ['en'=>'Cholesterol Medications', 'ar' => 'أدوية الكوليسترول'],
                'parent_id'=>$general->id
            ],
            [
                'name' => ['en'=>'Gastrointestinal Medications', 'ar' => 'أدوية الجهاز الهضمي'],
                'parent_id'=>$general->id
            ],
            [
                'name' => ['en'=>'Electrolyte Medications', 'ar' => 'أدوية اضطرابات الأملاح'],
                'parent_id'=>$general->id
            ],
            [
                'name' => ['en'=>'Kidney Disease Medications', 'ar' => 'أدوية أمراض الكلى'],
                'parent_id'=>$general->id
            ],
            [
                'name' => ['en'=>'Other', 'ar' => 'أخرى'],
                'parent_id'=>$general->id
            ]];

        foreach ($categories as $category) {
            GeneralData::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
