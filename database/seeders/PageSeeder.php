<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages =
            [
                [
                    'title' => ['ar' => 'الشروط والاحكام', 'en' => 'Conditions'],
                    'text' => [
                        'ar' => 'لوريم ايبسوم دولار سيت أميت ,كونسيكتيتور أدايبا يسكينج أليايت,سيت دو أيوسمود تيمبور',
                        'en' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. ',
                    ],
                ],
                [
                    'title' => ['ar' => 'الخصوصية والسياسات', 'en' => 'Privacy Policy'],
                    'text' => [
                        'ar' => 'لوريم ايبسوم دولار سيت أميت ,كونسيكتيتور أدايبا يسكينج أليايت,سيت دو أيوسمود تيمبور',
                        'en' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. ',
                    ],
                ],
                [
                    'title' => ['ar' => 'عن التطبيق', 'en' => 'About Application'],
                    'text' => [
                        'ar' => 'لوريم ايبسوم دولار سيت أميت ,كونسيكتيتور أدايبا يسكينج أليايت,سيت دو أيوسمود تيمبور',
                        'en' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. ',
                    ],
                ],
            ];

        foreach ($pages as $page) {
            Page::query()->create($page);
        }
    }
}
