@extends('layouts.app')
@section('content')

<script>
    var commentToDeleteId;

    function deleteComment() {
        $("#comment-" + commentToDeleteId + " .delete-comment").submit();    
        this.commentToDeleteId = 0;
    }

    function openEditing(commentId) {
        $("#comment-" + commentId + " .comment-text").addClass("d-none");
        $("#comment-" + commentId + " .change-comment").addClass("d-none");
        $("#comment-" + commentId + " .edit-comment").removeClass("d-none");
        $("#comment-" + commentId + " .editing-controls").removeClass("d-none");
    }

    function closeEditing(commentId) {
        $("#comment-" + commentId + " .comment-text").removeClass("d-none");
        $("#comment-" + commentId + " .change-comment").removeClass("d-none");
        $("#comment-" + commentId + " .edit-comment").addClass("d-none");
        $("#comment-" + commentId + " .editing-controls").addClass("d-none");
    }

    function openPostEditing(postId) {
        $("#post-" + postId + " .post-text").addClass("d-none");
        $("#post-" + postId + " .post-title").addClass("d-none");
        $("#post-" + postId + " .post-picture").addClass("d-none");
        $("#post-" + postId + " .change-post").addClass("d-none");
        $("#post-" + postId + " .edit-post").removeClass("d-none");
        $("#post-" + postId + " .post-editing-controls").removeClass("d-none");
    }

    function closePostEditing(postId) {
        $("#post-" + postId + " .post-text").removeClass("d-none");
        $("#post-" + postId + " .post-title").removeClass("d-none")
        $("#post-" + postId + " .post-picture").removeClass("d-none");;
        $("#post-" + postId + " .change-post").removeClass("d-none");
        $("#post-" + postId + " .edit-post").addClass("d-none");
        $("#post-" + postId + " .post-editing-controls").addClass("d-none");
    }

    function togglePostLike(postId, isPositive) {
        var containerId = "post-" + postId;
        var inputData = { post_id: postId };
        toggleBigLike(isPositive, containerId, "active", "postlikes", inputData);
    }

    function toggleCommentLike(commentId, isPositive) {
        var containerId = "comment-" + commentId;
        var inputData = { comment_id: commentId };
        toggleSmallLike(isPositive, containerId, "fa", "commentlikes", inputData);
    }

    window.addEventListener('load', function() {
        function hoverIn() {
            $(this).find("i").css("font-size", "16px");
            $(this).css("cursor", "pointer");
        }
        function hoverOut() {
            $(this).find("i").css("font-size", "14px");
        }

        $(".like").hover(hoverIn, hoverOut);
        $(".dislike").hover(hoverIn, hoverOut);
    });
</script>

