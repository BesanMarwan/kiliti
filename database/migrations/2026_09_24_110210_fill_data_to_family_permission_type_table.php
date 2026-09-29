<?php

use App\Enums\FamilyPermission;
use App\Models\FamilyPermissionType;
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
        $permissions = [
            [
                'name' => FamilyPermission::VIEW_MEDICATIONS->value,
                'label_ar' => 'مشاهدة الأدوية',
                'label_en' => 'View Medications',
            ],
            [
                'name' => FamilyPermission::VIEW_DIALYSIS_SESSIONS->value,
                'label_ar' => 'مشاهدة جلسات الغسيل',
                'label_en' => 'View Dialysis Sessions',
            ],
            [
                'name' => FamilyPermission::VIEW_FLUID_DATA->value,
                'label_ar' => 'مشاهدة بيانات السوائل',
                'label_en' => 'View Fluid Data',
            ],
            [
                'name' => FamilyPermission::VIEW_SYMPTOMS->value,
                'label_ar' => 'مشاهدة الأعراض',
                'label_en' => 'View Symptoms',
            ],
            [
                'name' => FamilyPermission::VIEW_LABS->value,
                'label_ar' => 'مشاهدة نتائج الفحوصات',
                'label_en' => 'View Laboratory Results',
            ],
            [
                'name' => FamilyPermission::VIEW_MEASUREMENTS->value,
                'label_ar' => 'مشاهدة القياسات',
                'label_en' => 'View Measurements',
            ],
            [
                'name' => FamilyPermission::RECEIVE_ALERTS->value,
                'label_ar' => 'استقبال التنبيهات',
                'label_en' => 'Receive Alerts',
            ],
        ];

        foreach ($permissions as $permission) {
            FamilyPermissionType::updateOrCreate(
                [
                    'name' => $permission['name'],
                ],
                [
                    'label'    => ['ar'=>$permission['label_ar'],'en'=>$permission['label_en']]
                ]
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
