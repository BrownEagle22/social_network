<?php

use Illuminate\Database\Seeder;
use App\PrivacyType;

class PrivacyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PrivacyType::truncate();
        PrivacyType::create(array('id' => 1, 'name' => 'public', 'description' => 'Everyone has access'));
        PrivacyType::create(array('id' => 2, 'name' => 'private', 'description' => 'Only friends has access'));
    }
}
