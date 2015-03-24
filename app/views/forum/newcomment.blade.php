@extends('layouts.master')

@section('head')
	@parent
	<title>Forum</title>
@stop

@section('content')
	<h1>Comment</h1>

	<form action="{{ URL::route('forum-store-comment', $id) }}" method="post">

		<div class="form-group">
			<label for="body">Body: </label>
			<textarea class="form-control" name="body" id="body"></textarea>
		</div>
		{{ Form::token() }}
		<div class="form-group">
			<input type="submit" value="Save Comment" class="btn btn-primary">
		</div>
	</form>
@stop