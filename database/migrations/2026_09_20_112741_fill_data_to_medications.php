<?php

use App\Models\GeneralData;
use App\Models\Medication;
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
        $drugs = [
            [
                'name' => ['en'=>'Paracetamol', 'ar' => 'باراسيتامول'],
                'description' => ['en'=>'Pain reliever and fever reducer.', 'ar' => 'مسكن للألم وخافض للحرارة.'],
                'important_alert' => 'Do not exceed the recommended daily dose. Use with caution in patients with liver disease.',
                'important_alert_ar' => 'لا تتجاوز الجرعة اليومية الموصى بها. يستخدم بحذر لدى المرضى الذين يعانون من أمراض الكبد.',
                'category' => 'Pain Relievers',
            ],

            [
                'name' =>['en'=>'Amlodipine', 'ar' => 'أملوديبين'],
                'description' => ['en'=>'Medication used to treat high blood pressure.', 'ar' => 'دواء يستخدم لعلاج ارتفاع ضغط الدم.'],
                'important_alert' => 'Monitor blood pressure regularly. May cause dizziness or swelling in the ankles.',
                'important_alert_ar' => 'يجب مراقبة ضغط الدم بانتظام. قد يسبب الدوخة أو تورم الكاحلين.',
                'category' => 'Blood Pressure Medications',
            ],

            [
                'name' => ['en'=>'Losartan', 'ar' => 'لوسارتان'],
                'description' => ['en'=>'Medication used to control high blood pressure.', 'ar' => 'دواء يستخدم للتحكم في ارتفاع ضغط الدم.'],
                'important_alert' => 'Monitor blood pressure and potassium levels according to the doctor’s instructions.',
                'important_alert_ar' => 'يجب مراقبة ضغط الدم ومستويات البوتاسيوم وفقًا لتعليمات الطبيب.',
                'category' => 'Blood Pressure Medications',
            ],

            [
                'name' => ['en'=>'Insulin', 'ar' => 'الإنسولين'],
                'description' => ['en'=>'Medication used to control blood glucose levels.', 'ar' => 'دواء يستخدم للتحكم في مستويات السكر في الدم.'],
                'important_alert' => 'May cause low blood sugar. Blood glucose should be monitored regularly.',
                'important_alert_ar' => 'قد يسبب انخفاض مستوى السكر في الدم. يجب مراقبة مستوى السكر بانتظام.',
                'category' => 'Diabetes Medications',
            ],

            [
                'name' => ['en'=>'Erythropoietin', 'ar' => 'إريثروبويتين'],
                'description' => ['en'=>'Medication used to treat anemia associated with chronic kidney disease.', 'ar' => 'دواء يستخدم لعلاج فقر الدم المرتبط بمرض الكلى المزمن.'],
                'important_alert' => 'Blood pressure and hemoglobin levels should be monitored regularly.',
                'important_alert_ar' => 'يجب مراقبة ضغط الدم ومستويات الهيموغلوبين بانتظام.',
                'category' => 'Anemia Medications',
            ],

            [
                'name' => ['en'=>'Sevelamer', 'ar' => 'سيفيلامير'],
                'description' => ['en'=>'Phosphate binder used to control high phosphate levels in patients with kidney disease.', 'ar' => 'دواء رابط للفوسفات يستخدم للتحكم في ارتفاع مستويات الفوسفات لدى مرضى الكلى.'],
                'important_alert' => 'Should be taken with meals and according to the prescribed dose.',
                'important_alert_ar' => 'يجب تناوله مع الوجبات ووفقًا للجرعة التي يحددها الطبيب.',
                'category' => 'Phosphate Binders',
            ],

            [
                'name' => ['en'=>'Calcium Carbonate', 'ar' => 'كربونات الكالسيوم'],
                'description' => ['en'=>'Used as a phosphate binder and calcium supplement.', 'ar' => 'يستخدم كرابط للفوسفات ومكمل للكالسيوم.'],
                'important_alert' => 'Do not exceed the prescribed dose. Calcium levels should be monitored.',
                'important_alert_ar' => 'لا تتجاوز الجرعة الموصوفة. يجب مراقبة مستويات الكالسيوم.',
                'category' => 'Phosphate Binders',
            ],

            [
                'name' => ['en'=>'Vitamin D3', 'ar' => 'فيتامين د3'],
                'description' => ['en'=>'Vitamin D supplement that supports bone health and calcium metabolism.', 'ar' => 'مكمل لفيتامين د يساعد في دعم صحة العظام وتنظيم أيض الكالسيوم.'],
                'important_alert' => 'Use according to the prescribed dose. Excessive intake may increase calcium levels.',
                'important_alert_ar' => 'يستخدم وفقًا للجرعة الموصوفة. الإفراط في تناوله قد يؤدي إلى ارتفاع مستويات الكالسيوم.',
                'category' => 'Vitamin D Supplements',
            ],

            [
                'name' => ['en'=>'Ferrous Sulfate', 'ar' => 'كبريتات الحديدوز'],
                'description' => ['en'=>'Iron supplement used to prevent or treat iron deficiency anemia.', 'ar' => 'مكمل للحديد يستخدم للوقاية من فقر الدم الناتج عن نقص الحديد أو علاجه.'],
                'important_alert' => 'May cause constipation, stomach discomfort, or nausea.',
                'important_alert_ar' => 'قد يسبب الإمساك أو اضطراب المعدة أو الغثيان.',
                'category' => 'Iron Supplements',
            ],

            [
                'name' => ['en'=>'Warfarin', 'ar' => 'وارفارين'],
                'description' => ['en'=>'Anticoagulant medication used to prevent blood clots.', 'ar' => 'دواء مضاد للتخثر يستخدم للوقاية من الجلطات الدموية.'],
                'important_alert' => 'Requires regular blood tests. May increase the risk of bleeding.',
                'important_alert_ar' => 'يحتاج إلى فحوصات دم منتظمة وقد يزيد من خطر النزيف.',
                'category' => 'Anticoagulants',
            ],

            [
                'name' => ['en'=>'Furosemide', 'ar' => 'فوروسيميد'],
                'description' => ['en'=>'Diuretic medication used to reduce excess fluid in the body.', 'ar' => 'دواء مدر للبول يستخدم لتقليل السوائل الزائدة في الجسم.'],
                'important_alert' => 'Fluid balance and electrolyte levels should be monitored according to medical advice.',
                'important_alert_ar' => 'يجب مراقبة توازن السوائل ومستويات الأملاح وفقًا للإرشادات الطبية.',
                'category' => 'Diuretics',
            ],

            [
                'name' => ['en'=>'Atorvastatin', 'ar' => 'أتورفاستاتين'],
                'description' => ['en'=>'Medication used to reduce cholesterol levels.', 'ar' => 'دواء يستخدم لخفض مستويات الكوليسترول في الدم.'],
                'important_alert' => 'Report unexplained muscle pain or weakness to the doctor.',
                'important_alert_ar' => 'يجب إبلاغ الطبيب عند حدوث ألم أو ضعف غير مبرر في العضلات.',
                'category' => 'Cholesterol Medications',
            ],

            [
                'name' => ['en'=>'Omeprazole', 'ar' => 'أوميبرازول'],
                'description' => ['en'=>'Medication used to reduce stomach acid.', 'ar' => 'دواء يستخدم لتقليل حمض المعدة.'],
                'important_alert' => 'Use according to the prescribed dose and duration.',
                'important_alert_ar' => 'يستخدم وفقًا للجرعة والمدة التي يحددها الطبيب.',
                'category' => 'Gastrointestinal Medications',
            ],

            [
                'name' => ['en'=>'Amoxicillin', 'ar' => 'أموكسيسيلين'],
                'description' => ['en'=>'Antibiotic used to treat certain bacterial infections.', 'ar' => 'مضاد حيوي يستخدم لعلاج بعض أنواع العدوى البكتيرية.'],
                'important_alert' => 'Use only when prescribed by a healthcare professional.',
                'important_alert_ar' => 'يستخدم فقط عند وصفه من قبل الطبيب أو المختص الصحي.',
                'category' => 'Antibiotics',
            ],
        ];

        foreach ($drugs as $drug) {
            $category = GeneralData::where('name->en', $drug['category'])->first();

            if (!$category) {
                continue;
            }

            Medication::create(
                [
                    'name' => $drug['name'],
                    'description' => $drug['description'],
                    'important_alert' => ['en'=>$drug['important_alert'],'ar' => $drug['important_alert_ar']],
                    'category_id' => $category->id,
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medications', function (Blueprint $table) {
            //
        });
    }
};
