<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Auth;
use App\Comment;
use Illuminate\Support\Facades\Storage;
use App\Activity;

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
            $q->where('user_friend_id', '=', Auth::user()->id)
                ->where('is_accepted', true);
        })->where('deleter_id', '=', null)
            ->orderBy('created_at', 'desc')->get();

        $posts->merge(Post::whereHas('user.friendsReverse', function($q)
        {
            $q->where('user_id', '=', Auth::user()->id)
                ->where('is_accepted', true);
        })->where('deleter_id', '=', null)
            ->orderBy('created_at', 'desc')->get());

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
        $post->owner_id = Auth::user()->id;
        $post->privacy_type_id = $data['privacy_type_id'];
        $post->title = $data['title'];
        $post->description = $data['description'];

        if ($request->hasFile('post')) {
            $post->picture_path = '/uploads/'.$request->file('post')->store('posts', ['disk' => 'public']);
        }

        $post->save();

        Activity::create([
            'activity_type_id' => 1,
            'user_id' => Auth::user()->id,
            'description' => 'created post "'.$post->title.'"'
        ]);

        return redirect()->action('PostController@show', [$post->id])->withMessage('Post added!');
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
        $post->addLikeData();

        $post['can_change'] =
            Auth::user()->id == $post->owner_id ||
            Auth::user()->isAdmin() ||
            Auth::user()->isModerator();

        $comments = $post->comments()
            ->where('deleter_id', null)
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($comments as $comment)
        {
            $comment->addLikeData();
            if (!$comment->user->picture_path) {
                $comment->user->picture_path = asset('/images/'.env('DEFAULT_USER_PIC_NAME'));
            }
            $comment['can_change'] =
                Auth::user()->id == $comment->owner_id ||
                Auth::user()->isAdmin() ||
                Auth::user()->isModerator();
            //$comment['user'] = $comment->user()->first();
        }

        $user = Auth::user();
        if (!$user['picture_path']) {
            $user['picture_path'] = asset('/images/'.env('DEFAULT_USER_PIC_NAME'));
        }

        return view('post_show', ['post' => $post, 'user' => $user,'comments' => $comments]);
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
        $data = $request->all();

        $postToUpdate = Post::find($id);
        if (Auth::user()->id != $postToUpdate->owner_id &&
            !Auth::user()->isAdmin() &&
            !Auth::user()->isModerator()) {
            
            abort('403');
        }

        $picturePath = $postToUpdate->picture_path;
        if ($request->hasFile('post')) {
            $defaultPath = asset('/images/'.env('DEFAULT_USER_PIC_NAME'));
            if ($defaultPath != $postToUpdate->picture_path) {
                Storage::delete('app/posts/'.$postToUpdate);
            }

            $picturePath = '/uploads/'.$request->file('post')->store('posts', ['disk' => 'public']);
        }

        $postToUpdate->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'privacy_type_id' => $data['privacy_type_id'],
            'picture_path' => $picturePath
        ]);

        return redirect()->action('PostController@show', [$id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if (Auth::user()->id != $post->owner_id &&
            !Auth::user()->isAdmin() &&
            !Auth::user()->isModerator()) {
            
            abort('403');
        }

        $post->update([
            'deleter_id' => Auth::user()->id
        ]);

        Activity::create([
            'activity_type_id' => 2,
            'user_id' => Auth::user()->id,
            'description' => 'deleted post "'.$post->title.'"'
        ]);

        return redirect()->action('PostController@index');
    }
}
