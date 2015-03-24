@extends('layouts.master')

@section('head')
	@parent
	<title>Change Password Page</title>
@stop

@section('content')
	<div class="container">
		<h1>Change your password.</h1>
		<form role="form" method="post" action="{{ URL::route('change-password-post', $user->id) }}">
			<div class="form-group {{ ($errors->has('username')) ? ' has-error' : '' }}">
				<label for="oldpassword">*Old Password:</label>
					<input id="oldpassword" name="oldpassword" type="password" class="form-control">
					@if($errors->has('oldpassword'))
						{{ $errors->first('oldpassword') }}
					@endif
			</div>
			
			<div class="form-group {{ ($errors->has('email')) ? ' has-error' : '' }}">
				<label for="password">*New Password:</label>
					<input id="password" name="password" type="password" class="form-control">
					@if($errors->has('password'))
						{{ $errors->first('password') }}
					@endif
			</div>
			
			<div class="form-group {{ ($errors->has('pass1')) ? ' has-error' : '' }}">
				<label for="passwordconfirmed">*Confirm New Password:</label>
					<input id="passwordconfirmed" name="passwordconfirmed" type="password" class="form-control">
					@if($errors->has('passwordconfirmed'))
						{{ $errors->first('passwordconfirmed') }}
					@endif
			</div>
			
			<p>* required information</p>
			{{ Form::token() }}
			<div class="form-group">
				<input type="submit" value="Change Password" class="btn btn-default">
			</div>
		</form>
	</div>	
@stop
