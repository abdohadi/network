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
	Route::get('/', 'HomeController@index')->name('/');
	Route::get('/home', 'HomeController@index')->name('home');
	

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
	Route::post('/posts/{post}/share', 'Posts\PostsController@share')->name('posts.share');
	// comment routes
	Route::resource('posts.comments', 'Posts\PostsCommentsController')->only(['store', 'update']);
	Route::get('/posts/{post}/comments/{comment}/delete', 'Posts\PostsCommentsController@destroy')->name('posts.comments.destroy');


	// group routes
	Route::resource('groups', 'Groups\GroupsController')->except(['index', 'edit', 'create']);
	// group users
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
	// group posts
	Route::resource('groups.posts', 'Groups\GroupsPostsController')->except(['index', 'create', 'edit']);


	// friend request routes
	Route::post('/users/{user}/send_friend_request', 'Friends\FriendRequestsController@send')->name('users.send_request');
	Route::delete('/users/{user}/cancel_friend_request', 'Friends\FriendRequestsController@cancel')->name('users.cancel_request');
	Route::post('/users/{user}/accept_friend_request', 'Friends\FriendRequestsController@accept')->name('users.accept_request');
	Route::delete('/users/{user}/delete_friend_request', 'Friends\FriendRequestsController@delete')->name('users.delete_request');
	// friends routes
	Route::get('/users/{user}/friends', 'Friends\FriendsController@index')->name('users.friends.index');
	Route::delete('/users/{user}/unfriend', 'Friends\FriendsController@destroy')->name('users.unfriend');

});


Route::group(
[
	'prefix' => LaravelLocalization::setLocale(),
	'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {
	Auth::routes();
});