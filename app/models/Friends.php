<?php

class Friends extends Eloquent
{
	protected $table = 'friends';

	public function acceptRequest()
	{
		$this->belongsTo('Friends');
	}

}