<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //TODO: pictures
        $posts = Post::where('user_id', '=', Auth::user()->id)
            ->where('deleter_id', '=', null)
            ->get();
            
        return view('posts', ['posts' => $posts]);
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
        //TODO: pictures
        $data = $request->all();
        $post = new Post();
        $post->owner_id = $data['owner_id'];
        $post->privacy_type_id = $data['privacy_type_id'];
        $post->title = $data['title'];
        $post->description = $data['description'];
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
        //TODO: pictures
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
        //TODO: pictures
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
        //TODO: pictures
        Post::find($id)->update([
            'title' => $request['title'],
            'description' => $request['description'],
            'privacy_type_id' => $request['privacy_type_id']
        ]);
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
    }
}
