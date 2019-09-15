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
	

	// posts routes
	Route::post('/posts', 'PostsController@store');
	Route::patch('/posts/{post}', 'PostsController@update');
	Route::delete('/posts/{post}', 'PostsController@destroy');


	// groups routes
	Route::post('/groups', 'GroupsController@store');


	// friend request
	Route::get('/users/add/{user}', 'FriendRequestsController@send');
	Route::get('/users/cancel/{user}', 'FriendRequestsController@cancel');


});

Route::get('/posts/{post}', 'PostsController@show');

Route::get('/users/{user}', 'UsersController@show');

Route::get('/groups/{group}', 'GroupsController@show');


Auth::routes();
