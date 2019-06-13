@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div id="user-container" class="row col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-body">
                        {!! Form::open(['url' => '/users/update/'.$user->id, 'files' => true, 'class' => 'full-width edit-user']) !!}
                        <div class="form-group">
                            {!! Form::label('name', 'Name: ') !!}
                            {!! Form::text('name', $user->name, ['class' => 'form-control', 'placeholder' => 'Enter name...']) !!}                            
                        </div>
                        <div class="form-group">
                            {!! Form::label('surname', 'Surname: ') !!}
                            {!! Form::text('surname', $user->surname, ['class' => 'form-control', 'placeholder' => 'Enter surname...']) !!}    
                        </div>
                        <div class="form-group">
                            {!! Form::label('email', 'Email: ') !!}
                            {!! Form::email('email', $user->email, ['class' => 'form-control', 'placeholder' => 'Enter email...']) !!}    
                        </div>
                        <div class="form-group">
                            {!! Form::label('date_born', 'Date born: ') !!}
                            {!! Form::date('date_born', $user->date_born, ['class' => 'form-control']) !!}    
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Description: ') !!}
                            {!! Form::textarea('description', $user->description, ['class' => 'form-control', 'placeholder' => 'Enter your description...']) !!}    
                        </div>

                        <div>
                            {!! Form::file('picture', ['class' => 'mt-2 picture-upload']) !!}

                            <div class="btn-group btn-group-toggle mt-1 float-right" data-toggle="buttons">
                                <label class="btn btn-secondary active">
                                    {!! Form::radio('privacy_type_id', 1, true) !!} Public
                                </label>
                                <label class="btn btn-secondary">
                                    {!! Form::radio('privacy_type_id', 2) !!} Private
                                </label>
                            </div>
                        </div>
                        <div class="mt-4">
                            {!! Form::submit('Save', ['class' => 'btn btn-success']) !!}
                            <a href="/users/show/{{$user->id}}" class="ml-3">Cancel</a>
                        </div>
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