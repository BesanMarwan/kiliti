<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GeneralCase;

class GeneralCaseSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GeneralCase::create([
            'name' =>['ar' => 'مسودة' , 'en'=> 'Draft'] ,
            'icon' => 'draft.png' ,
        ]);

        GeneralCase::create([
            'name' =>['ar' => 'جديد' , 'en'=> 'New'] ,
            'icon' => 'new.png' ,
        ]);

        GeneralCase::create([
            'name' =>['ar' => 'قيد المراجعة' , 'en'=> 'In Review'] ,
            'icon' => 'in_review.png' ,
        ]);

        GeneralCase::create([
            'name' =>['ar' => 'مؤكد' , 'en'=> 'Confirmed'] ,
            'icon' => 'confirmed.png' ,
        ]);

        GeneralCase::create([
            'name' =>['ar' => 'قيد التجهيز' , 'en'=> 'In Preparing'] ,
            'icon' => 'in_preparing.png' ,
        ]);

        GeneralCase::create([
            'name' =>['ar' => 'تم التجهيز' , 'en'=> 'Prepared'] ,
            'icon' => 'prepared.png' ,
        ]);

        GeneralCase::create([
            'name' =>['ar' => 'انتظار التوصيل' , 'en'=> 'Waiting Delivery'] ,
            'icon' => 'wait_deliver.png' ,
        ]);

        GeneralCase::create([
            'name' =>['ar' => 'قيد التوصيل' , 'en'=> 'In Delivery'] ,
            'icon' => 'in_delivery.png' ,
        ]);

        GeneralCase::create([
            'name' =>['ar' => 'تم التوصيل' , 'en'=> 'Delivered'] ,
            'icon' => 'delivered.png' ,
        ]);

        GeneralCase::create([
            'name' =>['ar' => 'تم الإلغاء' , 'en'=> 'Canceled'] ,
            'icon' => 'canceled.png' ,
        ]);
    }
}
