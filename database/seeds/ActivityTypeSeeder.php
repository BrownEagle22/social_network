<?php

use Illuminate\Database\Seeder;
use App\ActivityType;

class ActivityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ActivityType::truncate();
        ActivityType::create([
            'name' => 'post_new',
            'description' => 'Created new post'
        ]);
        ActivityType::create([
            'name' => 'post_delete',
            'description' => 'Deleted post'
        ]);
        ActivityType::create([
            'name' => 'like_post',
            'description' => 'Liked post'
        ]);
    }
}
