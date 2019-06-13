<?php

use Illuminate\Database\Seeder;
use App\Comment;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comment::truncate();
        Comment::create([
            'owner_id' => '2',
            'post_id' => '1',
            'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vestibulum nec lacus quis malesuada. Mauris condimentum, sapien non volutpat aliquam, tortor risus consectetur arcu, quis placerat dolor turpis a libero.'
        ]);
        Comment::create([
            'owner_id' => '1',
            'post_id' => '1',
            'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vestibulum nec lacus quis malesuada. Mauris condimentum, sapien non volutpat aliquam, tortor risus consectetur arcu, quis placerat dolor turpis a libero.'
        ]);
        Comment::create([
            'owner_id' => '1',
            'post_id' => '1',
            'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vestibulum nec lacus quis malesuada. Mauris condimentum, sapien non volutpat aliquam, tortor risus consectetur arcu, quis placerat dolor turpis a libero.'
        ]);
        Comment::create([
            'owner_id' => '2',
            'post_id' => '1',
            'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vestibulum nec lacus quis malesuada. Mauris condimentum, sapien non volutpat aliquam, tortor risus consectetur arcu, quis placerat dolor turpis a libero.'
        ]);


        Comment::create([
            'owner_id' => '1',
            'post_id' => '2',
            'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vestibulum nec lacus quis malesuada. Mauris condimentum, sapien non volutpat aliquam, tortor risus consectetur arcu, quis placerat dolor turpis a libero.'
        ]);
        Comment::create([
            'owner_id' => '1',
            'post_id' => '2',
            'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vestibulum nec lacus quis malesuada. Mauris condimentum, sapien non volutpat aliquam, tortor risus consectetur arcu, quis placerat dolor turpis a libero.'
        ]);
        Comment::create([
            'owner_id' => '2',
            'post_id' => '2',
            'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vestibulum nec lacus quis malesuada. Mauris condimentum, sapien non volutpat aliquam, tortor risus consectetur arcu, quis placerat dolor turpis a libero.'
        ]);
    }
}
