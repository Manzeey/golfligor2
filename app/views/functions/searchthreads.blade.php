@extends('layouts.master')

@section('head')
	@parent
	<title>Search Page</title>
@stop

@section('content')

<!-- SEARCH FUNCTION FOR THREADS START -->

<?php
$name = Input::get('keyword');
?>
<div>
<h3>Threads with "{{$name}}"</h3>
@if (empty($threads)) 
	<p>No matching results for your search word, please try again.</p><!-- IF $THREADS IS EMPTY SHOW THIS-->
@else
	<ul>
		@foreach ($threads as $thread)<!-- ELSE SHOW RESULTS-->
			<li style="list-style:none;">
				<a href="{{ URL::route('forum-thread', $thread->id) }}">{{$thread->title}}</a>
			</li>
			<br>
		@endforeach
	</ul>
@endif
<br>
<br>

</div>

<!-- SEARCH FUNCTION FOR THREADS END -->

@stop