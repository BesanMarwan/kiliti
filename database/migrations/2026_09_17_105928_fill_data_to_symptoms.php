<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $symptoms = [
            [
                'name' => ['ar'=>'ألم في الصدر','en'=> 'pain'],
                'description' => ['ar'=>'شعور بألم أو ضغط في منطقة الصدر، ويُعد من الأعراض الحرجة التي تتطلب انتباهًا طبيًا فوريًا.','en'=>''],
                'is_critical' => 1,
                'status' => 'enabled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => ['ar'=>'دوخة أو دوار','en'=>'dizziness'],
                'description' => ['ar'=>'إحساس عدم الاتزان أو الدوار الخفيف أو الشديد.','en'=>''],
                'is_critical' => 0,
                'status' => 'enabled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => ['ar'=>'غثيان','en'=>'nausea'],
                'description' => ['ar'=>'رغبة في القيء أو شعور بالاضطراب في المعدة.','en'=>''],
                'is_critical' => 0,
                'status' => 'enabled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => ['ar'=>'ضيق في التنفس','en'=>'shortness of breath'],
                'description' => ['ar'=>'صعوبة أو ضيق في التنفس، ويُعد من المؤشرات الحيوية الحرجة للمريض.','en'=>''],
                'is_critical' => 1,
                'status' => 'enabled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => ['ar'=>'ارتفاع في الحرارة','en'=>''],
                'description' => ['ar'=>'ارتفاع درجات حرارة الجسم عن المعدل الطبيعي (حمى).','en'=>''],
                'is_critical' => 0,
                'status' => 'enabled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => ['ar'=>'ألم في الرأس','en'=>'headache'],
                'description' =>['ar'=>'صداع أو ألم مستمر في منطقة الرأس.','en'=>''],
                'is_critical' => 0,
                'status' => 'enabled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => ['ar'=>'إرهاق شديد','en'=>'severe fatigue'],
                'description' => ['ar'=>'شعور بالتعب العام والإرهاق وقلة الطاقة الجسدية.','en'=>''],
                'is_critical' => 0,
                'status' => 'enabled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => ['ar'=>'أخرى','en'=>'Other'],
                'description' => ['ar'=>'أعراض أخرى غير مدرجة في القائمة.','en'=>''],
                'is_critical' => 0,
                'status' => 'enabled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('symptoms')->insert($symptoms);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('symptoms', function (Blueprint $table) {
            //
        });
    }
};
