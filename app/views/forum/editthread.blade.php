@extends('layouts.master')

@section('head')
	@parent
	<title>Edit Thread</title>
@stop

@section('content')
	<h1>Edit thread</h1>

	<form action="{{ URL::route('forum-update-thread', $editthread->id) }}" method="post">
			<div class="form-group {{ ($errors->has('title')) ? ' has-error' : '' }}">
				<label for="title">*Title:</label>
					<input id="title" name="title" type="text" class="form-control" value="{{ $editthread->title }}">
					@if($errors->has('title'))
						{{ $errors->first('title') }}
					@endif
			</div>

	<div class="form-group {{ ($errors->has('body')) ? ' has-error' : '' }}">
			<label for="body">*Body:</label>
				<input id="body" name="body" type="text" class="form-control" value="{{ $editthread->body }}">
					@if($errors->has('body'))
						{{ $errors->first('body') }}
					@endif
		</div>
		<p>* required information</p>
		{{ Form::token() }}
		<div class="form-group">
			<input type="submit" value="Save Changes" class="btn btn-primary">
		</div>
	</form>
@stop