@extends('layouts.master')

@section('content')

<!-- USER PROFILE -->

<div class="container">
	<div class="row">
		<div class="col-sm-1 col-md-4 profile-div-style">
			<div class="thumbnail profile-padding">
			<br>

			<!-- SHOW USERNAME AND PROFILEPICTURE -->

			<img src="{{ $user->profilepicture }}" id="threadprofilepic" style="width:180px;height:180px;">

				<div class="caption">
				<h3>{{ $user->username }}</h3>@if(Auth::user()->username == $user->username) <p style="color: green">Online</p> @else <p style="color: red">Offline</p> @endif
					
					<!-- LIST USER INFORMATION -->

					<table>
						<tr>
							<td class="td-padding-top"><b>Member since:</b></td>
							<td class="td-padding">{{ $user->created_at }}</td>
						</tr>
						<tr>
							<td class="td-padding-top"><b>First name:</b></td>
							<td class="td-padding">{{$user->fname}}</td>
						</tr>
						<tr>
							<td class="td-padding-top"><b>Last name:</b></td>
							<td class="td-padding">{{$user->lname}}</td>
						</tr>
						<tr>
							<td class="td-padding-top"><b>Email:</b></td>
							<td class="td-padding">{{$user->email}}</td>
						</tr>
					</table>
				<br>

				<!-- IF USER AND VISITORS ARE NOT FRIENDS THEN DO NOTHING OR ELSE SHOW SEND FRIEND REQUEST BTN -->

				@if(is_null($wefriends))

					@if(is_null($request))<a href="{{ URL::route('friend-request', $user->id )}}" class="btn btn-primary" role="button">Send friend request</a> @else <a href="{{ URL::route('cancel-friend-request', $request->id )}}" class="btn btn-primary" role="button">Cancel</a> @endif
				
				@elseif($wefriends->first_friend_id == Auth::user()->id)

				@elseif($wefriends->second_friend_id == Auth::user()->id) 
				
				@else
					
					@if( Auth::user()->username == $user->username)<a href="{{ URL::route('profile-update', $user->username) }}" class="pull-right">Edit profile</a>
					<a href="{{ URL::route('change-password', $user->username) }}">Change password</a>@else  @if(is_null($request))
					<a href="{{ URL::route('friend-request', $user->id )}}" class="btn btn-primary" role="button">Send friend request</a> 
					@else <a href="{{ URL::route('cancel-friend-request', $request->id )}}" class="btn btn-primary" role="button">Cancel</a> 
					@endif @endif @endif
				
				<!-- IF USER IS ON HIS/HER PROFILE ONLY SHOW EDIT BTN AND CHANGE PASSWORD BTN -->

				@if( Auth::user()->username == $user->username)<a href="{{ URL::route('profile-update', $user->username) }}" class="pull-right">Edit profile</a><a href="{{ URL::route('change-password', $user->username) }}">Change password</a>@else  @endif
				
				</div>
			</div>
		</div>
	<div class="col-sm-1 col-md-6 profile-div-style col-sm-offset-1">
		<div class="caption">

					<!-- CHECK IF USER HAVE A FRIEND REQUEST -->

					@if(is_null($uhaverequest))

					@else
					<?php
					$requsername = DB::table('users')->where('id', '=', $uhaverequest->requester_id)->first();
					?>

						<div><h4>You have a friend request from {{ $requsername->username }} <a href="{{ URL::route('accept-friend-request', $uhaverequest->id )}}">accept</a> | <a href="{{ URL::route('cancel-friend-request', $uhaverequest->id )}}">decline</a></h4></div>

					@endif


				<!-- LIST USER ABOUT, EXPERIENCE, FAVEROITE FORM/EXERCISE -->
				
		<h3>Information about {{ $user->username }}</h3>
			<br>
				<p><b>About me:</b></p>
				<p>{{$user->moreInfo}}</p>
				<br>
				<p><b>Training experience:</b></p>
				<p>{{$user->experience}}</p>
				<br>
				<p><b>Favorite training form/exercise:</b></p>
				<p>{{$user->favorite}}</p>
		</div>
	</div>

		<!-- SHOW USER FRIEND LIST -->

		<div class="col-sm-1 col-md-1 profile-div-style col-sm-offset-1">
		@if(is_null($friends))
				
		@else

		<h4 class="friendstitle">{{ $friendcount }} Friends</h4>
		<ul>

		<!-- GET FRIEND USERNAME -->

		@foreach($friends as $friend)
		<?php

		$firstname = DB::table('users')->where('id', '=', $friend->first_friend_id)->select('username', 'profilepicture')->first();
		$secondname = DB::table('users')->where('id', '=', $friend->second_friend_id)->select('username', 'profilepicture')->first();

		?>

		@if($friend->first_friend_id === $user->id)
			<li><img id="menuprofilepic" src="{{ $secondname->profilepicture }}" height="40px" width="40px"/><a href="{{ URL::route('profile-user', $secondname->username) }}">{{ $secondname->username }}</li></a>
			<br>
			
			@elseif($friend->second_friend_id === $user->id)
			<li><img id="menuprofilepic" src="{{ $firstname->profilepicture }}" height="40px" width="40px"/><a href="{{ URL::route('profile-user', $firstname->username) }}">{{ $firstname->username }}</li></a>
			<br>
			
			@else

			
			@endif
			@endforeach
		</ul>
		@endif
	</div>
@stop