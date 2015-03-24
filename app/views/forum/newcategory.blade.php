@extends('layouts.master')

@section('head')
	@parent
	<title>New Category</title>
@stop

@section('content')
	<div class="container">
	<h1>New Category</h1>

	<form action="{{ URL::route('forum-store-category', $id) }}" method="post">
		<div class="form-group">
			<label for="title">Title: </label>
			<input type="text" class="form-control" name="title" id="title">
		</div>

		{{ Form::token() }}
		<div class="form-group">
			<input type="submit" value="Save Category" class="btn btn-primary">
		</div>
	</form>
</div>
@stop