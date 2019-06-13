<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use App\Post;

class CommentController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $comment = new Comment();
        $comment->owner_id = Auth::user()->id;
        $comment->post()->associate(Post::find($data['post_id']));
        $comment->text = $data['text'];
        $comment->save();

        return redirect()->action('PostController@show', [$comment->post_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $comment = Comment::find($id);

        if ($comment->owner_id == Auth::user()->id ||
            Auth::user()->isAdmin() ||
            Auth::user()->isModerator())
        {
            $comment->update(['text' => $request['text']]);     
            return redirect()->action('PostController@show', [$comment->post_id]);                 
        }
        else
        {
            abort('403');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);

        if ($comment->owner_id == Auth::user()->id ||
            Auth::user()->isAdmin() ||
            Auth::user()->isModerator())
        {
            $comment->deleter_id = Auth::user()->id;
            $comment->save();       
            return redirect()->action('PostController@show', [$comment->post_id]);                 
        }
        else
        {
            abort('403');
        }
    }
}
