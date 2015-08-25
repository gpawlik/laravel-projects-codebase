<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Identification extends Model{

	protected $table = 'identification';

	protected $fillable = ['identification_name'];

	public static function getPermissions()
	{
		return array(
			"system_identification_can_add",
			"system_identification_can_edit",
			"system_identification_can_delete",
			"system_identification_can_view",
			"system_identification_can_search"
		);
	}

}
