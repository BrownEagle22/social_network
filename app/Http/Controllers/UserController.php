<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\UserFriends;
use App\Activity;

class UserController extends Controller
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

    public function listFriends()
    {
        $friends = Auth::user()->friends()->where('is_accepted', true)->get()
            ->merge(Auth::user()->friendsReverse()->where('is_accepted', true)->get());

        foreach ($friends as $friend)
        {
            if (!$friend->picture_path)
                $friend->picture_path = asset('/images/'.env('DEFAULT_USER_PIC_NAME'));
        }

        return view('list_friends', ['friends' => $friends]);
    }

    public function askFriend($id)
    {
        $potentialFriend = User::find($id);
        if (!$potentialFriend)
            return abort(404);

        $friendBind = Auth::user()->friends()->where('user_friend_id', $id)->get()
            ->merge(Auth::user()->friendsReverse()->where('user_id', $id)->get());
            
        if ($friendBind->count() == 0 && $id != Auth::user()->id)
        {
            $bind = new UserFriends();
            $bind->user_id = Auth::user()->id;
            $bind->user_friend_id = $id;
            $bind->save();
            return redirect()->back()->withMessage('Friend request sent!');
        }

        return redirect()->back()->withMessage('Friend request was already sent!');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            abort(404);
        }

        /*$friend = $user->friends()
            ->where('user_friend_id', Auth::user()->id)
            ->where('is_accepted', true)
            ->get()
            ->merge($user->friendsReverse()
                ->where('user_id', Auth::user()->id)
                ->where('is_accepted', true)
                ->get());*/

        $friendship = UserFriends::where('user_id', $user->id)
            ->where('user_friend_id', Auth::user()->id)
            ->where('is_accepted', true)
            ->get()
            ->merge(UserFriends::where('user_friend_id', $user->id)
                ->where('user_id', Auth::user()->id)
                ->where('is_accepted', true)
                ->get());

        $user['is_friend'] = $friendship->count() != 0;
        if ($user['is_friend'])
            $user['friendship_id'] = $friendship->first()->id;

        $user['forbidden'] = $user->privacy_type_id == 2 && 
            !$user['is_friend'] && 
            $user->id != Auth::user()->id && 
            !Auth::user()->isAdmin();

        if (!$user->picture_path) {
            $user->picture_path = asset('/images/'.env('DEFAULT_USER_PIC_NAME'));
        }
        return view('user_show', ['user' => $user]);
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
        $user = User::find($id);
        return view('user_edit', ['user' => $user]);
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
        $userToUpdate = User::find($id);

        if (Auth::user()->id != $userToUpdate->id) {
            abort(403);
        }

        $defaultPath = asset('/images/'.env('DEFAULT_USER_PIC_NAME'));
        $picture_path = $userToUpdate->picture_path;
        if (!$picture_path) {
            $picture_path = $defaultPath;
        }
        if ($request->hasFile('picture')) {
            if ($defaultPath != $picture_path) {
                Storage::delete('app/users/'.$picture_path);
            }

            $picture_path = '/storage/'.$request->file('picture')->store('users', ['disk' => 'public']);
        }

        User::find($id)->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'surname' => $request['surname'],
            'date_born' => $request['date_born'],
            'description' => $request['description'],
            'picture_path' => $picture_path,
            'privacy_type_id' => $request['privacy_type_id']
        ]);

        $activity = new Activity();
        $activity->user_id = Auth::user()->id;
        $activity->activity_type_id = 3;
        $activity->description = 'edited profile data';
        $activity->save();

        return redirect()->action('UserController@show', [$id])->withMessage('Changes saved!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //TODO: pārbaude
        $user = User::find($id);
        $user->deleter_id = Auth::user()->id;
        $user->save();

        return redirect()->action('PostController@index')->withMessage('User deleted!');
    }
}
