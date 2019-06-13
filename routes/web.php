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
    return redirect()->action('PostController@index');
})->middleware('shared_view');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('shared_view');
Route::resource('activity', 'ActivityController', ['only' => ['store']])->middleware('shared_view');

Route::resource('comments', 'CommentController', ['only' => ['store']])->middleware('shared_view');
Route::get('comments/delete/{id}', 'CommentController@destroy')->middleware('shared_view');
Route::post('comments/update/{id}', 'CommentController@update')->middleware('shared_view');

Route::resource('messages', 'MessageController', ['except' => ['edit', 'update']])->middleware('shared_view');

Route::post('commentlikes/store', 'CommentLikeController@store')->middleware('shared_view');
Route::post('commentlikes/destroy', 'CommentLikeController@destroy')->middleware('shared_view');

Route::resource('posts', 'PostController', ['except' => ['show', 'edit', 'update', 'store', 'destroy']])->middleware('shared_view');
Route::get('posts/show/{id}', 'PostController@show')->middleware('shared_view');
Route::get('posts/edit/{id}', 'PostController@edit')->middleware('shared_view');
Route::post('posts/update/{id}', 'PostController@update')->middleware('shared_view');
Route::post('posts/store', 'PostController@store')->middleware('shared_view');
Route::get('posts/delete/{id}', 'PostController@destroy')->middleware('shared_view');

Route::get('allposts', 'PostController@allPosts')->middleware('shared_view');
Route::get('friendposts', 'PostController@friendPosts')->middleware('shared_view');
Route::get('myposts', 'PostController@myPosts')->middleware('shared_view');

Route::post('postlikes/store','PostLikeController@store')->middleware('shared_view');;
Route::post('postlikes/destroy','PostLikeController@destroy')->middleware('shared_view');;

Route::resource('users', 'UserController', ['except' => ['index', 'create', 'store', 'show', 'edit']])->middleware('shared_view');
Route::get('users/show/{id}', 'UserController@show')->middleware('shared_view');
Route::get('users/edit/{id}', 'UserController@edit')->middleware('shared_view');
Route::post('users/update/{id}', 'UserController@update')->middleware('shared_view');
Route::get('users/friends', 'UserController@listfriends')->middleware('shared_view');
