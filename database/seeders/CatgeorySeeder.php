<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category ;
class CatgeorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // Category::factory()->count(60)->create();
        Category::create([
            'name' =>['ar' => 'وصل حديثا' , 'en'=> 'Recently'] ,
            'image' => '1_icon.png' ,
            'cover' => '1st.png' ,
            'parent_id' => 0,
            'status'=> 'enabled',
        ]);

        Category::create([
            'name' =>['ar' => 'المكياج' , 'en'=> 'Makeup'] ,
            'image' => '1_icon.png' ,
            'cover' => '1st.png' ,
            'parent_id' => 0,
            'status'=> 'enabled',
        ]);

        Category::create([
            'name' =>['ar' => 'العطور' , 'en'=> 'Perfume'] ,
            'image' => '1_icon.png' ,
            'cover' => '1st.png' ,
            'parent_id' => 0,
            'status'=> 'enabled',
        ]);

        Category::create([
            'name' =>['ar' => 'العدسات' , 'en'=> 'Lenses'] ,
            'image' => '1_icon.png' ,
            'cover' => '1st.png' ,
            'parent_id' => 0,
            'status'=> 'enabled',
        ]);

        Category::create([
            'name' =>['ar' => 'إكسسوارات' , 'en'=> 'Accessories'] ,
            'image' => '1_icon.png' ,
            'cover' => '1st.png' ,
            'parent_id' => 0,
            'status'=> 'enabled',
        ]);

        Category::create([
            'name' =>['ar' => 'طلاء الأظافر' , 'en'=> 'Nail Polish'] ,
            'image' => '1_icon.png' ,
            'cover' => '1st.png' ,
            'parent_id' => 0,
            'status'=> 'enabled',
        ]);

    }
}
