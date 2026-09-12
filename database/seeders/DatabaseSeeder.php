<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CitySeeder::class);
        $this->call(PaymentTypeSeeder::class);
//        $this->call(GeneralCaseSeed::class);
        $this->call(PageSeeder::class);
    }
}
