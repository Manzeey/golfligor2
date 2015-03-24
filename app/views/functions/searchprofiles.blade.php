@extends('layouts.master')

@section('head')
	@parent
	<title>Search Page</title>
@stop

@section('content')

<!-- SEARCH FUNCTION FOR PROFILES START -->

<?php
$name = Input::get('keyword');
?>
<div>
<h3>Profiles with "{{$name}}"</h3>
@if ($users->isEmpty())
	<p>No matching results for your search word, please try again.</p><!-- IF $USER IS EMPTY SHOW THIS-->
@else
	<ul>
		@foreach ($users as $user)<!-- ELSE SHOW RESULTS-->
			<li style="list-style:none;">
				<img src="{{ $user->profilepicture }}" id="threadprofilepic" style="width:40px;height:40px;">&nbsp;<a href="{{ URL::route('profile-user', $user->username) }}">{{$user->username}}</a>&nbsp;{{$user->fname}}&nbsp;{{$user->lname}}		
			</li>
			<br>
		@endforeach
	</ul>
@endif
<br>
<br>

</div>

<!-- SEARCH FUNCTION FOR PROFILES END -->

@stop