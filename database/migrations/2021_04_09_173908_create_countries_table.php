<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->integer('prefix')->nullable();
            $table->integer('mobile_digits')->nullable();
            $table->string('currency')->nullable();
            $table->string('flag', 255)->nullable();
            $table->integer('is_default')->nullable()->default(0);
            $table->integer('check_start_digit')->nullable()->default(0);
            $table->integer('start_digit')->nullable()->default(0);
            $table->integer('accept_prefix')->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
