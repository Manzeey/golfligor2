<?php

class UserController extends BaseController
{
	//gets the view for the register page
	public function getCreate()
	{
		return View::make('user.register');
	}

	//gets the view for the login page
	public function getLogin()
	{
		return View::make('user.login');
	}
	//gets the view for the search results
	public function search()
	{
		if (Input::get('search') === 'profiles')
		{
		$validate = Validator::make(Input::all(), array(
			'keyword' => 'required'));
			
		if ($validate->fails())
		{
			return Redirect::back()->with('fail', 'You have to write something into the search field, please try again.');
		}
		$name = Input::get('keyword');
		$users = user::where('username', 'LIKE', "%$name%")->get();
		

		return View::make('functions.searchprofiles')->with('users', $users);
		}
		else if (Input::get('search') === 'threads')
		{
			$validate = Validator::make(Input::all(), array(
			'keyword' => 'required'));
			
			if ($validate->fails())
			{
				return Redirect::back()->with('fail', 'You have to write something into the search field, please try again.');
			}
				$name = Input::get('keyword');
				$threads = DB::table('forum_threads')->where('title', 'LIKE', "%$name%")->get();
					
				return View::make('functions.searchthreads')->with('threads', $threads);
		}
	}
	
	//function for registering a profile
	public function postCreate()
	{
		$validate = Validator::make(Input::all(), array(
			'username' => 'required|unique:users|min:4',
			'pass1' => 'required|min:6',
			'pass2' => 'required|same:pass1',
			'email' => 'required|unique:users'
			));

		if ($validate->fails())
		{
			return Redirect::route('getCreate')->withErrors($validate)->withInput();
		}
		else
		{
			$user = new User();
			$user->username = Input::get('username');
			$user->password = Hash::make(Input::get('pass1'));
			$user->email = Input::get('email');

			if ($user->save())
			{
				return Redirect::route('home')->with('success', 'You registed successfully. You can now login.');
			}
			else
			{
				return Redirect::route('home')->with('fail', 'An error occured while creating the user. Please try again.');
			}
		}
	}
	
	//function for login profile
	public function postLogin()
	{
		$validator = Validator::make(Input::all(), array(
		'username' => 'required',
		'pass1' => 'required'
		));
		
		if($validator->fails())
		{
			return Redirect::route('getLogin')->withErrors($validator)->withInput();
		}
		else
		{
			$remember = (Input::has('remember')) ? true : false;

			$auth = Auth::attempt(array(
				'username' => Input::get('username'),
				'password' => Input::get('pass1')
				), $remember);

			if($auth)
			{
				return Redirect::intended('/');
			}
			else
			{
				return Redirect::route('getLogin')->with('fail', 'You entered the wrong login credentials, please try again!');
			}
		}
	}
	
	//function for logout profile
	public function getLogout()
	{
		Auth::logout();
		return Redirect::route('home');
	}
}