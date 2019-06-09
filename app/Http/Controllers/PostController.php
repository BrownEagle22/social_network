<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'allPosts']);
    }

    public function allPosts()
    {
        //TODO: sorting
        $posts = Post::where('privacy_type_id', '=', '1')
            ->where('deleter_id', '=', null)
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($posts as $post)
        {
            $post->addLikeData();
            $post->addCommentCount();
        }
            
        return view('posts', ['posts' => $posts, 'post_type' => 1]);
    }

    public function friendPosts()
    {
        $posts = Post::whereHas('user.friends', function($q)
        {
            $q->where('user_id', '=', Auth::user()->id)
                ->orWhere('user_friend_id', '=', Auth::user()->id);
        })->where('deleter_id', '=', null)
            ->orderBy('created_at', 'desc')->get();

        foreach ($posts as $post)
        {
            $post->addLikeData();
            $post->addCommentCount();
        }

        return view('posts', ['posts' => $posts, 'post_type' => 2]);
    }

    public function myPosts()
    {
        $posts = Post::where('owner_id', '=', Auth::user()->id)
            ->where('deleter_id', '=', null)
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($posts as $post)
        {
            $post->addLikeData();
            $post->addCommentCount();
        }

        return view('posts', ['posts' => $posts, 'post_type' => 3]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check())
            return redirect()->action('PostController@friendPosts');
        else
            return redirect()->action('PostController@allPosts');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $post = new Post();
        $post->owner_id = $data['owner_id'];
        $post->privacy_type_id = $data['privacy_type_id'];
        $post->title = $data['title'];
        $post->description = $data['description'];
        $post->picture_path = $request->file('post')->store('posts');
        $post->save();

        return redirect()->action('HomeController@index')->withMessage('Post added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('post_show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        return view('post_edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $postToUpdate = Post::find($id);
        $postToUpdate->update([
            'title' => $request['title'],
            'description' => $request['description'],
            'privacy_type_id' => $request['privacy_type_id']
        ]);

        if ($request->files['post']) {
            $postToUpdate->update([
                'picture_path' => $request->files['post']->store('posts')
            ]);
        }

        return redirect()->action('PostController@myPosts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //TODO: Nosacījums
        Post::find($id)->delete();
        return redirect()->action('PostController@index');
    }
}
