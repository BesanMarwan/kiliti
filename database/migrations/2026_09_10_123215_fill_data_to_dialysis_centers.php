<?php

use App\Models\DialysisCenter;
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
        $centers = [
            [
                'name' => 'مجمع الشفاء الطبي - قسم غسيل الكلى',
                'phone' => null,
                'governorate' => 'غزة',
                'city' => 'غزة',
                'address' => 'شارع الجلاء، مدينة غزة',
                'total_machines' => null,
                'working_machines' => null,
                'status' => 'enabled',
            ],
            [
                'name' => 'مجمع ناصر الطبي - مركز غسيل الكلى',
                'phone' => null,
                'governorate' => 'خان يونس',
                'city' => 'خان يونس',
                'address' => 'شارع جمال عبد الناصر، خان يونس',
                'total_machines' => null,
                'working_machines' => null,
                'status' => 'enabled',
            ],
            [
                'name' => 'مستشفى شهداء الأقصى - قسم غسيل الكلى',
                'phone' => null,
                'governorate' => 'دير البلح',
                'city' => 'دير البلح',
                'address' => 'الوسطى، دير البلح',
                'total_machines' => null,
                'working_machines' => null,
                'status' => 'enabled',
            ],
            [
                'name' => 'مستشفى أبو يوسف النجار - قسم غسيل الكلى',
                'phone' => null,
                'governorate' => 'رفح',
                'city' => 'رفح',
                'address' => 'رفح، جنوب القطاع',
                'total_machines' => rand(20,50),
                'working_machines' => rand(10,40),
                'status' => 'enabled',
            ],
            [
                'name' => 'مستشفى الإندونيسي - قسم غسيل الكلى',
                'phone' => null,
                'governorate' => 'الشمال',
                'city' => 'بيت لاهيا',
                'address' => 'مشروع بيت لاهيا، شمال القطاع',
                'total_machines' => rand(20,50),
                'working_machines' => rand(10,50),
                'status' => 'enabled',
            ],
            [
                'name' => 'مستشفى العودة - قسم غسيل الكلى',
                'phone' => null,
                'governorate' => 'الشمال',
                'city' => 'جباليا',
                'address' => 'تل الزعتر، جباليا',
                'total_machines' => rand(20,50),
                'working_machines' => rand(10,40),
                'status' => 'enabled',
            ],
        ];
        foreach ($centers as $center) {
            DialysisCenter::create($center);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
