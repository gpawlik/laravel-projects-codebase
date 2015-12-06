<?php namespace App\Http\Tasks; 

use Illuminate\Http\Request;

use App\Http\Tasks\CommonTasks;
use App\Permission;
use App\Role;

use Validator;
use Image;
use Hash;
use Session;
use Input;
use Redirect;
use Response;
use Auth;

class PermissionTasks
{
	public static function storePermissionData(Request $request)
	{
		$rules = self::getRules();

		$validator = Validator::make($request -> all(), $rules);

		if ($validator->fails())
		{
			return Redirect::to('/system/permissions/create')
				->withErrors($validator)
				->withInput()
				->send();
		}
		else
		{
     		$permission = new Permission;

      		$permission -> permission_name = $request -> input("permission_name");
      		$permission -> role_id = $request -> input("role_id");

			$permission -> save();
			Session::flash('message','Permission Added');
			return Redirect::to('/system/permissions')->send();
    	}
	}

	public static function updatePermissionData(Request $request,$id)
	{
		$permission = Permission::find($id);

		$rules = self::getRules();

		$validator = Validator::make($request -> all(), $rules);

		if ($validator->fails())
		{
			return Redirect::to('/system/permissions/'.$id.'/edit')
        		->withErrors($validator)
        		->withInput()
        		->send();
		}
	    else
	    {
			$permission -> permission_name = $request -> input("permission_name");
			$permission -> role_id = $request -> input("role_id");

			$permission -> push();
			Session::flash('message', "Permission Details Updated");
			return Redirect::to("/system/permissions")->send();
		}
	}

	public static function deletePermissionData($id)
	{
		$permission = Permission::find($id);

	    $permission -> delete();

	    Session::flash('message', 'Permission deleted');
		return Redirect::to("/system/permissions")->send();
	}

	public static function populateIndexData()
	{
		$data['title'] = "Permissions";
		$data['activeLink'] = "permission";
		$data['subTitle'] = "Permissions";
		$data['permissions'] = Permission::orderBy("permission_name","ASC")->paginate(20);
		$data['subLinks'] = array(
			array
			(
			"title" => "Add Permission",
			"route" => "/system/permissions/create",
			"icon" => "<i class='fa fa-plus'></i>",
			"permission" => "system_permission_can_add"
			),
			array
			(
			"title" => "Search for permission",
			"route" => "/system/permissions/search",
			"icon" => "<i class='fa fa-search'></i>",
			"permission" => "system_permission_can_search"
			)
		);	

		return $data;
	}

	public static function populateCreateData()
	{
		$data['title'] = "Add Permission";
		$data['activeLink'] = "permission";
		$data['subTitle'] = "Add Permission";
		$data['subLinks'] = array(
			array
			(
			"title" => "Permission List",
			"route" => "/system/permissions",
			"icon" => "<i class='fa fa-th-list'></i>",
			"permission" => "system_permission_can_view"
			)
		);

		$data['roles'] = CommonTasks::getSelectArray("roles","role_name","ASC");//CommonTasks::getRolesArray();

		return $data;
	}

	public static function populateEditData($id)
	{
		$permission = Permission::find($id);

    	$data['title'] = "Edit Permission";
		$data['activeLink'] = "permission";
		$data['subTitle'] = "Edit Permission";
    	$data['subLinks'] = array(
			array
			(
				"title" => "Permission List",
				"route" => "/system/permissions",
				"icon" => "<i class='fa fa-th-list'></i>",
				"permission" => "system_permission_can_view"
			)
    	);

    	$data['permission'] = $permission;

	    $data['roles'] = CommonTasks::getSelectArray("roles","role_name","ASC");//CommonTasks::getRolesArray();
	    $data['permissions_role'] = Role::where('id','=',$permission -> role_id)->first();

	    return $data;
	}

	public static function populateShowData($id)
	{
		$permission = Permission::find($id);

		$data['title'] = "View Permission Details";
		$data['activeLink'] = "permission";
		$data['subTitle'] = "View Permission Details";
		$data['subLinks'] = array(
			array
			(
				"title" => "Permission List",
				"route" => "/system/permissions",
				"icon" => "<i class='fa fa-th-list'></i>",
				"permission" => "system_permission_can_view"
			),
			array
			(
				"title" => "Add Permission",
				"route" => "/system/permissions/create",
				"icon" => "<i class='fa fa-plus'></i>",
				"permission" => "system_permission_can_add"
			),
			array
			(
				"title" => "Edit Permission",
				"route" => "/system/permissions/".$id."/edit",
				"icon" => "<i class='fa fa-pencil'></i>",
				"permission" => "system_permission_can_edit"
			),
			array
			(
				"title" => "Delete Permission",
				"route" => "/system/permissions/delete/".$id,
				"icon" => "<i class = 'fa fa-trash'></i>",
				"permission" => "system_permission_can_delete"
			)
		);

		$data['permission'] = $permission;

		return $data;
	}

	public static function populateSearchData()
	{
		$data['title'] = "Search for Permission";
		$data['activeLink'] = "permission";
		$data['subTitle'] = "Search For Permission";
		$data['subLinks'] = array(
			array
			(
				"title" => "Permission List",
				"route" => "/system/permissions",
				"icon" => "<i class='fa fa-th-list'></i>",
				"permission" => "system_permission_can_view"
			),
			array
			(
				"title" => "Add Permission",
				"route" => "/system/permissions/create",
				"icon" => "<i class='fa fa-plus'></i>",
				"permission" => "system_permission_can_add"
			)
		);

		return $data;
	}

	public static function getRules()
  	{
    	return array(
      		'permission_name' => 'required'
    	);
  	}
}