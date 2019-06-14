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
            'id' => 1,
            'name' => 'post_new',
            'description' => 'Created new post'
        ]);
        ActivityType::create([
            'id' => 2,
            'name' => 'post_delete',
            'description' => 'Deleted post'
        ]);
        ActivityType::create([
            'id' => 3,
            'name' => 'edited_profile',
            'description' => 'Edited profile data'
        ]);
    }
}
