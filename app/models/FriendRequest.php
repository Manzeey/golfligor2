<?php

class Friendrequest extends Eloquent
{
	protected $table = 'friend_request';

	public function sendRequest()
	{
		$this->belongsTo('Friendrequest');
	}

}