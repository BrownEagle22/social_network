<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\UserMessage;
use App\MessageDeletion;

class MessageController extends Controller
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
        $messages = Message::where('user_from_id', '=', Auth::user()->id)->get();
        return view('messages', ['messages' => $messages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('message_create');
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
        $message = new Message();
        $message->subject = $data['subject'];
        $message->text = $data['text'];
        $message->user_from_id = $data['user_from_id'];
        $message->save();

        foreach ($request['user_to_ids'] as $user_to_id)
        {
            $userMessage = new UserMessage();
            $userMessage->message()->associate($message);
            $userMessage->user()->associate(Auth::user());
            $userMessage->save();
        }

        return redirect()->action('MessageController@index')->withMessage('Message successfully sent!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $message = Message::find($id);
        return view('message_show', ['message' => $message]);
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
    public function destroy($id)
    {
        $deletion = new MessageDeletion();
        $deletion->user()->associate(Auth::user());
        $deletion->message()->associate(Message::find($id));
        $deletion->save();

        return redirect()->action('MessageController@index')->withMessage('Message deleted!');
    }
}
