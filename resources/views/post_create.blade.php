@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div id="post-list-container" class="row">
                <div class="card">
                    <div class="card-header">
                        Create post
                    </div>
                    <div class="card-body">
                        {!! Form::open(['url' => '/posts/store', 'files' => true, 'class' => 'full-width edit-post']) !!}
                        {!! Form::textarea('title', '', ['class' => 'form-control mt-2', 'placeholder' => 'Title...', 'rows' => '0']) !!}
                        {!! Form::textarea('description', '', ['class' => 'form-control mt-4', 'placeholder' => 'Description...', 'rows' => '0']) !!}
                        {!! Form::file('post', ['class' => 'mt-4']) !!}
                        <div class="btn-group btn-group-toggle mt-4 float-right" data-toggle="buttons">
                            <label class="btn btn-secondary active">
                                {!! Form::radio('privacy_type_id', 1, true) !!} Public
                            </label>
                            <label class="btn btn-secondary">
                                {!! Form::radio('privacy_type_id', 2) !!} Private
                            </label>
                        </div>
                        {!! Form::submit('Create', ['class' => 'btn btn-success d-block mt-4']) !!}
                        {!! Form::close() !!}
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