<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        User::create([
            'name' => 'Ēriks',
            'surname' => 'Žeibe',
            'email' => 'eriks_zeibe@inbox.lv',
            'password' => bcrypt('parole123'),
            'online_till' => '2000-01-01'
        ]);
        User::create([
            'name' => 'Admin',
            'surname' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin123'),
            'role' => 3,
            'online_till' => '2000-01-01'
        ]);
    }
}
