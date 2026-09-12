<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultCountries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $item=new \App\Models\Country();
        $item->name=['ar'=>'فلسطين','en'=>'Palestine'];
        $item->prefix=970;
        $item->mobile_digits=10;
        $item->currency=['ar'=>'شيكل','en'=>'shekel'];
        $item->is_default=1;
        $item->save();
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
