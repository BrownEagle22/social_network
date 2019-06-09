@extends('layouts.app')
@section('content')
<script>
    var waiting = false;

    function toggleLike(postId, isPositive) {
        if (!waiting) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            waiting = true;

            var increaseEl = $("#post-" + postId + " .like");
            var otherEl = $("#post-" + postId + " .dislike");

            if (!isPositive) {
                var temp = increaseEl;
                increaseEl = otherEl;
                otherEl = temp;
            }

            if (increaseEl.hasClass("active")) {
                $.post("/postlikes/destroy", { post_id: postId, is_positive: isPositive ? "1" : "0", _token: CSRF_TOKEN }, function(data) {
                    if (data.success) {
                        var countEl = increaseEl.find(".like-count");
                        countEl.text(parseInt(countEl.text(), 10) - 1);
                    }
                    
                    increaseEl.removeClass("active");
                    otherEl.removeClass("active");
                    waiting = false;
                });
            } else {
                $.post("/postlikes/store", { post_id: postId, is_positive: isPositive ? "1" : "0", _token: CSRF_TOKEN }, function(data) {
                    if (data.success) {
                        var countEl = increaseEl.find(".like-count");
                        countEl.text(parseInt(countEl.text(), 10) + 1);
                    }
                    
                    increaseEl.addClass("active");

                    if (otherEl.hasClass("active")) {
                        var countEl = otherEl.find(".like-count");
                        countEl.text(parseInt(countEl.text(), 10) - 1);
                    }

                    otherEl.removeClass("active");
                    waiting = false;
                });
            }
        }
    }
</script>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div id="post-list-container" class="row">
                <ul id="post-menu" class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link {{$post_type === 1 ? 'active' : ''}}" href="/allposts">All posts</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{$post_type === 2 ? 'active' : ''}}" href="/friendposts">Friend posts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{$post_type === 3 ? 'active' : ''}}" href="/myposts">My posts</a>
                        </li>
                    @endauth
                </ul>

                @foreach ($posts as $post)
                    <div id="post-{{$post['id']}}" class="card">
                        @if ($post['picture_path'])
                            <img class="card-img-top" src="{{$post['picture_path']}}" alt="Post picture">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title"><a href="posts/show/{{$post->id}}">{{$post['title']}}</a></h5>
                            <p class="card-text">{{$post['description']}}</p>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="pagination post-item-footer">
                                        <li class="page-item like {{$post['user_liked'] ? 'active' : ''}} @guest disabled @endguest">
                                            <a class="page-link" onclick="toggleLike({{$post['id']}}, true)"><i class="far fa-thumbs-up"></i><span class="like-count">{{$post['like_count']}}</span></a>
                                        </li>
                                        <li class="page-item dislike {{$post['user_disliked'] ? 'active' : ''}} @guest disabled @endguest">
                                            <a class="page-link" onclick="toggleLike({{$post['id']}}, false)"><i class="far fa-thumbs-down"></i><span class="like-count">{{$post['dislike_count']}}</span></a>
                                        </li>
                                    </ul>
                                    <div class="vertical-line"></div>
                                    <a href="/posts/{{$post['id']}}#comments">{{$post['comment_count']}} comments</a>                                    
                                </div>

                                <p class="col-md-6"><a href="/user/show/{{$post->user->id}}">{{$post->user->name}} {{$post->user->surname}}</a> {{$post['created_at']}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
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