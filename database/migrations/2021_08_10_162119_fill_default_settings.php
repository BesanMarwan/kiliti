<?php

use Illuminate\Database\Migrations\Migration;

class FillDefaultSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        \App\Models\Settings::set('name_ar', 'كليتي');
        \App\Models\Settings::set('name_en', 'My College');
        \App\Models\Settings::set('android', '','app');
        \App\Models\Settings::set('ios', '','app');


        \App\Models\Settings::set('mobile', '0597501686', 'contact');
        \App\Models\Settings::set('email', 'besanmarwan2000@gmail.com', 'contact');
        \App\Models\Settings::set('address', '', 'contact');
        \App\Models\Settings::set('address_en', '', 'contact');
        \App\Models\Settings::set('whatsapp', '970597501686', 'contact');

        \App\Models\Settings::set('facebook', '', 'social_media');
        \App\Models\Settings::set('twitter', '', 'social_media');
        \App\Models\Settings::set('instagram', '', 'social_media');
        \App\Models\Settings::set('linked_in', '', 'social_media');

        \App\Models\Settings::set('app_status_android', '1', 'app');
        \App\Models\Settings::set('app_status_ios', '1', 'app');
        \App\Models\Settings::set('android_version', '1', 'app');
        \App\Models\Settings::set('ios_version', '1', 'app');
        \App\Models\Settings::set('update_android', '1', 'app');
        \App\Models\Settings::set('update_ios', '1', 'app');

        \App\Models\Settings::set('password_length', '6', 'app');
        \App\Models\Settings::set('password_complexity', 'weak', 'app');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
