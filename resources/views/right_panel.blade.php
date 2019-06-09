<div class="card friends-online-container">
    <div class="card-header">
        Friends online
    </div>
    <div class="card-body">
        <div class="card-text">
            @if ($online_friends->count() === 0)
                None
            @else
                @foreach ($online_friends as $friend)
                    <p class="friend-online">
                        <span class="green-circle"></span><a href="user/show/{{$friend->id}}">{{$friend->name}} {{$friend->surname}}</a>
                    </p>
                @endforeach                
            @endif
        </div>
    </div>
</div>