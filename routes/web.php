<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('activity', 'ActivityController', ['only' => ['store']]);
Route::resource('comments', 'CommentController', ['only' => ['store', 'update', 'destroy']]);
Route::resource('messages', 'MessageController', ['except' => ['edit', 'update']]);
Route::resource('messageslikes', 'MessageLikeController', ['only' => ['store', 'delete']]);
Route::resource('posts', 'PostController', ['except' => []]);
Route::resource('postslikes', 'PostLikeController', ['only' => ['store', 'delete']]);
Route::resource('users', 'UserController', ['except' => ['index', 'create', 'store']]);