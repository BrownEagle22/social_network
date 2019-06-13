@extends('layouts.app')
@section('content')

<div class="modal fade" id="user-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                Do you really want to delete profile?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" onclick="location.href='/users/delete/'+{{$user->id}}">Yes</button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div id="user-container" class="row col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-body">
                        <div id="show-profile-container">
                            <div class="text-center">
                                <img class="user-picture mb-3" src="{{$user['picture_path']}}" alt="User picture">                        
                            </div>
                            <h5 class="card-title user-title text-center">{{$user->name}} {{$user->surname}}</h5>
                            @if ($user['forbidden'])
                                <strong>This profile is private.</strong>
                            @else
                                @if($user->role == 2)
                                    <strong class="text-primary text-center mb-3 d-block">MODERATOR</strong>
                                @elseif($user->role == 3)
                                    <strong class="text-primary text-center mb-3 d-block">ADMIN</strong>
                                @endif
                                <p>Post count: {{$user->posts->count()}}</p>
                                <p>Friend count: {{$user->friends->count() + $user->friendsReverse->count()}}</p>
                                <p>Email: {{$user->email}}</p>
                                <p>Description: {{$user->description}}</p>
                                <a href=""><button class="btn btn-success text-center">Send friend request</button></a>

                                @if (Auth::user()->id == $user->id)
                                    <a class="ml-4 float-right" href="/users/edit/{{$user->id}}"><i class="far fa-edit"></i></a>                              
                                @endif
                                    
                                @if (Auth::user()->id == $user->id || Auth::user()->isAdmin())
                                    <a class="ml-2 float-right" href="#" onclick="return false;" data-toggle="modal" data-target="#user-modal"><i class="far fa-trash-alt"></i></a>                            
                                @endif
                            @endif                          
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @auth
            <div class="col-md-3">
                @include('right_panel')
            </div>            
        @endauth
    </div>
</div>
@endsection