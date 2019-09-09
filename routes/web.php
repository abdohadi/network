<?php


// dd($_SERVER);
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
});

Route::get('/posts/{post}', 'PostsController@show');

Route::get('/users/{user}', 'UsersController@show');


Auth::routes();
