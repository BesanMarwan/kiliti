<?php

use App\Models\FoodCategory;
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
        $categories = [[
            'name' => 'فواكه',
            'name_en' => 'fruits',
            'sort_order' => 1,
        ],
            [
                'name' => 'خضروات',
                'name_en' => 'vegetables',
                'sort_order' => 2,
            ],
            [
                'name' => 'حبوب ونشويات',
                'name_en' => 'grains_and_starches',
                'sort_order' => 3,
            ],
            [
                'name' => 'لحوم',
                'name_en' => 'meat',
                'sort_order' => 4,
            ],
            [
                'name' => 'دواجن',
                'name_en' => 'poultry',
                'sort_order' => 5,
            ],
            [
                'name' => 'أسماك ومأكولات بحرية',
                'name_en' => 'seafood',
                'sort_order' => 6,
            ],
            [
                'name' => 'ألبان ومشتقاتها',
                'name_en' => 'dairy',
                'sort_order' => 7,
            ],
            [
                'name' => 'بقوليات',
                'name_en' => 'legumes',
                'sort_order' => 8,
            ],
            [
                'name' => 'مكسرات وبذور',
                'name_en' => 'nuts_and_seeds',
                'sort_order' => 9,
            ],
            [
                'name' => 'مشروبات',
                'name_en' => 'beverages',
                'sort_order' => 10,
            ],
            [
                'name' => 'وجبات خفيفة',
                'name_en' => 'snacks',
                'sort_order' => 11,
            ],
            [
                'name' => 'حلويات',
                'name_en' => 'desserts',
                'sort_order' => 12,
            ],
            [
                'name' => 'أطعمة أخرى',
                'name_en' => 'other',
                'sort_order' => 99,
            ],
        ];

        foreach ($categories as $category) {
            FoodCategory::updateOrCreate(
                [
                    'name' => ['ar'=>$category['name'],'en'=>$category['name_en']],
                ],
                [
                    'sort_order' => $category['sort_order'],
                    'status' => 'enabled',
                ]
            );
        }
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('food_categories', function (Blueprint $table) {
            //
        });
    }
};
