@extends('layouts.master')

@section('head')
	@parent
	<title>Forum | {{ $category->title }}</title>
@stop

@section('content')

<br>
<br>
<h5><a href="{{ URL::route('forum-home') }}">{{ $group->title }}</a></h5>
<div class="panel panel-primary">
	<div class="panel-heading">
		@if(Auth::check() && Auth::user()->isAdmin())
		<div class="clearfix">
			<h3 class="panel-title pull-left">{{ $category->title }}</h3>
			<a href="{{ URL::route('forum-get-new-thread', $category->id) }}" class="btn btn-success btn-xs pull-right">New Thread</a>
			<a id="{{ $category->id }}" href="#" data-toggle="modal" data-target="#category_delete" class="btn btn-danger btn-xs pull-right delete_category">Delete</a>
		</div>
		@else
		<div class="clearfix">
			<h3 class="panel-title pull-left">{{ $category->title }}</h3>
			<a href="{{ URL::route('forum-get-new-thread', $category->id) }}" class="btn btn-success btn-xs pull-right">New Thread</a>
		</div>
		@endif
	</div>
	<div class="panel-body panel-list-group">
		<div class="list-group">
			@foreach($threads as $thread)
				<?php
					$lastcomment = DB::table('forum_comments')->where('thread_id', $thread->id)->first();
				?>
				@if (is_null($lastcomment))
				<?php
					$countcomments = DB::table('forum_comments')->where('thread_id', $thread->id)->count();		
				?>
					<a href="{{ URL::route('forum-thread', $thread->id) }}" class="list-group-item">{{ $thread->title }}<p class="pull-right">{{$countcomments}} comments || {{ $thread->views }} views || {{ $thread->created_at->format('Y-m-d H:i') }}</p></a>
				@else
				<?php
					$countcomments = DB::table('forum_comments')->where('thread_id', $thread->id)->count();		
					$lastcomment = DB::table('forum_comments')->where('thread_id', $thread->id)->orderBy('created_at', 'desc')->first();	
					$author = DB::table('users')->where('id', $lastcomment->author_id)->first();
				?>
					<a href="{{ URL::route('forum-thread', $thread->id) }}" class="list-group-item">{{ $thread->title }}<p class="pull-right">Last comment: {{$lastcomment->created_at}} by {{$author->username}} || {{$countcomments}} comments || {{ $thread->views }} views || {{ $thread->created_at->format('Y-m-d H:i') }}</p></a>
				@endif
			@endforeach
		</div>
	</div>
</div>

@if(Auth::check() && Auth::user()->isAdmin())
<div class="modal fade" id="category_delete" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-dissen="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Delete Category</h4>
			</div>
			<div class="modal-body">
				<h3>Are you sure you want to delete this category.</h3>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<a href="{{ URL::route('forum-delete-category', $category->id )}}" type="button" class="btn btn-primary" id="btn_delete_category">Delete</a>
			</div>
		</div>
	</div>
</div>
@endif
@stop

@section('javascript')
	@parent
	<script type="text/javascript" src="js/app.js"></script>
@stop