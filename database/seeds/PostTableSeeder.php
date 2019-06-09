<?php

use Illuminate\Database\Seeder;
use App\Post;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::truncate();
        Post::create([
            'owner_id' => 1,
            'title' => 'First Post!',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vestibulum nec lacus quis malesuada. Mauris condimentum, sapien non volutpat aliquam, tortor risus consectetur arcu, quis placerat dolor turpis a libero. Aenean vestibulum ullamcorper augue tristique gravida. Vivamus interdum mi ut magna consequat, ullamcorper facilisis sapien sollicitudin.'
        ]);
        Post::create([
            'owner_id' => 1,
            'title' => 'Second Post!',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vestibulum nec lacus quis malesuada. Mauris condimentum, sapien non volutpat aliquam, tortor risus consectetur arcu, quis placerat dolor turpis a libero. Aenean vestibulum ullamcorper augue tristique gravida. Vivamus interdum mi ut magna consequat, ullamcorper facilisis sapien sollicitudin.'
        ]);
        Post::create([
            'owner_id' => 1,
            'title' => 'Third Post!',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vestibulum nec lacus quis malesuada. Mauris condimentum, sapien non volutpat aliquam, tortor risus consectetur arcu, quis placerat dolor turpis a libero. Aenean vestibulum ullamcorper augue tristique gravida. Vivamus interdum mi ut magna consequat, ullamcorper facilisis sapien sollicitudin.'
        ]);
    }
}
