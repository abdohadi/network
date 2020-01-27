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


Route::group(['middleware' => ['auth']], function () {
	// home routes
	Route::get('/', 'HomeController@index');
	Route::get('/home', 'HomeController@index');
	
	// user routes
	Route::get('/users/{user}', 'UsersController@show');

	// post routes
	Route::resource('posts', 'PostsController');
	// Route::post('/posts', 'PostsController@store');
	// Route::get('/posts/{post}', 'PostsController@show');
	// Route::patch('/posts/{post}', 'PostsController@update');
	// Route::delete('/posts/{post}', 'PostsController@destroy');
	Route::get('/posts/{post}/liked', 'PostsController@liked');

	// group routes
	// Route::resource('groups', 'GroupsController');
	Route::post('/groups', 'GroupsController@store');
	Route::get('/groups/{group}', 'GroupsController@show');
	Route::get('/groups/{group}/join', 'GroupsController@join');


	// friend request routes
	Route::get('/users/request/send/{user}', 'FriendRequestsController@send');
	Route::get('/users/request/cancel/{user}', 'FriendRequestsController@cancel');
	Route::get('/users/request/accept/{user}', 'FriendRequestsController@accept');
	Route::get('/users/request/delete/{user}', 'FriendRequestsController@delete');
	// friends routes
	Route::get('/users/{user}/friends', 'FriendsController@show');





});

Auth::routes();
