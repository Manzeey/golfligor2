@extends('layouts.master')

@sdection('head')
	@parent
	<title>Update Profile Page</title>
@stop

@section('content')
	<div class="container">
		<h1>Update your profile information.</h1>
		
		<form role="form" method="post" action="{{ URL::route('profile-update-post', $user->id) }}">
			
			<div class="form-group {{ ($errors->has('pass1')) ? ' has-error' : '' }}">
				<label for="profilepicture">Profile picture:</label>
				<p>A upload function is not available yet. Please write the search path to a picture (from internet).</p>
					<input id="profilepicture" name="profilepicture" type="text" class="form-control" value="{{ $user->profilepicture }}">
			</div>
			
			<div class="form-group {{ ($errors->has('username')) ? ' has-error' : '' }}">
				<label for="username">*Username:</label>
					<input id="username" name="username" type="text" class="form-control" value="{{ $user->username }}">
					@if($errors->has('username'))
						{{ $errors->first('username') }}
					@endif
			</div>
			
			<div class="form-group {{ ($errors->has('email')) ? ' has-error' : '' }}">
				<label for="email">*Email:</label>
					<input id="email" name="email" type="text" class="form-control" value="{{ $user->email }}">
					@if($errors->has('email'))
						{{ $errors->first('email') }}
					@endif
			</div>
			
			<div class="form-group {{ ($errors->has('pass1')) ? ' has-error' : '' }}">
				<label for="fname">First name:</label>
					<input id="fname" name="fname" type="text" class="form-control" value="{{ $user->fname }}">
			</div>
			
			<div class="form-group">
				<label for="lname">Last name:</label>
					<input id="lname" name="lname" type="text" class="form-control" value="{{ $user->lname }}">
			</div>
			
			<div class="form-group">
				<label for="moreInfo">About me:</label>
					<input id="moreInfo" name="moreInfo" type="text" class="form-control" value="{{ $user->moreInfo }}">
			</div>

			<div class="form-group">
				<label for="experience">Training experience:</label>
					<input id="experience" name="experience" type="text" class="form-control" value="{{ $user->experience }}">
			</div>
			
			<div class="form-group">
				<label for="favorite">Favorite training form/exercise:</label>
					<input id="favorite" name="favorite" type="text" class="form-control" value="{{ $user->favorite }}">
			</div>
			<p>* required information</p>
			{{ Form::token() }}
			<div class="form-group">
				<input type="submit" value="Save" class="btn btn-default">
			</div>
		</form>
	</div>	
@stop
