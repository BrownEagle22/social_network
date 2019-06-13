<div id="right-panel-container">
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
                            <span class="green-circle"></span><a href="/users/show/{{$friend->id}}">{{$friend->name}} {{$friend->surname}}</a>
                        </p>
                    @endforeach                
                @endif
            </div>
        </div>
    </div>

    <div class="card activities-container">
        <div class="card-header">
            Friends activities
        </div>
        <div class="card-body">
            <div class="card-text">
                @if ($activities->count() === 0)
                    None
                @else
                    @foreach ($activities as $activity)
                        <p>
                            <a href="/users/show/{{$activity->user->id}}">{{$activity->user->name}} {{$activity->user->surname}}</a> {{$activity->description}}
                        </p>
                    @endforeach                
                @endif
            </div>
        </div>
    </div>
</div>