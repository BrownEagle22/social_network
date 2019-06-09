<?php

use Illuminate\Database\Seeder;
use App\UserFriends;

class UserFriendsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserFriends::truncate();
        UserFriends::create([
            'user_id' => 1,
            'user_friend_id' => 2
        ]);
    }
}
