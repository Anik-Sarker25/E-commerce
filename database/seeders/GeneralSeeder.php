<?php

namespace Database\Seeders;

use App\Models\GeneralSettings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeneralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GeneralSettings::create(
            [
                'system_name' => 'System Name',
                'company_name' => 'Company Name',
                'address' => 'Enter Company Address...',
                'email' => 'example@example.com',
                'site_logo' => 'uploads/settings/image.png',
                'favicon' => 'uploads/settings/favicon.png',
                'admin_logo' => 'uploads/settings/admin-logo.png',
                'copyright' => 'Copyright © 2010. All rights reserved by',
                'site_title' => 'Company Title',
                'company_motto' => 'Company Motto',
                'meta_description' => 'Company about information',
                'meta_keywords' => 'site-name, company-name etc.',
                'meta_image' => 'uploads/settings/admin-logo.png',
                'timezone' => 'Asia/Dhaka',
                'created_at' => now()
            ]
        );
    }
}
