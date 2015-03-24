@extends('layouts.master')

@section('head')
	@parent
	<title>Home Page</title>	
		
@stop

@section('content')
	@if(Session::has('success'))
		<div class="alert alert-success">{{ Session::get('success') }}</div>
	@elseif (Session::has('fail'))
		<div class="alert alert-danger">{{ Session::get('fail') }}</div>
	@endif
	<!-- VIDEO SLIDER -->
	<video autoplay loop muted class="bgvideo" id="bgvideo">
			<source src="video/Min Film2.mp4" type="video/mp4">
	</video>
		<div class="korg">
			<div class="block"></div>
			<div class="text">"How do you exercise? Share your knowledge here!"</div>	
		</div>

@stop
