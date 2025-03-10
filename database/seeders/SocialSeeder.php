<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\SocialMedia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = Admin::where('id', 1)->first();

        SocialMedia::create([
            'user_id' => $adminUser ? $adminUser->id : 1,
            'facebook' => 'https://www.facebook.com/yourUserId',
            'instagram' => 'https://www.instagram.com/yourUserId',
            'twitter' => 'https://www.twitter.com/yourUserId',
            'linkedin' => 'https://www.linkedin.com/in/yourUserId',
            'youtube' => 'https://www.youtube.com/channel/yourUserId',
        ]);
    }
}
