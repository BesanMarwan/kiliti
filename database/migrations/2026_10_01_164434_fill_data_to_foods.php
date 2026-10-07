<?php

use App\Models\Food;
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

                $foods = [

                    /*
                    |--------------------------------------------------------------------------
                    | Fruits
                    |--------------------------------------------------------------------------
                    */

                    [
                        'name' => 'موز',
                        'name_en' => 'banana',
                        'category' => 'fruits',

                        'serving_description' => 'حبة متوسطة',
                        'serving_amount' => 118,
                        'serving_unit' => 'g',

                        'potassium_mg' => 422,
                        'phosphorus_mg' => 26,
                        'sodium_mg' => 1,

                        'general_guidance' =>
                            'الموز يحتوي على كمية مرتفعة نسبيًا من البوتاسيوم. إذا كان لديك تقييد للبوتاسيوم، ناقش الكمية المناسبة مع الطبيب أو أخصائي التغذية.',
                    ],

                    [
                        'name' => 'تفاح',
                        'name_en' => 'apple',
                        'category' => 'fruits',

                        'serving_description' => 'حبة متوسطة',
                        'serving_amount' => 182,
                        'serving_unit' => 'g',

                        'potassium_mg' => 195,
                        'phosphorus_mg' => 20,
                        'sodium_mg' => 2,

                        'general_guidance' =>
                            'التفاح يحتوي على كمية أقل من البوتاسيوم مقارنة ببعض الفواكه الأخرى.',
                    ],

                    [
                        'name' => 'فراولة',
                        'name_en' => 'strawberries',
                        'category' => 'fruits',

                        'serving_description' => 'كوب واحد',
                        'serving_amount' => 152,
                        'serving_unit' => 'g',

                        'potassium_mg' => 233,
                        'phosphorus_mg' => 36,
                        'sodium_mg' => 2,

                        'general_guidance' =>
                            'الفراولة مصدر للفواكه ويمكن أن تكون خيارًا مناسبًا ضمن الخطة الغذائية المحددة للمريض.',
                    ],

                    [
                        'name' => 'عنب',
                        'name_en' => 'grapes',
                        'category' => 'fruits',

                        'serving_description' => 'كوب واحد',
                        'serving_amount' => 151,
                        'serving_unit' => 'g',

                        'potassium_mg' => 288,
                        'phosphorus_mg' => 30,
                        'sodium_mg' => 3,

                        'general_guidance' =>
                            'يمكن تناول العنب ضمن الكمية التي تتناسب مع الخطة الغذائية للمريض.',
                    ],

                    /*
                    |--------------------------------------------------------------------------
                    | Vegetables
                    |--------------------------------------------------------------------------
                    */

                    [
                        'name' => 'خيار',
                        'name_en' => 'cucumber',
                        'category' => 'vegetables',

                        'serving_description' => 'كوب شرائح',
                        'serving_amount' => 104,
                        'serving_unit' => 'g',

                        'potassium_mg' => 147,
                        'phosphorus_mg' => 17,
                        'sodium_mg' => 2,

                        'general_guidance' =>
                            'الخيار يحتوي على كمية منخفضة نسبيًا من الصوديوم والفوسفور.',
                    ],

                    [
                        'name' => 'خس',
                        'name_en' => 'lettuce',
                        'category' => 'vegetables',

                        'serving_description' => 'كوب مقطع',
                        'serving_amount' => 47,
                        'serving_unit' => 'g',

                        'potassium_mg' => 70,
                        'phosphorus_mg' => 13,
                        'sodium_mg' => 28,

                        'general_guidance' =>
                            'الخس يحتوي على كميات منخفضة نسبيًا من البوتاسيوم والفوسفور.',
                    ],

                    [
                        'name' => 'جزر',
                        'name_en' => 'carrots',
                        'category' => 'vegetables',

                        'serving_description' => 'حبة متوسطة',
                        'serving_amount' => 61,
                        'serving_unit' => 'g',

                        'potassium_mg' => 195,
                        'phosphorus_mg' => 20,
                        'sodium_mg' => 42,

                        'general_guidance' =>
                            'يمكن إدخال الجزر ضمن النظام الغذائي وفق احتياجات المريض وتوصيات الطبيب أو أخصائي التغذية.',
                    ],

                    /*
                    |--------------------------------------------------------------------------
                    | Grains & Starches
                    |--------------------------------------------------------------------------
                    */

                    [
                        'name' => 'أرز أبيض مطبوخ',
                        'name_en' => 'cooked white rice',
                        'category' => 'grains_and_starches',

                        'serving_description' => 'كوب واحد',
                        'serving_amount' => 158,
                        'serving_unit' => 'g',

                        'potassium_mg' => 84,
                        'phosphorus_mg' => 68,
                        'sodium_mg' => 0,

                        'general_guidance' =>
                            'الأرز الأبيض المطبوخ يحتوي على كمية منخفضة نسبيًا من البوتاسيوم والصوديوم.',
                    ],

                    [
                        'name' => 'خبز أبيض',
                        'name_en' => 'white bread',
                        'category' => 'grains_and_starches',

                        'serving_description' => 'شريحة واحدة',
                        'serving_amount' => 25,
                        'serving_unit' => 'g',

                        'potassium_mg' => 30,
                        'phosphorus_mg' => 25,
                        'sodium_mg' => 148,

                        'general_guidance' =>
                            'يجب الانتباه إلى كمية الصوديوم حسب نوع الخبز والكمية المتناولة.',
                    ],

                    [
                        'name' => 'معكرونة مطبوخة',
                        'name_en' => 'cooked pasta',
                        'category' => 'grains_and_starches',

                        'serving_description' => 'كوب واحد',
                        'serving_amount' => 140,
                        'serving_unit' => 'g',

                        'potassium_mg' => 44,
                        'phosphorus_mg' => 62,
                        'sodium_mg' => 1,

                        'general_guidance' =>
                            'المعكرونة المطبوخة تحتوي على كمية منخفضة نسبيًا من الصوديوم عند تحضيرها دون إضافة ملح.',
                    ],

                    /*
                    |--------------------------------------------------------------------------
                    | Poultry
                    |--------------------------------------------------------------------------
                    */

                    [
                        'name' => 'دجاج مشوي',
                        'name_en' => 'grilled chicken',
                        'category' => 'poultry',

                        'serving_description' => 'صدر دجاج مطبوخ',
                        'serving_amount' => 100,
                        'serving_unit' => 'g',

                        'potassium_mg' => 256,
                        'phosphorus_mg' => 180,
                        'sodium_mg' => 74,

                        'general_guidance' =>
                            'الدجاج مصدر للبروتين، وتختلف كمية الصوديوم والفوسفور حسب طريقة التحضير والإضافات.',
                    ],

                    [
                        'name' => 'صدر دجاج مسلوق',
                        'name_en' => 'boiled chicken breast',
                        'category' => 'poultry',

                        'serving_description' => 'صدر دجاج مطبوخ',
                        'serving_amount' => 100,
                        'serving_unit' => 'g',

                        'potassium_mg' => 256,
                        'phosphorus_mg' => 180,
                        'sodium_mg' => 74,

                        'general_guidance' =>
                            'يجب مراعاة الكمية وطريقة التحضير ضمن الخطة الغذائية الخاصة بالمريض.',
                    ],

                    /*
                    |--------------------------------------------------------------------------
                    | Meat
                    |--------------------------------------------------------------------------
                    */

                    [
                        'name' => 'لحم بقري مطبوخ',
                        'name_en' => 'cooked beef',
                        'category' => 'meat',

                        'serving_description' => '100 غرام',
                        'serving_amount' => 100,
                        'serving_unit' => 'g',

                        'potassium_mg' => 318,
                        'phosphorus_mg' => 180,
                        'sodium_mg' => 72,

                        'general_guidance' =>
                            'اللحوم مصدر للبروتين والفوسفور، وتختلف القيم حسب القطعة وطريقة التحضير.',
                    ],

                    /*
                    |--------------------------------------------------------------------------
                    | Seafood
                    |--------------------------------------------------------------------------
                    */

                    [
                        'name' => 'سمك مشوي',
                        'name_en' => 'grilled fish',
                        'category' => 'seafood',

                        'serving_description' => '100 غرام',
                        'serving_amount' => 100,
                        'serving_unit' => 'g',

                        'potassium_mg' => 384,
                        'phosphorus_mg' => 200,
                        'sodium_mg' => 59,

                        'general_guidance' =>
                            'تختلف كمية البوتاسيوم والفوسفور والصوديوم حسب نوع السمك وطريقة تحضيره.',
                    ],

                    /*
                    |--------------------------------------------------------------------------
                    | Dairy
                    |--------------------------------------------------------------------------
                    */

                    [
                        'name' => 'حليب كامل الدسم',
                        'name_en' => 'whole milk',
                        'category' => 'dairy',

                        'serving_description' => 'كوب واحد',
                        'serving_amount' => 244,
                        'serving_unit' => 'ml',

                        'potassium_mg' => 366,
                        'phosphorus_mg' => 205,
                        'sodium_mg' => 107,

                        'general_guidance' =>
                            'الحليب يحتوي على البوتاسيوم والفوسفور، لذلك يجب مراعاة الكمية ضمن الخطة الغذائية.',
                    ],

                    [
                        'name' => 'زبادي',
                        'name_en' => 'yogurt',
                        'category' => 'dairy',

                        'serving_description' => 'كوب واحد',
                        'serving_amount' => 245,
                        'serving_unit' => 'g',

                        'potassium_mg' => 380,
                        'phosphorus_mg' => 233,
                        'sodium_mg' => 113,

                        'general_guidance' =>
                            'الزبادي يحتوي على الفوسفور والبوتاسيوم، وتختلف القيم حسب النوع والإضافات.',
                    ],

                    /*
                    |--------------------------------------------------------------------------
                    | Legumes
                    |--------------------------------------------------------------------------
                    */

                    [
                        'name' => 'عدس مطبوخ',
                        'name_en' => 'cooked lentils',
                        'category' => 'legumes',

                        'serving_description' => 'كوب واحد',
                        'serving_amount' => 198,
                        'serving_unit' => 'g',

                        'potassium_mg' => 731,
                        'phosphorus_mg' => 356,
                        'sodium_mg' => 4,

                        'general_guidance' =>
                            'العدس يحتوي على كمية مرتفعة من البوتاسيوم والفوسفور نسبيًا.',
                    ],

                    /*
                    |--------------------------------------------------------------------------
                    | Nuts & Seeds
                    |--------------------------------------------------------------------------
                    */

                    [
                        'name' => 'لوز',
                        'name_en' => 'almonds',
                        'category' => 'nuts_and_seeds',

                        'serving_description' => 'حفنة صغيرة',
                        'serving_amount' => 28,
                        'serving_unit' => 'g',

                        'potassium_mg' => 208,
                        'phosphorus_mg' => 136,
                        'sodium_mg' => 0,

                        'general_guidance' =>
                            'المكسرات تحتوي على الفوسفور والبوتاسيوم، لذلك يجب الانتباه إلى حجم الحصة.',
                    ],

                    /*
                    |--------------------------------------------------------------------------
                    | Beverages
                    |--------------------------------------------------------------------------
                    */

                    [
                        'name' => 'ماء',
                        'name_en' => 'water',
                        'category' => 'beverages',

                        'serving_description' => 'كوب واحد',
                        'serving_amount' => 240,
                        'serving_unit' => 'ml',

                        'potassium_mg' => 0,
                        'phosphorus_mg' => 0,
                        'sodium_mg' => 0,

                        'general_guidance' =>
                            'كمية السوائل اليومية يجب أن تتوافق مع الحد المحدد للمريض من قبل الطبيب أو الفريق الطبي.',
                    ],

                    /*
                    |--------------------------------------------------------------------------
                    | Snacks
                    |--------------------------------------------------------------------------
                    */

                    [
                        'name' => 'فشار بدون ملح',
                        'name_en' => 'unsalted popcorn',
                        'category' => 'snacks',

                        'serving_description' => '3 أكواب',
                        'serving_amount' => 24,
                        'serving_unit' => 'g',

                        'potassium_mg' => 78,
                        'phosphorus_mg' => 93,
                        'sodium_mg' => 2,

                        'general_guidance' =>
                            'الفشار بدون إضافة الملح يحتوي على كمية منخفضة من الصوديوم مقارنة بالفشار المملح.',
                    ],

                    /*
                    |--------------------------------------------------------------------------
                    | Desserts
                    |--------------------------------------------------------------------------
                    */

                    [
                        'name' => 'بسكويت سادة',
                        'name_en' => 'plain biscuits',
                        'category' => 'desserts',

                        'serving_description' => 'قطعتان',
                        'serving_amount' => 20,
                        'serving_unit' => 'g',

                        'potassium_mg' => 35,
                        'phosphorus_mg' => 50,
                        'sodium_mg' => 80,

                        'general_guidance' =>
                            'تختلف القيم الغذائية حسب نوع البسكويت والمكونات المستخدمة في تصنيعه.',
                    ],
                ];

                foreach ($foods as $data) {

                    $category = FoodCategory::query()
                        ->where('name->en', $data['category'])
                        ->where('status', 'enabled')
                        ->firstOrFail();

                    $food = Food::updateOrCreate(
                        [
                            'name' => ['ar'=>$data['name'],'en'=> $data['name_en']],
                        ],
                        [

                            'food_category_id' => $category->id,

                            'serving_description' => $data['serving_description'],
                            'serving_amount' => $data['serving_amount'],
                            'serving_unit' => $data['serving_unit'],

                            'potassium_mg' => $data['potassium_mg'],
                            'phosphorus_mg' => $data['phosphorus_mg'],
                            'sodium_mg' => $data['sodium_mg'],

                            'general_guidance' => $data['general_guidance'],

                            'status' => 'enabled',
                        ]
                    );

                    /*
                     * Optional:
                     * Add aliases for each food here later.
                     */
                }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('foods', function (Blueprint $table) {
            //
        });
    }
};
