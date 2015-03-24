<?php

class ForumController extends BaseController
{


	public function editthread($id)
	{
		$editthread = DB::table('forum_threads')->where('id', '=', $id);

		if($editthread->count()) {
			$editthread = $editthread->first();
			return View::make('forum.editthread')->with('editthread', $editthread);
		}
	}

		public function updateThread($id)
	{
		$validate = Validator::make(Input::all(), array(
			'title' => 'required|min:4',
			'body' => 'required|min:5',
		));
		$updatethread = ForumThread::find($id);
		if ($validate->fails())
		{
			return Redirect::route('forum-edit-thread', $updatethread->id)->withErrors($validate)->withInput();
		}
		else
		{
			$updatethread = ForumThread::find($id);
			$updatethread->title = Input::get('title');
			$updatethread->body = Input::get('body');

		}
			if ($updatethread->save())
			{
				return Redirect::route('forum-thread', $updatethread->id)->with('success', 'Your thread has been updated.');
			}
			else
			{
				return Redirect::route('home')->with('fail', 'An error occured while editing the thread. Please try again.');
			}
	}

		public function editcomment($id)
	{
		$editcomment = DB::table('forum_comments')->where('id', '=', $id);

		if($editcomment->count()) {
			$editcomment = $editcomment->first();
			return View::make('forum.editcomment')->with('editcomment', $editcomment);
		}
	}

		public function updateComment($id)
		{
		$validate = Validator::make(Input::all(), array(
			'body' => 'required|min:5',
		));
		$updatecomment = ForumThread::find($id);
		if ($validate->fails())
		{
			return Redirect::route('forum-edit-comment', $updatecomment->id)->withErrors($validate)->withInput();
		}
		else
		{
			$updatecomment = ForumComment::find($id);
			$updatecomment->body = Input::get('body');

		}
			if ($updatecomment->save())
			{
				return Redirect::route('forum-thread', $updatecomment->thread_id)->with('success', 'Your comment has been updated.');
			}
			else
			{
				return Redirect::route('home')->with('fail', 'An error occured while editing the comment. Please try again.');
			}
	}

	public function group($id)
	{
		$group = ForumGroup::find($id);
		if ($group == null)
		{
			return Redirect::route('forum-home')->with('fail', "That group doesn't exist.");
		}

		return View::make('forum.index')->with('group', $group);
	}

	public function index()
	{
		$groups = ForumGroup::all();
		$categories = ForumCategory::all();
		
		return View::make('forum.index')->with('groups', $groups)->with('categories', $categories);
	}

	public function category($id)
	{
		$category = ForumCategory::find($id);
		
		if ($category == null)
		{
			return Redirect::route('forum-home')->with('fail', "That category doesn't exist.");
		}
		$group = DB::table('forum_groups')->where('id', $category->group_id)->first();
		
		$threads = $category->threads()->get();
		$getdate = (new DateTime)->format('Y-m-d H:i:s');
		
		return View::make('forum.category')->with('category', $category)->with('threads', $threads)->with('group', $group);
	}

	public function thread($id)
	{
		$thread = ForumThread::find($id);
		if ($thread == null)
		{
			return Redirect::route('forum-home')->with('fail', "That thread doesn't exist.");
		}

		$group = DB::table('forum_groups')->where('id', $thread->group_id)->first();
		$category = DB::table('forum_categories')->where('id', $thread->category_id)->first();

		$url = 'http://localhost/forum/public/forum/thread/'.$id.'?page=1';

		$author = $thread->author()->first()->username;
		$authorpicture = $thread->author()->first()->profilepicture;
		$comments = $thread->comments()->paginate(7);		
		$views = DB::table('forum_threads')->where('id' , $id)->increment('views');
		
		return View::make('forum.thread')->with('thread', $thread)->with('id', $id)->with('author', $author)->with('authorpicture', $authorpicture)->with('comments', $comments)->with('category', $category)->with('group', $group)->with('url', $url);
	}

	public function storeGroup()
	{
		$validator = Validator::make(Input::all(), array(
			'group_name' => 'required|unique:forum_groups,title'
		));
		if ($validator->fails())
		{
			return Redirect::route('forum-home')->withInput()->withErrors($validator)->with('modal', '#group_form');
		}
		else
		{
			$group = new ForumGroup;
			$group->title = Input::get('group_name');
			$group->author_id = Auth::user()->id;

			if($group->save())
			{
				return Redirect::route('forum-home')->with('success', 'The group was created');
			}
			else
			{
				return Redirect::route('forum-home')->with('fail', 'An error occured while saving the new group.');
			}
		}
	}

	public function deleteGroup($id)
	{
		$group = ForumGroup::find($id);
		if($group == null)
		{
			return Redirect::route('forum-home')->with('fail', 'That group doesn\'t exist.');
		}

		$categories = ForumCategory::where('group_id', $id);
		$threads = ForumThread::where('group_id', $id);
		$comments = ForumComment::where('group_id', $id);

		$delCa = true;
		$delT = true;
		$delCo = true;

		if($categories->count() > 0)
		{
			$delCa = $categories->delete();
		}
		if($threads->count() > 0)
		{
			$delT = $threads->delete();
		}
		if($comments->count() > 0)
		{
			$delCo = $comments->delete();
		}


		if ($delCa && $delT && $delCo && $group->delete())
		{
			return Redirect::route('forum-home')->with('success', 'The group was deleted.');
		}
		else
		{
			return Redirect::route('forum-home')->with('fail', 'An error occured while deleting the group.');
		}
	}

