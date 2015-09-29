<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model{

	protected $table = 'roles';

	protected $fillable = ['role_name'];

	//define relationships
	public function user()
	{
		return $this -> hasMany("App\User");
	}

	public function permission()
	{
		return $this -> hasMany("App\Permission");
	}

	public static function getPermissions()
	{
		return array(
			"system_role_can_add",
			"system_role_can_edit",
			"system_role_can_delete",
			"system_role_can_view",
			"system_role_can_search",
			"system_role_can_permit"
		);
	}

}
