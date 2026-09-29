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
                'name' => 'ألم في الصدر',
                'description' => 'شعور بألم أو ضغط في منطقة الصدر، ويُعد من الأعراض الحرجة التي تتطلب انتباهًا طبيًا فوريًا.',
                'is_critical' => 1, // عرض حرج
                'status' => 'enabled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'دوخة أو دوار',
                'description' => 'إحساس عدم الاتزان أو الدوار الخفيف أو الشديد.',
                'is_critical' => 0,
                'status' => 'enabled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'غثيان',
                'description' => 'رغبة في القيء أو شعور بالاضطراب في المعدة.',
                'is_critical' => 0,
                'status' => 'enabled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ضيق في التنفس',
                'description' => 'صعوبة أو ضيق في التنفس، ويُعد من المؤشرات الحيوية الحرجة للمريض.',
                'is_critical' => 1, // عرض حرج
                'status' => 'enabled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ارتفاع في الحرارة',
                'description' => 'ارتفاع درجات حرارة الجسم عن المعدل الطبيعي (حمى).',
                'is_critical' => 0,
                'status' => 'enabled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ألم في الرأس',
                'description' => 'صداع أو ألم مستمر في منطقة الرأس.',
                'is_critical' => 0,
                'status' => 'enabled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'إرهاق شديد',
                'description' => 'شعور بالتعب العام والإرهاق وقلة الطاقة الجسدية.',
                'is_critical' => 0,
                'status' => 'enabled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'أخرى',
                'description' => 'أعراض أخرى غير مدرجة في القائمة.',
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
