<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array('uses' => 'HomeController@hello', 'as' => 'home'));

Route::get('/user/{username}', array('uses' => 'ProfileController@user', 'as' => 'profile-user'));

Route::get('/user/{username}/update', array('uses' => 'ProfileController@update', 'as' => 'profile-update'));
Route::post('/user/{username}/update', array('uses' => 'ProfileController@updatePost', 'as' => 'profile-update-post'));

Route::get('/user/{username}/change-password', array('uses' => 'ProfileController@changePassword', 'as' => 'change-password'));
Route::post('/user/{username}/change-password', array('uses' => 'ProfileController@changePasswordPost', 'as' => 'change-password-post'));

Route::get('search', array('uses'=> 'UserController@search', 'as' => 'getSearch'));

Route::get('friendrequest/{id}', array('uses' => 'ProfileController@sendRequest', 'as' => 'friend-request'));
Route::get('acceptfriendrequest/{id}', array('uses' => 'ProfileController@acceptRequest', 'as' => 'accept-friend-request'));
Route::get('cancelfriendrequest/{id}', array('uses' => 'ProfileController@cancelRequest', 'as' => 'cancel-friend-request'));

Route::group(array('prefix' => '/forum'), function()
{
	Route::get('/', array('uses' => 'ForumController@index', 'as' => 'forum-home'));
	Route::get('/category/{id}', array('uses' => 'ForumController@category', 'as' => 'forum-category'));
	Route::get('/thread/{id}', array('uses' => 'ForumController@thread', 'as' => 'forum-thread'));
	Route::get('/comment/{id}', array('uses' => 'ForumController@comment', 'as' => 'forum-comment'));

	Route::get('/thread/{id}/edit', array('uses' => 'ForumController@editThread', 'as' => 'forum-edit-thread'));
	Route::post('/thread/{id}/update', array('uses' => 'ForumController@updateThread', 'as' => 'forum-update-thread'));
	Route::get('/comment/{id}/edit', array('uses' => 'ForumController@editComment', 'as' => 'forum-edit-comment'));
	Route::post('/comment/{id}/update', array('uses' => 'ForumController@updateComment', 'as' => 'forum-update-comment'));

	Route::get('/thread/{id}/delete', array('uses' => 'ForumController@deleteThread', 'as' => 'forum-delete-thread'));
	Route::get('/comment/{id}/delete', array('uses' => 'ForumController@deleteComment', 'as' => 'forum-delete-comment'));

	Route::group(array('before' => 'admin'), function()
	{
		Route::get('/group/{id}/delete', array('uses' => 'ForumController@deleteGroup', 'as' => 'forum-delete-group'));
		Route::get('/category/{id}/delete', array('uses' => 'ForumController@deleteCategory', 'as' => 'forum-delete-category'));

		Route::group(array('before' => 'csrf'), function()
		{
			Route::post('/group', array('uses' => 'ForumController@storeGroup', 'as' => 'forum-store-group'));
		});
	});

	Route::group(array('before' => 'auth'), function()
	{
		Route::get('/category/{id}/new', array('uses' => 'ForumController@newCategory', 'as' => 'forum-get-new-category'));

		Route::group(array('before' => 'csrf'), function()
		{
			Route::post('/category/{id}/new', array('uses' => 'ForumController@storeCategory', 'as' => 'forum-store-category'));
		});
	});

	Route::group(array('before' => 'auth'), function()
	{
		Route::get('/thread/{id}/new', array('uses' => 'ForumController@newThread', 'as' => 'forum-get-new-thread'));

		Route::group(array('before' => 'csrf'), function()
		{
			Route::post('/thread/{id}/new', array('uses' => 'ForumController@storeThread', 'as' => 'forum-store-thread'));
		});
	});

	Route::group(array('before' => 'auth'), function()
	{
		Route::get('/comment/{id}/new', array('uses' => 'ForumController@newComment', 'as' => 'forum-get-new-comment'));

		Route::group(array('before' => 'csrf'), function()
		{
			Route::post('/thread/{id}', array('uses' => 'ForumController@storeComment', 'as' => 'forum-store-comment'));
		});
	});
});


Route::group(array('before' => 'guest'), function()
	{
		Route::get('create', array('uses' => 'UserController@getCreate', 'as' => 'getCreate'));
		Route::get('login', array('uses' => 'UserController@getLogin', 'as' => 'getLogin'));

		Route::group(array('before' => 'csrf'), function()
		{
			Route::post('create', array('uses' => 'UserController@postCreate', 'as' => 'postCreate'));
			Route::post('login', array('uses' => 'UserController@postLogin', 'as' => 'postLogin'));
			Route::post('update', array('uses' => 'UserController@postUpdate', 'as' => 'postUpdate'));
		});
	});

Route::group(array('before' => 'auth'), function()
{
	Route::get('logout', array('uses' => 'UserController@getLogout', 'as' => 'getLogout'));
});
