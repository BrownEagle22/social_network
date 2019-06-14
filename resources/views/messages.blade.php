@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div id="message-section" class="row">
                @if (count($messages) == 0)
                    <h3 class="m-auto">No messages found</h3>
                @else
                    @foreach ($messages as $message)
                        <div class="card full-width mb-2">
                            <div class="card-body">
                                @if($message['is_friend_request'])
                                    Accept friend request from <a href="/users/show/{{$message['user']->id}}">{{$message['user']->name}} {{$message['user']->surname}}</a>?
                                    <a href="/userfriends/accept/{{$message['id']}}"><button class="btn btn-success ml-4">Yes</button></a>
                                    <a href="/userfriends/delete/{{$message['id']}}"><button class="btn btn-danger">No</button></a>
                                    <span class="float-right">{{$message['created_at']}}</span>
                                @else
                                    <a href="/messages/show/{{$message['id']}}">{{$message['subject']}}</a>
                                    <span class="float-right">
                                        <a href="/users/show/{{$message['user']->id}}">{{$message['user']->name}} {{$message['user']->surname}}</a> {{$message['created_at']}}
                                    </span>
                                @endif
                            </div>
                        </div>                    
                    @endforeach
                @endif
            </div>
        </div>

        <div class="col-md-3">
            @include('right_panel')
        </div>            
    </div>
</div>
@endsection