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
Route::resource('comments', 'CommentController', ['only' => ['store', 'update', 'destroy']])->middleware('shared_view');
Route::resource('messages', 'MessageController', ['except' => ['edit', 'update']])->middleware('shared_view');
Route::resource('messagelikes', 'MessageLikeController', ['only' => ['store', 'delete']])->middleware('shared_view');
Route::resource('posts', 'PostController', ['except' => []])->middleware('shared_view');
Route::get('allposts', 'PostController@allPosts')->middleware('shared_view');
Route::get('friendposts', 'PostController@friendPosts')->middleware('shared_view');
Route::get('myposts', 'PostController@myPosts')->middleware('shared_view');
Route::resource('postlikes', 'PostLikeController', ['only' => ['delete']])->middleware('shared_view');
Route::post('postlikes/store','PostLikeController@store')->middleware('shared_view');;
Route::post('postlikes/destroy','PostLikeController@destroy')->middleware('shared_view');;
Route::resource('users', 'UserController', ['except' => ['index', 'create', 'store']])->middleware('shared_view');