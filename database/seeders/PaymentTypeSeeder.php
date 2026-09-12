<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentType::create([
            'name' => ['ar' => 'مدى', 'en' => 'Mada'],
            'icon' => 'mada.png',
            'status' => 'enabled',
            'type' => 'online',
        ]);
        PaymentType::create([
            'name' => ['ar' => 'فيزا', 'en' => 'Visa'],
            'icon' => 'visa.png',
            'status' => 'enabled',
            'type' => 'online',
        ]);

        PaymentType::create([
            'name' => ['ar' => 'Apple Pay', 'en' => 'Apple Pay'],
            'icon' => 'apple.png',
            'status' => 'enabled',
            'type' => 'online',
        ]);
    }
}