<div class="modal fade" id="comment-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                Do you really want to delete this comment?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" onclick="location.href='/comments/delete/'+commentToDeleteId">Yes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="post-modal" tabindex="-1" role="dialog"aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                Do you really want to delete this post?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" onclick="location.href='/posts/delete/{{$post->id}}'">Yes</button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div id="post-list-container" class="row">
                <div id="post-{{$post['id']}}" class="card">
                    <div class="card-body">
                        <h5 class="card-title post-title">{{$post['title']}}</h5>
                        @if ($post['picture_path'])
                            <img class="post-picture" src="{{$post['picture_path']}}" alt="Post picture">
                        @endif
                        <p class="card-text post-text break-word">{{$post['description']}}</p>
                        
                        {!! Form::open(['url' => '/posts/update/'.$post->id, 'files' => true, 'class' => 'full-width d-none edit-post']) !!}
                        {!! Form::text('title', $post->title, ['class' => 'form-control mt-2', 'placeholder' => 'Edit title...']) !!}
                        {!! Form::textarea('description', $post->description, ['class' => 'form-control mt-4', 'placeholder' => 'Edit description...', 'rows' => '0']) !!}
                        {!! Form::file('post', ['class' => 'form-control-file mt-4']) !!}
                        <div class="btn-group btn-group-toggle mt-4" data-toggle="buttons">
                            <label class="btn btn-secondary {{$post->privacy_type_id != 2 ? 'active' : ''}}">
                                {!! Form::radio('privacy_type_id', 1, true) !!} Public
                            </label>
                            <label class="btn btn-secondary {{$post->privacy_type_id == 2 ? 'active' : ''}}">
                                {!! Form::radio('privacy_type_id', 2) !!} Private
                            </label>
                        </div>
                        {!! Form::close() !!}
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
                                @if ($post->can_change)
                                    <span class="change-post">
                                        <a class="ml-4" href="#" onclick="openPostEditing({{$post->id}});return false;"><i class="far fa-edit"></i></a>                                        
                                        <a class="ml-2" href="#" onclick="return false;" data-toggle="modal" data-target="#post-modal"><i class="far fa-trash-alt"></i></a>
                                    </span>
                                @endif
                                <span class="post-editing-controls d-none">
                                    <button type="button" class="btn btn-sm btn-success ml-4" onclick="$('#post-'+{{$post->id}}+' .edit-post').submit()"><i class="fas fa-check"></i></button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="closePostEditing({{$post->id}})"><i class="fas fa-ban"></i></button>
                                </span>

                            </div>

                            <p class="col-md-6"><a href="/users/show/{{$post->user->id}}">{{$post->user->name}} {{$post->user->surname}}</a> {{$post['created_at']}}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div id="comments" class="row">
                <ul class="list-unstyled full-width">
                    <li id="add-comment" class="media">
                        <img class="mr-3 profile-picture" src="{{$user['picture_path']}}" alt="profile picture">          
                        {!! Form::open(['action' => 'CommentController@store', 'class' => 'full-width']) !!}
                        {!! Form::hidden('post_id', $post->id) !!}
                        {!! Form::textarea('text', '', ['class' => 'form-control break-word', 'placeholder' => 'Your comment...', 'rows' => '0']) !!}
                        <button type="submit" class="btn btn-primary my-3">Submit</button>
                        {!! Form::close() !!}
                    </li>
                    
                    @foreach ($comments as $comment)
                        <li id="comment-{{$comment['id']}}" class="media my-4">
                            <img class="mr-3 profile-picture" src="{{$comment->user->picture_path}}" alt="profile picture">
                            <div class="media-body">
                                <div>
                                    <a href="/users/show/{{$comment->user->id}}" class="mt-0 mb-1 mr-3">{{$comment->user->name}} {{$comment->user->surname}}</a> {{$comment['created_at']}}
                                    <a class="ml-4 like" onclick="toggleCommentLike({{$comment['id']}}, true)"><i class="text-success far {{$comment['user_liked'] ? 'fa' : ''}} fa-thumbs-up"></i><span class="like-count">{{$comment['like_count']}}</span></a>
                                    <a class="ml-2 dislike" onclick="toggleCommentLike({{$comment['id']}}, false)"><i class="text-danger far {{$comment['user_disliked'] ? 'fa' : ''}} fa-thumbs-down"></i><span class="like-count">{{$comment['dislike_count']}}</span></a>
                                    @if ($comment->can_change)
                                        <span class="change-comment">
                                            <a class="ml-4" href="#" onclick="openEditing({{$comment->id}});return false;"><i class="far fa-edit"></i></a>                                        
                                            <a class="ml-2" href="#" onclick="commentToDeleteId = {{$comment->id}};return false;" data-toggle="modal" data-target="#comment-modal"><i class="far fa-trash-alt"></i></a>
                                        </span>
                                    @endif
                                    <span class="editing-controls d-none">
                                        <button type="button" class="btn btn-sm btn-success ml-4" onclick="$('#comment-'+{{$comment->id}}+' .edit-comment').submit()"><i class="fas fa-check"></i></button>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="closeEditing({{$comment->id}})"><i class="fas fa-ban"></i></button>
                                    </span>
                                </div>          
                               <span class="comment-text break-word">{{$comment->text}}</span>
                               {!! Form::open(['url' => '/comments/update/'.$comment->id, 'class' => 'full-width d-none edit-comment']) !!}
                               {!! Form::textarea('text', $comment->text, ['class' => 'form-control mt-2', 'placeholder' => 'Edit comment...', 'rows' => '0']) !!}
                               {!! Form::close() !!}
                            </div>
                        </li>        
                    @endforeach
                </ul>
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