@extends('layouts.master')

@section('head')
	@parent
	<title>Edit comment</title>
@stop

@section('content')
	<h1>Edit comment</h1>

	<form action="{{ URL::route('forum-update-comment', $editcomment->id) }}" method="post">
	<div class="form-group {{ ($errors->has('body')) ? ' has-error' : '' }}">
			<label for="body">*Body:</label>
				<input id="body" name="body" type="text" class="form-control" value="{{ $editcomment->body }}">
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