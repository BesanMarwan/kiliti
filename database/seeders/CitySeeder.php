<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->loadSud();
    }

    private function loadSud()
    {
        $regions = [
            ['id' => '1', 'name' => 'الرياض'],
            ['id' => '2', 'name' => 'مكة المكرمة'],
            ['id' => '3', 'name' => 'المدينة المنورة'],
            ['id' => '4', 'name' => 'الشرقية'],
            ['id' => '5', 'name' => 'القصيم'],
            ['id' => '6', 'name' => 'تبوك'],
            ['id' => '7', 'name' => 'عسير'],
            ['id' => '8', 'name' => 'حائل'],
            ['id' => '9', 'name' => 'نجران'],
            ['id' => '10', 'name' => 'جازان'],
            ['id' => '11', 'name' => 'الجوف'],
            ['id' => '12', 'name' => 'الحدود الشمالية'],
            ['id' => '13', 'name' => 'الباحة'],
            ['id' => '14', 'name' => 'غير محدد'],
        ];

        $cities = [
            ['id' => '1', 'region_id' => '1', 'name' => 'الرياض'],
            ['id' => '2', 'region_id' => '1', 'name' => 'الدلم'],
            ['id' => '3', 'region_id' => '2', 'name' => 'جدة'],
            ['id' => '4', 'region_id' => '2', 'name' => 'مكة المكرمة'],
            ['id' => '5', 'region_id' => '3', 'name' => 'المدينة المنورة'],
            ['id' => '6', 'region_id' => '4', 'name' => 'الأحساء'],
            ['id' => '7', 'region_id' => '4', 'name' => 'الدمام'],
            ['id' => '8', 'region_id' => '2', 'name' => 'الطائف'],
            ['id' => '9', 'region_id' => '5', 'name' => 'بريدة'],
            ['id' => '10', 'region_id' => '6', 'name' => 'تبوك'],
            ['id' => '11', 'region_id' => '4', 'name' => 'القطيف'],
            ['id' => '12', 'region_id' => '7', 'name' => 'خميس مشيط'],
            ['id' => '13', 'region_id' => '4', 'name' => 'الخبر'],
            ['id' => '14', 'region_id' => '4', 'name' => 'حفر الباطن'],
            ['id' => '15', 'region_id' => '4', 'name' => 'الجبيل'],
            ['id' => '16', 'region_id' => '1', 'name' => 'الخرج'],
            ['id' => '17', 'region_id' => '7', 'name' => 'أبها'],
            ['id' => '18', 'region_id' => '8', 'name' => 'حائل'],
            ['id' => '19', 'region_id' => '9', 'name' => 'نجران'],
            ['id' => '20', 'region_id' => '3', 'name' => 'ينبع'],
            ['id' => '21', 'region_id' => '10', 'name' => 'صبيا'],
            ['id' => '22', 'region_id' => '1', 'name' => 'الدوادمي'],
            ['id' => '23', 'region_id' => '7', 'name' => 'بيشة'],
            ['id' => '24', 'region_id' => '10', 'name' => 'أبو عريش'],
            ['id' => '25', 'region_id' => '2', 'name' => 'القنفذة'],
            ['id' => '26', 'region_id' => '7', 'name' => 'محايل'],
            ['id' => '27', 'region_id' => '11', 'name' => 'سكاكا'],
            ['id' => '28', 'region_id' => '12', 'name' => 'عرعر'],
            ['id' => '29', 'region_id' => '5', 'name' => 'عنيزة'],
            ['id' => '30', 'region_id' => '11', 'name' => 'القريات'],
            ['id' => '31', 'region_id' => '10', 'name' => 'صامطة'],
            ['id' => '32', 'region_id' => '10', 'name' => 'جازان'],
            ['id' => '33', 'region_id' => '1', 'name' => 'المجمعة'],
            ['id' => '34', 'region_id' => '1', 'name' => 'القويعية'],
            ['id' => '35', 'region_id' => '10', 'name' => 'احد المسارحه'],
            ['id' => '36', 'region_id' => '5', 'name' => 'الرس'],
            ['id' => '37', 'region_id' => '1', 'name' => 'وادي الدواسر'],
            ['id' => '38', 'region_id' => '2', 'name' => 'بحرة'],
            ['id' => '39', 'region_id' => '13', 'name' => 'الباحة'],
            ['id' => '40', 'region_id' => '2', 'name' => 'الجموم'],
            ['id' => '41', 'region_id' => '2', 'name' => 'رابغ'],
            ['id' => '42', 'region_id' => '7', 'name' => 'أحد رفيدة'],
            ['id' => '43', 'region_id' => '9', 'name' => 'شرورة'],
            ['id' => '44', 'region_id' => '2', 'name' => 'الليث'],
            ['id' => '45', 'region_id' => '12', 'name' => 'رفحاء'],
            ['id' => '46', 'region_id' => '1', 'name' => 'عفيف'],
            ['id' => '47', 'region_id' => '2', 'name' => 'العرضيات'],
            ['id' => '48', 'region_id' => '10', 'name' => 'العارضة'],
            ['id' => '49', 'region_id' => '4', 'name' => 'الخفجي'],
            ['id' => '50', 'region_id' => '7', 'name' => 'بالقرن'],
            ['id' => '51', 'region_id' => '1', 'name' => 'الدرعية'],
            ['id' => '52', 'region_id' => '10', 'name' => 'ضمد'],
            ['id' => '53', 'region_id' => '11', 'name' => 'طبرجل'],
            ['id' => '54', 'region_id' => '10', 'name' => 'بيش'],
            ['id' => '55', 'region_id' => '1', 'name' => 'الزلفي'],
            ['id' => '56', 'region_id' => '10', 'name' => 'الدرب'],
            ['id' => '57', 'region_id' => '1', 'name' => 'الافلاج'],
            ['id' => '58', 'region_id' => '7', 'name' => 'سراة عبيدة'],
            ['id' => '59', 'region_id' => '7', 'name' => 'رجال المع'],
            ['id' => '60', 'region_id' => '13', 'name' => 'بلجرشي'],
            ['id' => '61', 'region_id' => '8', 'name' => 'الحائط'],
            ['id' => '62', 'region_id' => '2', 'name' => 'ميسان'],
            ['id' => '63', 'region_id' => '3', 'name' => 'بدر'],
            ['id' => '64', 'region_id' => '6', 'name' => 'املج'],
            ['id' => '65', 'region_id' => '4', 'name' => 'رأس تنوره'],
            ['id' => '66', 'region_id' => '3', 'name' => 'المهد'],
            ['id' => '67', 'region_id' => '10', 'name' => 'الدائر'],
            ['id' => '68', 'region_id' => '5', 'name' => 'البكيريه'],
            ['id' => '69', 'region_id' => '5', 'name' => 'البدائع'],
            ['id' => '70', 'region_id' => '2', 'name' => 'خليص'],
            ['id' => '71', 'region_id' => '3', 'name' => 'الحناكية'],
            ['id' => '72', 'region_id' => '3', 'name' => 'العلا'],
            ['id' => '73', 'region_id' => '10', 'name' => 'الطوال'],
            ['id' => '74', 'region_id' => '7', 'name' => 'النماص'],
            ['id' => '75', 'region_id' => '7', 'name' => 'المجاردة'],
            ['id' => '76', 'region_id' => '4', 'name' => 'بقيق'],
            ['id' => '77', 'region_id' => '7', 'name' => 'تثليث'],
            ['id' => '78', 'region_id' => '13', 'name' => 'المخواة'],
            ['id' => '79', 'region_id' => '4', 'name' => 'النعيرية'],
            ['id' => '80', 'region_id' => '6', 'name' => 'الوجه'],
            ['id' => '81', 'region_id' => '6', 'name' => 'ضباء'],
            ['id' => '82', 'region_id' => '7', 'name' => 'بارق'],
            ['id' => '83', 'region_id' => '12', 'name' => 'طريف'],
            ['id' => '84', 'region_id' => '3', 'name' => 'خيبر'],
            ['id' => '85', 'region_id' => '2', 'name' => 'أضم'],
            ['id' => '86', 'region_id' => '5', 'name' => 'النبهانية'],
            ['id' => '87', 'region_id' => '2', 'name' => 'رنيه'],
            ['id' => '88', 'region_id' => '11', 'name' => 'دومة الجندل'],
            ['id' => '89', 'region_id' => '5', 'name' => 'المذنب'],
            ['id' => '90', 'region_id' => '2', 'name' => 'تربه'],
            ['id' => '91', 'region_id' => '7', 'name' => 'ظهران الجنوب'],
            ['id' => '92', 'region_id' => '1', 'name' => 'حوطة بني تميم'],
            ['id' => '93', 'region_id' => '2', 'name' => 'الخرمة'],
            ['id' => '94', 'region_id' => '13', 'name' => 'قلوه'],
            ['id' => '95', 'region_id' => '1', 'name' => 'شقراء'],
            ['id' => '96', 'region_id' => '2', 'name' => 'المويه'],
            ['id' => '97', 'region_id' => '1', 'name' => 'المزاحمية'],
            ['id' => '98', 'region_id' => '5', 'name' => 'الأسياح'],
            ['id' => '99', 'region_id' => '8', 'name' => 'بقعاء'],
            ['id' => '100', 'region_id' => '1', 'name' => 'السليل'],
            ['id' => '101', 'region_id' => '6', 'name' => 'تيماء'],
            ['id' => '102', 'region_id' => '11', 'name' => 'الجوف'],
            ['id' => '103', 'region_id' => '14', 'name' => 'دبي'],
            ['id' => '104', 'region_id' => '14', 'name' => 'ساجر'],
            ['id' => '105', 'region_id' => '14', 'name' => 'غير محدد'],
            ['id' => '106', 'region_id' => '14', 'name' => 'رياض الخبراء'],
            ['id' => '107', 'region_id' => '14', 'name' => 'الشارقة'],
            ['id' => '108', 'region_id' => '5', 'name' => 'الشماسية'],
            ['id' => '109', 'region_id' => '5', 'name' => 'عيون الجواء'],
            ['id' => '110', 'region_id' => '5', 'name' => 'الخبراء'],
            ['id' => '111', 'region_id' => '5', 'name' => 'رياض الخبراء'],
            ['id' => '112', 'region_id' => '4', 'name' => 'جبيل البلد'],
            ['id' => '113', 'region_id' => '4', 'name' => 'جبيل الصناعيه'],
            ['id' => '114', 'region_id' => '4', 'name' => 'الظهران'],
            ['id' => '115', 'region_id' => '4', 'name' => 'سيهات'],
            ['id' => '116', 'region_id' => '4', 'name' => 'ام الساهك'],
            ['id' => '117', 'region_id' => '4', 'name' => 'عنك'],
            ['id' => '118', 'region_id' => '4', 'name' => 'تاروت'],
            ['id' => '119', 'region_id' => '1', 'name' => 'الداهنه'],
            ['id' => '120', 'region_id' => '1', 'name' => 'الغاط'],
            ['id' => '121', 'region_id' => '1', 'name' => 'عشيره سدير'],
            ['id' => '122', 'region_id' => '1', 'name' => 'الارطاويه'],
            ['id' => '123', 'region_id' => '1', 'name' => 'اشقير'],
            ['id' => '124', 'region_id' => '1', 'name' => 'روضه سدير'],
            ['id' => '125', 'region_id' => '1', 'name' => 'حوطه سدير'],
            ['id' => '126', 'region_id' => '2', 'name' => 'ينبع'],
            ['id' => '127', 'region_id' => '10', 'name' => 'خميس'],
            ['id' => '128', 'region_id' => '10', 'name' => 'مشيط'],
            ['id' => '129', 'region_id' => '10', 'name' => 'الشقيق'],
            ['id' => '130', 'region_id' => '10', 'name' => 'ابها'],
            ['id' => '131', 'region_id' => '10', 'name' => 'جيزان'],
        ];
        foreach ($regions as $gov) {
            City::create([
                'id' => $gov['id'],
                'name' => [
                    'ar' => $gov['name'],
                    'en' => translate($gov['name'], 'en'),
                ],
                'parent_id' => 0,
                'country_id' => 1,
            ]);
        }
        foreach ($cities as $area) {
            City::create([
                'name' => [
                    'ar' => $area['name'],
                    'en' => translate($area['name'], 'en'),
                ],
                'parent_id' => $area['region_id'],
                'country_id' => 1,
            ]);
        }
    }
}
