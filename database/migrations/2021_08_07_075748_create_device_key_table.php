<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceKeyTable extends Migration
{
    protected $permissions;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_keys', function (Blueprint $table) {
            $table->id();
            $table->morphs('owner');  // it can be user or driver or admin
            $table->text('fcm_token');
            $table->string('device_type')->nullable();
            $table->string('device_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_keys');
    }
}
