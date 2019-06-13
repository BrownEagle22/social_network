<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

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
        $friends = Auth::user()->friends()->get()
            ->merge(Auth::user()->friendsReverse()->get());

        foreach ($friends as $friend)
        {
            if (!$friend->picture_path)
                $friend->picture_path = asset('/images/'.env('DEFAULT_USER_PIC_NAME'));
        }

        return view('list_friends', ['friends' => $friends]);
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

        if ($user->privacy_type_id == 2 && $user->id != Auth::user()->id) {
            $friend = $user->friends()
                ->where('user_id', Auth::user()->id)
                ->get()
                ->merge($user->friendsReverse()
                    ->where('user_id', Auth::user()->id)
                    ->get());

            if ($friend->count() == 0 && !Auth::user()->isAdmin()) {
                $user['forbidden'] = true;
            }
        }
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

        return redirect()->action('UserController@show', [$id])->withMessage('User info changed!');
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

        return redirect()->action('HomeController@index')->withMessage('User deleted!');
    }
}
