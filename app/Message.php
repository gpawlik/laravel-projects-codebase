<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model{

	protected $table = 'messages';

	protected $fillable = ['subject','message','to_user_id','from_user_id'];

	public static function getPermissions()
	{
		return array(

		);
	}

}
