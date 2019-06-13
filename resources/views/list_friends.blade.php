@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div id="friends-section" class="row">
                @if ($friends->count() == 0)
                    <h3 class="m-auto">No friends found</h3>
                @else
                    @foreach ($friends as $friend)
                        <div class="card">
                            <img class="card-image-top" src="{{$friend->picture_path}}" alt="Friend picture">
                            <div class="card-body">
                                <a href="/users/show/{{$friend->id}}">{{$friend->name}} {{$friend->surname}}</a>
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