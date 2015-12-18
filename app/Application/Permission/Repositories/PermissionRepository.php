<?php namespace App\Application\Permission\Repositories;

use Illuminate\Http\Request;
use App\Permission;

class PermissionRepository
{
	/**
	* This class is the repository for all permission queries
	*/
	public static function getAllPermissions()
	{
		return Permission::all();
	}

	public static function getAllPermissionsPaginated($pages)
	{
		return Permission::orderBy("permission_name","ASC")->paginate($pages);
	}

	public static function getPermission($id)
	{
		return Permission::find($id);
	}

	public static function getAffiliatedToCount($fieldName,$id)
	{
		return Permission::where($fieldName,$id)->count();
	}

	public static function getWhere($fieldName,$id,$mode)
	{
		if($mode == "MODEL_MODE")
		{
			return Permission::where($fieldName,$id);
		}
		else if($mode == "DATA_MODE")
		{
			return Permission::where($fieldName,$id)->get();
		}
		else
		{
			return false;
		}
	}

	public static function savePermission(Request $request,$id = null)
	{
		$permission = ( $id == null ? new Permission : self::getPermission($id) );

        $permission -> permission_name = $request -> input("permission_name");
      	$permission -> role_id = $request -> input("role_id");

		$permission -> save();
	}

	public static function deletePermission($id)
	{
		$permission = Permission::find($id);

	    $permission -> delete();
	}

}