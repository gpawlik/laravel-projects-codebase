<?php namespace App\Application\Role\Repositories;

use Illuminate\Http\Request;
use App\Role;

class RoleRepository
{
	/**
	* This class is the repository for all roles queries
	*/

	public static function getAllRoles()
	{
		return Role::all();
	}

	public static function getAllRolesPaginated($pages)
	{
		return Role::orderBy("updated_at","DESC")->paginate($pages);
	}

	public static function getRole($id)
	{
		return Role::find($id);
	}

	// public static function getWhere($fieldName,$id,$mode)
	// {
	// 	if($mode == "MODEL_MODE")
	// 	{
	// 		return Role::where($fieldName,$id);
	// 	}
	// 	else if($mode == "DATA_MODE")
	// 	{
	// 		return Role::where($fieldName,$id)->get();
	// 	}
	// 	else
	// 	{
	// 		return null;
	// 	}
	// }

	public static function saveRole(Request $request,$id = null)
	{
		$role = ( $id == null ? new Role : self::getRole($id) );

        $role -> role_name = $request -> input("role_name");

        $role -> save();
	}

}