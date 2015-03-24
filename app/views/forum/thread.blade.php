@extends('layouts.master')

@section('head')
	@parent
	<title>Forum | {{ $thread->title }}</title>
@stop

@section('content')

<h1>{{ $thread->title }}</h1>
<h5><a href="{{ URL::route('forum-home') }}">{{ $group->title }}</a> > <a href="{{ URL::route('forum-category', $category->id) }}">{{ $category->title }}</a></h5>
<div class="panel panel-default">
	<div class="panel-heading"><h5>By: <a style="color:black;" href="{{ URL::route('profile-user', $author) }}">{{ $author }}</a> on {{ $thread->created_at }} @if(Auth::guest())  @elseif(Auth::check() && Auth::user()->isAdmin() || Auth::user()->id == $thread->author_id) <a href="{{ URL::route('forum-edit-thread', $thread->id) }}" class="btn btn-success btn-xs pull-right">Edit This</a> <a id="delecomment" href="{{ URL::route('forum-delete-thread', $thread->id ) }}" class="btn btn-danger btn-xs pull-right">Delete Thread</a> @endif</h5>
	</div>
	<div class="panel-body">
		<div class="row">
        <div class="col-sm-2 thread-comment">
			@if(Auth::check() && Auth::user()->id == $thread->author_id) <img id="threadprofilepic" src="{{ $authorpicture }}" height="150" width="150" style="border: solid 5px #4cae4c;"> @else <img id="threadprofilepic" src="{{ $authorpicture }}" height="150" width="150" style="border: solid 5px gray;"> @endif
			<h4><a href="{{ URL::route('profile-user', $author) }}">{{ ( user::find($thread->author_id)->username) }}</a></h4>
		</div>
		<div class="col-sm-9 col-sm-offset-0">
		<p>{{ nl2br(BBCode::parse($thread->body)) }}</p>
		</div>
	</div>
</div>
</div>


	@foreach($comments as $comment)
	
	<div class="panel panel-default">
	  	<div class="panel-heading"><h5>Respond by: <a style="color:black;" href="{{ URL::route('profile-user', user::find($comment->author_id)->username) }}">{{ user::find($comment->author_id)->username }}</a> on {{ $comment->created_at }} @if(Auth::guest())  @elseif(Auth::check() && Auth::user()->isAdmin() || Auth::user()->id == $comment->author_id)<a href="{{ URL::route('forum-edit-comment', $comment->id) }}" class="btn btn-success btn-xs pull-right">Edit This</a> <a id="delecomment" href="{{ URL::route('forum-delete-comment', $comment->id ) }}" class="btn btn-danger btn-xs pull-right">Delete Comment</a> @endif</h5></div>
	  	<div class="panel-body">
		<div class="row">
        <div class="col-sm-2 thread-comment">
		@if(Auth::check() && Auth::user()->id == $comment->author_id)<img id="threadprofilepic" src="{{ ( user::find($comment->author_id)->profilepicture) }}" height="150" width="150" style="border: solid 5px #4cae4c;"> @else <img id="threadprofilepic" src="{{ ( user::find($comment->author_id)->profilepicture) }}" height="150" width="150" style="border: solid 5px gray;"> @endif
		<h4><a href="{{ URL::route('profile-user', user::find($comment->author_id)->username) }}">{{ ( user::find($comment->author_id)->username) }}</a></h4>
		</div>
		<div class="col-sm-9 col-sm-offset-0">
		{{ $comment->body }}
		</div>
	</div>
</div>
</div>
	@endforeach

	<div class"pull-right">{{ $comments->links() }}</div>

@if(Auth::check())
	<a href="{{ URL::route('forum-get-new-comment', $thread->id) }}" class="btnboxgreen">Add comment</a>
@endif

@stop
