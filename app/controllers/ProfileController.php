<?php

class ProfileController extends BaseController {
	//function what to display for guests and users
	public function user($username)
	{
		$user = User::where('username', '=', $username);
	//function check if loged in or guest, redirect guest to login page
	if(Auth::guest()) {
		return View::make('user.login')->with('fail', 'Please login to view user profile');
	}
	//function show friend statement 
	if($user->count()) {
		$user = $user->first();

		$request = DB::table('friend_request')->where('target_id', $user->id)->first();
		$uhaverequest = DB::table('friend_request')->where('target_id', Auth::user()->id)->first();
		$friends = DB::table('friends')->where('first_friend_id', '=', $user->id)->orWhere('second_friend_id', '=', $user->id)->paginate(5);
		$friendcount = DB::table('friends')->where('first_friend_id', '=', $user->id)->orWhere('second_friend_id', '=', $user->id)->count();
		$wefriends = DB::table('friends')->where('first_friend_id', '=', $user->id)->orwhere('second_friend_id', '=', $user->id)->first();

		return View::make('profile.user')->with('user', $user)->with('request', $request)->with('uhaverequest', $uhaverequest)->with('friends', $friends)->with('friendcount', $friendcount)->with('wefriends', $wefriends);
		} 

	}
	//function show	update page, pushed with username
	public function update($username)
	{
		$user = User::where('username', '=', $username);

		if($user->count()) {
			$user = $user->first();
			return View::make('profile.update')->with('user', $user);
		}
	}
	//function show	changepassword page, pushed with username
	public function changePassword($username)
	{
		$user = User::where('username', '=', $username);

		if($user->count()) {
			$user = $user->first();
			return View::make('profile.changepassword')->with('user', $user);
		}
	}
	//function post and update the users profile information
	public function updatePost($id)
	{
		$validate = Validator::make(Input::all(), array(
			'username' => 'required|min:4',
			'email' => 'required|email',
		));
		$user = User::find($id);
		if ($validate->fails())
		{
			return Redirect::route('profile-update', $user->username)->withErrors($validate)->withInput();
		}
		else
		{
			$user = User::find($id);
			$user->username = Input::get('username');
			$user->email = Input::get('email');
			$user->fname = Input::get('fname');
			$user->lname = Input::get('lname');
			$user->favorite = Input::get('favorite');
			$user->experience = Input::get('experience');
			$user->moreInfo = Input::get('moreInfo');
			$user->profilepicture = Input::get('profilepicture');
			
		}
			if ($user->save())
			{
				return Redirect::route('profile-user', $user->username)->with('success', 'Your profile information has been updated.');
			}
			else
			{
				return Redirect::route('home')->with('fail', 'An error occured while updating the user. Please try again.');
			}
	}
	//function post and update the users password
	public function changePasswordPost($id)
	{
		$validate = Validator::make(Input::all(), array(
		'oldpassword'		=> 'required',
		'password' 			=> 'required|min:6',
		'passwordconfirmed' => 'required|same:password'
		));
		
		$user = User::find($id);
		if ($validate->fails())
		{
			return Redirect::route('change-password', $user->username)->withErrors($validate);
		}
		else
		{
			$user = User::find(Auth::user()->id);
			
			$oldpassword = Input::get('oldpassword');
			$password = Input::get('password');
			
			if(Hash::check($oldpassword, $user->getAuthPassword())) {
				$user->password = Hash::make($password);
				
				if($user->save()) {
					return Redirect::route('profile-user', $user->username)->with('success', 'Your password has been changed.');
				}
			} else {
				return Redirect::route('change-password', $user->username)->with('fail', 'Your old password is incorrect.');
			}
		}
		
		return Redirect::route('change-password', $user->username)->with('global', 'Your password could not be changed.');
	}
	//function send a friend request
	public function sendRequest($id)
	{
		
		$user = User::find($id);

			$request = new Friendrequest;
			$request->requester_id = Auth::user()->id;
			$request->target_id = $user->id;
			$request->isRequested = 1;

			if ($request->save())
			{
				return Redirect::route('profile-user', $user->username)->with('success', 'Your Request is on its way.');
			}
			else
			{
				return Redirect::route('profile-user', $user->username)->with('fail', 'An error occured while sending request. Please try again.');
			}
	}
	//function cancel a friend request
	public function cancelRequest($id)
	{
		$cancelrequest = Friendrequest::find($id);
		if($cancelrequest = null)
		{
			return Redirect::route('forum-home')->with('fail', 'That comment doesn\'t exist.');
		}


		if (DB::table('friend_request')->where('id', '=', $id)->delete())
		{
			return Redirect::route('forum-home')->with('success', 'The comment was deleted.');
		}
		else
		{
			return Redirect::route('forum-home')->with('fail', 'An error occured while deleting the comment.');
		}
	}
	//function accept a friend request
	public function acceptRequest($id)
	{
		
		$requestinfo = Friendrequest::find($id);

			$friends = new Friends;
			$friends->first_friend_id = $requestinfo->requester_id;
			$friends->second_friend_id = $requestinfo->target_id;

			if ($friends->save())
			{
				DB::table('friend_request')->where('id', '=', $id)->delete();
				return Redirect::route('profile-user', Auth::user()->username)->with('success', 'Friend added.');
			}
			else
			{
				return Redirect::route('profile-user', Auth::user()->username)->with('fail', 'An error occured while sending request. Please try again.');
			}
	}
}