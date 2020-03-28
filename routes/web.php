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


Route::group(
[
	'prefix' => LaravelLocalization::setLocale(),
	'middleware' => ['auth', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {
	// home routes
	Route::get('/', 'HomeController@index');
	Route::get('/home', 'HomeController@index');
	
	// user routes
	Route::get('/users/{user}', 'UsersController@show');
	Route::get('/users/{user}/edit_info', 'UsersController@editInfo');
	Route::patch('/users/{user}/update_info', 'UsersController@updateInfo');

	// post routes
	Route::resource('posts', 'PostsController');
	Route::get('/posts/{post}/liked', 'PostsController@liked');
	Route::get('/posts/{post}/shared', 'PostsController@shared');
	Route::post('/posts/{post}/shared', 'PostsController@shared');

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


	// comment routes
	Route::post('/posts/{post}/comments', 'CommentsController@store');
	Route::patch('/posts/{post}/comments/{comment}', 'CommentsController@update');
	Route::get('/posts/{post}/comments/{comment}', 'CommentsController@destroy');


});


Route::group(
[
	'prefix' => LaravelLocalization::setLocale(),
	'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {
	Auth::routes();
});