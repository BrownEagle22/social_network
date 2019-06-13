<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CommentLike;
use Illuminate\Support\Facades\Auth;
use App\Comment;

class CommentLikeController extends Controller
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

        $commentLike = CommentLike::where('user_id', '=', Auth::user()['id'])
            ->where('comment_id', '=', $data['comment_id'])
            ->where('is_positive', '=', $data['is_positive'])
            ->first();

        if ($commentLike)
            return ['success' => false];

        $commentLike = CommentLike::where('user_id', '=', Auth::user()['id'])
            ->where('comment_id', '=', $data['comment_id'])
            ->where('is_positive', '<>', $data['is_positive'])
            ->first();

        if ($commentLike)
            $commentLike->delete();
        
        $like = new CommentLike();
        $like->is_positive = $data['is_positive'];
        $like->user()->associate(Auth::user());
        $like->comment()->associate(Comment::find($data['comment_id']));
        $like->save();

        return ['success' => true];
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = $request->all();

        $commentLike = CommentLike::where('user_id', '=', Auth::user()['id'])
            ->where('comment_id', '=', $data['comment_id'])
            ->where('is_positive', '=', $data['is_positive'])
            ->first();

        if ($commentLike)
        {
            $commentLike->delete();
            return ['success' => true];
        }
        else
        {
            return ['success' => false];
        }
    }
}
