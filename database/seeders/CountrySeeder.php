<?php

namespace Database\Seeders;

use App\Helpers\Constant;
use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Country::create(
            [
                'name' => 'Bangladesh',
                'currency' => Constant::CURRENCY['name'],
                'symbol' => Constant::CURRENCY['symbol'],
                'timezone' => 'UTC+06:00',
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
    }
}
