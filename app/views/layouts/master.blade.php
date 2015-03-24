<!doctype html>
<html lang="en">
<head>

	<!-- LIST OF LINKS TO CSS & BOOTSTRAP -->

	@section('head')
	<meta charset="UTF-8">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">

</head>
<body>

<!-- IF USER IS LOGGEDIN GET INFORMATION FROM DB -->
@if(Auth::check())
<?php
$countrequest = DB::table('friend_request')->where('target_id', '=', Auth::user()->id)->count();
?>
@endif

<!-- START FORUM MENU (NAVBAR) -->

	<div class="navbar">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
					<span class="icon-bar"></span> 
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="{{ URL::route('home') }}" class="navbar-brand">Fitness Forum</a>
			</div>
			<div class="navbar-collapse collapse navbar-responsive-collapse">
			<ul class="nav navbar-nav">
				@if(Auth::check())
				<li><a href="{{ URL::route('profile-user', Auth::user()->username) }}"><img id="menuprofilepic" src="{{ Auth::user()->profilepicture }}" height="20px" width="20px"/> {{ Auth::user()->username }} @if($countrequest === 0) @else <span class="badge">{{ $countrequest }}</span> @endif</a></li>
				@endif
				<li><a href="{{ URL::route('forum-home') }}">Forums</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				@if(!Auth::check())
					<li><a href="{{ URL::route('getCreate') }}">Register</a></li>
					<li><a href="{{ URL::route('getLogin') }}">Login</a></li>
				@else
					<li>
					<form role="form" method="get" action="{{ URL::route('getSearch') }}" style="float:left;">
							<input type="text" class="form-control" name="keyword" placeholder="Search" style="float:left; width:150px; margin-top:8px;">		
							<button type="submit" class="btn btn-default" style="float:left; margin-top:8px; margin-right:10px;"><span class="glyphicon icon-search"></span></button>
							<input type="radio" id="" name="search" value="profiles" style="float:left; margin-top:18px; margin-right:1px;">
							<label for="profiles" style="float:left; margin-top:15px; margin-right:10px;">Profiles</label>
							<input type="radio" id="" name="search" value="threads" checked="on"style="float:left; margin-top:18px; ">
							<label for="threads" style="float:left; margin-top:15px; margin-right:10px;">Threads</label>
					</form>
					</li>
					<li><a href="{{ URL::route('getLogout') }}">Logout</a></li>
				@endif
			</ul>
		</div>
		</div>
	</div>

	<!-- END FORUM MENU (NAVBAR) -->

	<!-- START SHOW MESSGES IF ACTION IS SUCCESS OR FAIL -->

	@if(Session::has('success'))
		<div class="alert alert-success">{{ Session::get('success') }}</div>
	@elseif (Session::has('fail'))
		<div class="alert alert-danger">{{ Session::get('fail') }}</div>
	@endif

	<!-- END SHOW MESSGES IF ACTION IS SUCCESS OR FAIL -->


	<div class="container">@yield('content')</div>


	<!-- SCRIPT -->

	@section('javascript')
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"><!--Link till Bootstrap1-->
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script><!--Bootstrap5-->
	
	<script>
			var video = document.getElementById('bgvideo').playbackRate = 0.7;	
	</script>
	
	@show
</body>
</html>
