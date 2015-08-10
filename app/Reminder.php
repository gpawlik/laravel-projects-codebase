<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model{

	protected $table = 'reminders';

	protected $fillable = ['note','description','due_date'];

	public static function getPermissions()
	{
		return array(
      
		);
	}

}
