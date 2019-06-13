@extends('layouts.app')
@section('content')
<script>
    function togglePostLike(postId, isPositive) {
        var containerId = "post-" + postId;
        var inputData = { post_id: postId };
        toggleBigLike(isPositive, containerId, "active", "postlikes", inputData);
    }
</script>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div id="post-list-container" class="row">
                <ul id="post-menu" class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link {{$post_type === 1 ? 'active' : ''}}" href="/allposts">Public posts</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{$post_type === 2 ? 'active' : ''}}" href="/friendposts">Friends posts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{$post_type === 3 ? 'active' : ''}}" href="/myposts">My posts</a>
                        </li>
                    @endauth
                </ul>

                @foreach ($posts as $post)
                    <div id="post-{{$post['id']}}" class="card">
                        <div class="card-body">
                            <h5 class="card-title"><a href="posts/show/{{$post->id}}">{{$post['title']}}</a></h5>
                            @if ($post['picture_path'])
                                <img class="post-picture" src="{{$post['picture_path']}}" alt="Post picture">
                            @endif
                            <p class="card-text">{{$post['description']}}</p>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="pagination post-item-footer">
                                        <li class="page-item like {{$post['user_liked'] ? 'active' : ''}} @guest disabled @endguest">
                                            <a class="page-link" onclick="togglePostLike({{$post['id']}}, true)"><i class="far fa-thumbs-up"></i><span class="like-count">{{$post['like_count']}}</span></a>
                                        </li>
                                        <li class="page-item dislike {{$post['user_disliked'] ? 'active' : ''}} @guest disabled @endguest">
                                            <a class="page-link" onclick="togglePostLike({{$post['id']}}, false)"><i class="far fa-thumbs-down"></i><span class="like-count">{{$post['dislike_count']}}</span></a>
                                        </li>
                                    </ul>
                                    <div class="vertical-line"></div>
                                    <a href="/posts/show/{{$post['id']}}#comments">{{$post['comment_count']}} comments</a>                                    
                                </div>

                                <p class="col-md-6"><a href="/users/show/{{$post->user->id}}">{{$post->user->name}} {{$post->user->surname}}</a> {{$post['created_at']}}</p>
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