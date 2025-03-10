<?php

namespace Database\Seeders;

use App\Helpers\Constant;
use App\Models\DeliveryOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DeliveryOption::create(
            [
                'name' => 'Standard Delivery',
                'cost' => '150',
                'estimated_time' => Constant::ESTIMATED_TIME['3 to 7 days'],
                'tracking_available' => Constant::TRACKING_AVAILABLE['yes'],
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
    }
}
