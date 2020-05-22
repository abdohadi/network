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
	Route::get('/users/{user}', 'Users\UsersController@show')->name('users.show');
	Route::get('/users/{user}/edit_info', 'Users\UsersController@editInfo')->name('users.edit_info');
	Route::patch('/users/{user}/update_info', 'Users\UsersController@updateInfo')->name('users.update_info');
	Route::patch('/users/{user}/update_picture', 'Users\UsersController@updatePicture')->name('users.update_picture');
	Route::patch('/users/{user}/update_cover', 'Users\UsersController@updateCover')->name('users.update_cover');
	Route::resource('users.groups', 'Users\UsersGroupsController')->only(['index']);


	// post routes
	Route::resource('posts', 'Posts\PostsController')->except(['index', 'create', 'edit']);
	Route::get('/posts/{post}/like', 'Posts\PostsController@like')->name('posts.like');
	Route::get('/posts/{post}/share', 'Posts\PostsController@share')->name('posts.share');


	// group routes
	Route::resource('groups', 'Groups\GroupsController')->except(['index', 'edit', 'create']);
	// group users routes
	Route::patch('/groups/{group}/assign_admin/{user}', 'Groups\GroupsUsersController@assignAdmin')->name('groups.assign_admin');
	Route::patch('/groups/{group}/dismiss_admin/{user}', 'Groups\GroupsUsersController@dismissAdmin')->name('groups.dismiss_admin');
	Route::post('/groups/{group}/join', 'Groups\GroupsUsersController@join')->name('groups.join');
	Route::delete('/groups/{group}/cancel_request', 'Groups\GroupsUsersController@cancelRequest')->name('groups.cancel_request');
	Route::patch('/groups/{group}/accept_request/{user}', 'Groups\GroupsUsersController@acceptRequest')->name('groups.accept_request');
	Route::delete('/groups/{group}/remove_request/{user}', 'Groups\GroupsUsersController@removeRequest')->name('groups.remove_request');
	Route::delete('/groups/{group}/leave', 'Groups\GroupsUsersController@leaveGroup')->name('groups.leave');
	Route::get('/groups/{group}/friends', 'Groups\GroupsUsersController@viewFriends')->name('groups.view_friends');
	Route::post('/groups/{group}/add_member/{user}', 'Groups\GroupsUsersController@addMember')->name('groups.add_member');
	Route::delete('/groups/{group}/remove_member/{user}', 'Groups\GroupsUsersController@removeMember')->name('groups.remove_member');
	Route::get('/groups/{group}/admins', 'Groups\GroupsUsersController@viewAdmins')->name('groups.admins');
	Route::get('/groups/{group}/members', 'Groups\GroupsUsersController@viewMembers')->name('groups.members');
	Route::get('/groups/{group}/requests', 'Groups\GroupsUsersController@viewRequests')->name('groups.requests');

	// friend request routes
	Route::get('/users/{user}/send', 'Friends\FriendRequestsController@send')->name('users.send');
	Route::get('/users/{user}/cancel', 'Friends\FriendRequestsController@cancel')->name('users.cancel');
	Route::get('/users/{user}/accept', 'Friends\FriendRequestsController@accept')->name('users.accept');
	Route::get('/users/{user}/delete', 'Friends\FriendRequestsController@delete')->name('users.delete');
	// friends routes
	Route::get('/users/{user}/friends', 'Friends\FriendsController@show')->name('users.friends');


	// comment routes
	Route::resource('posts.comments', 'Comments\CommentsController')->only(['store', 'update', 'destroy']);

});


Route::group(
[
	'prefix' => LaravelLocalization::setLocale(),
	'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {
	Auth::routes();
});