	public function deleteCategory($id)
	{
		$category = ForumCategory::find($id);
		if($category == null)
		{
			return Redirect::route('forum-home')->with('fail', 'That category doesn\'t exist.');
		}

		$threads = $category->threads();
		$comments = $category->comments();

		$delT = true;
		$delCo = true;

		if($threads->count() > 0)
		{
			$delT = $threads->delete();
		}
		if($comments->count() > 0)
		{
			$delCo = $comments->delete();
		}


		if ($delT && $delCo && $category->delete())
		{
			return Redirect::route('forum-home')->with('success', 'The category was deleted.');
		}
		else
		{
			return Redirect::route('forum-home')->with('fail', 'An error occured while deleting the category.');
		}
	}

	public function deleteThread($id)
	{
		$thread = ForumThread::find($id);
		if($thread == null)
		{
			return Redirect::route('forum-category', $thread->category_id)->with('fail', 'That thread doesn\'t exist.');
		}

		$comments = $thread->comments();

		$delCo = true;

		if($comments->count() > 0)
		{
			$delCo = $comments->delete();
		}

		if ($delCo && $thread->delete())
		{
			return Redirect::route('forum-category', $thread->category_id)->with('success', 'The thread was deleted.');
		}
		else
		{
			return Redirect::route('forum-category', $thread->category_id)->with('fail', 'An error occured while deleting the thread.');
		}
	}

	public function deleteComment($id)
	{
		$comment = ForumComment::find($id);
		if($comment == null)
		{
			return Redirect::route('forum-thread', $comment->thread_id)->with('fail', 'That comment doesn\'t exist.');
		}
		
		if ($comment->delete())
		{
			return Redirect::route('forum-thread', $comment->thread_id)->with('success', 'The comment was deleted.');
		}
		else
		{
			return Redirect::route('forum-thread', $comment->thread_id)->with('fail', 'An error occured while deleting the comment.');
		}
	}

	public function newCategory($id)
	{
		return View::make('forum.newcategory')->with('id', $id);
	}

	public function storeCategory($id)
	{
		$group = ForumGroup::find($id);
		if ($group == null)
			Redirect::route('forum-get-new-category')->with('fail', "You posted to an invalid category.");

		$validator = Validator::make(Input::all(), array(
			'title' => 'required|min:3|max:255',
		));

		if ($validator->fails())
		{
			return Redirect::route('forum-get-new-category', $id)->withInput()->withErrors($validator)->with('fail', "Your input doesn't match the requirements");
		}
		else
		{

			$category = new ForumCategory;
			$category->title = Input::get('title');
			$category->author_id = Auth::user()->id;
			$category->group_id = $id;

			if($category->save())
			{
				return Redirect::route('forum-home')->with('success', 'The category was created');
			}
			else
			{
				return Redirect::route('forum-home')->with('fail', 'An error occured while saving the new category.');
			}
		}
	}

	public function newThread($id)
	{
		return View::make('forum.newthread')->with('id', $id);
	}

	public function storeThread($id)
	{
		$category = ForumCategory::find($id);
		if ($category == null)
			Redirect::route('forum-get-new-thread')->with('fail', "You posted to an invalid category.");

		$validator = Validator::make(Input::all(), array(
			'title' => 'required|min:3|max:255',
			'body'  => 'required|min:10|max:65000'
		));

		if ($validator->fails())
		{
			return Redirect::route('forum-get-new-thread', $id)->withInput()->withErrors($validator)->with('fail', "Your input doesn't match the requirements");
		}
		else
		{
			$thread = new ForumThread;
			$thread->title = Input::get('title');
			$thread->body = Input::get('body');
			$thread->category_id = $id;
			$thread->group_id = $category->group_id;
			$thread->author_id = Auth::user()->id;

			if ($thread->save())
			{
				return Redirect::route('forum-thread', $thread->id)->with('success', "Your thread has been saved.");
			}
			else
			{
				return Redirect::route('forum-get-new-thread', $id)->with('fail', "An error occured while saving your thread.")->withInput();
			}
		}
	}

	public function newComment($id)
	{
		return View::make('forum.newcomment')->with('id', $id);
	}

	public function storeComment($id)
	{
		$category = ForumCategory::find($id);
		$thread = ForumThread::find($id);
		if ($thread && $category == null)
			Redirect::route('forum-get-new-comment')->with('fail', "You posted to an invalid comment.");

		$validator = Validator::make(Input::all(), array(
			'body'  => 'required|min:5|max:65000'
		));

		if ($validator->fails())
		{
			return Redirect::route('forum-get-new-comment', $id)->withInput()->withErrors($validator)->with('fail', "Your input doesn't match the requirements");
		}
		else
		{
			
			$comment = new ForumComment;
			$comment->body = Input::get('body');
			$comment->category_id = $thread->category_id;
			$comment->thread_id = $thread->id;
			$comment->group_id = $thread->group_id;
			$comment->author_id = Auth::user()->id;
		
			if ($comment->save())
			{
				return Redirect::route('forum-thread', $thread->id)->with('success', "Your comment has been saved.");
			}
			else
			{
				return Redirect::route('forum-get-new-comment', $id)->with('fail', "An error occured while saving your comment.")->withInput();
			}
		}
	}
}
