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

Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'PostController@index');
Route::get('/posts', 'HomeController@index');

Route::post('/posts', 'PostController@store');
Route::get('/posts/{id}', 'PostController@show');

Route::post('/comments', 'CommentController@store');
Route::post('/replies', 'ReplyController@store');
Route::delete('/post/{id}', 'CommentController@destroy');
//comment react
Route::post('/comments/upvote', 'CommentController@upvote');
Route::post('/comments/downvote', 'CommentController@downvote');

//post react
Route::post('/posts/upvote', 'PostController@upvote');
Route::post('/posts/downvote', 'PostController@downvote');

//reply react
Route::post('replies/upvote', 'ReplyController@upvote');
Route::post('replies/downvote', 'ReplyController@downvote');

//
Route::post('/webpage', 'HomeController@personalpage');

