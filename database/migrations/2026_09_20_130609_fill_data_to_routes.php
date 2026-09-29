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
            'name' => ['ar'=>'طرق إعطاء الدواء','en'=>'Medication Routes'],
            'uuid' => 'routes',
            'parent_id' =>0
        ]);

        $routes = [
            [
                'name' => ['en'=>'Oral', 'ar' => 'عن طريق الفم'],
                'parent_id'=>$general->id,
            ],
            [
                'name' => ['en'=>'Intravenous', 'ar' => 'وريدي'],
                'parent_id'=>$general->id,
            ],
            [
                'name' => ['en'=>'Intramuscular', 'ar' => 'حقن عضلي'],
                'parent_id'=>$general->id,
            ],
            [
                'name' => ['en'=>'Subcutaneous', 'ar' => 'تحت الجلد'],
                'parent_id'=>$general->id,
            ],
            [
                'name' => ['en'=>'Topical', 'ar' => 'موضعي'],
                'parent_id'=>$general->id,
            ],
            [
                'name' => ['en'=>'Inhalation', 'ar' => 'استنشاق'],
                'parent_id'=>$general->id,
            ],
            [
                'name' => ['en'=>'Rectal', 'ar' => 'عن طريق المستقيم'],
                'parent_id'=>$general->id,
            ],
        ];

        foreach ($routes as $route) {
            GeneralData::create(
                $route
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('routes', function (Blueprint $table) {
            //
        });
    }
};
