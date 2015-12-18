<?php namespace App\Http\Tasks; 

use Illuminate\Http\Request;
use App\Application\Role\Repositories\RoleRepository;
use App\Application\Permission\Repositories\PermissionRepository;
use App\Application\User\Repositories\UserRepository;
use App\Http\Controllers\RoleController;
use App\Http\Tasks\CommonTasks;
use App\Role;
use App\Permission;
use Validator;
use Image;
use Hash;
use Session;
use Input;
use Redirect;
use Response;
use Auth;

class RoleTasks
{
	public static function storeRoleData(Request $request)
	{
		$rules = self::getRules();
		$rules["role_name"] = "required | unique:roles";

		$validator = Validator::make($request -> all(), $rules);

		if ($validator->fails())
		{
			return Redirect::to('/system/roles/create')
				->withErrors($validator)->withInput()->send();
		}
		else
		{
			RoleRepository::saveRole($request);

			Session::flash('message','Role Added');
			return Redirect::to('/system/roles')->send();
		}
	}

	public static function updateRoleData(Request $request, $id)
	{
		$rules = self::getRules();

		$validator = Validator::make($request -> all(), $rules);

		if ($validator->fails())
		{
			return Redirect::to('/system/roles/'.$id.'/edit')
        		->withErrors($validator)->withInput()->send();
		}
	    else
	    {
			RoleRepository::saveRole($request,$id);

			Session::flash('message', "Role Details Updated");
			return Redirect::to("/system/roles")->send();
		}
	}

	public static function deleteRoleData($id)
	{
		$role = RoleRepository::getRole($id);

		//check if users are assigned to this role, if not delete role else error (to avoid cascade delete)
		$affiliatedUsers = UserRepository::getAffiliatedToCount("role_id",$id);

		if($affiliatedUsers > 0)
		{
			Session::flash('warning', 'Cannot delete role, Users are assigned to it');
			return Redirect::to("/system/roles")->send();
		}

		//check if permissions are assigned to this role, if not delete role else error (to avoid cascade delete)
		$affiliatedPermissions = PermissionRepository::getAffiliatedToCount("role_id",$id);

		if($affiliatedPermissions > 0)
		{
			Session::flash('warning', 'Cannot delete role, Permissions are assigned to it');
			return Redirect::to("/system/roles")->send();
		}

		$role -> delete();

		Session::flash('message', 'Role deleted');
		return Redirect::to("/system/roles")->send();
	}

	public static function savePermissions(Request $request,$id)
	{
		//all checked permissions
		$selectedPermissions = $request -> all();

		//remove the form token in front of input array
		array_shift($selectedPermissions);

		//select all where role_id = selected id
		$role = RoleRepository::getRole($id);

		//select all permissions with that role id
		$rolesPermissions = PermissionRepository::getWhere("role_id",$id,"MODEL_MODE");

		//delete all permissions with that role id
		$rolesPermissions->delete();

		//add all selected permissions
		foreach($selectedPermissions as $selectedPermission)
		{
			$permission = new Permission;

			$permission -> permission_name = $selectedPermission;
			$permission -> role_id = $role->id;

			$permission -> save();
		}

		Session::flash('message', 'Permissions Saved');
		return Redirect::to("/system/roles/permissions/$id")->send();
	}

	public static function populateIndexData()
	{
		$data['title'] = "Roles";
		$data['activeLink'] = "role";
		$data['subTitle'] = "Roles";
    	$data['roles'] = RoleRepository::getAllRolesPaginated(20);
    	$data['subLinks'] = array(
      		array
      		(
		        "title" => "Add Role",
		        "route" => "/system/roles/create",
		        "icon" => "<i class='fa fa-plus'></i>",
				"permission" => "system_role_can_add"
		    ),
			array
			(
				"title" => "Search for Role",
				"route" => "/system/roles/search",
				"icon" => "<i class='fa fa-search'></i>",
				"permission" => "system_role_can_search"
			)
    	);

    	return $data;
	}

	public static function populateCreateData()
	{
		$data['title'] = "Add Role";
		$data['activeLink'] = "role";
		$data['subTitle'] = "Add Role";
    	$data['subLinks'] = array(
			array
			(
				"title" => "Role list",
				"route" => "/system/roles",
				"icon" => "<i class='fa fa-th-list'></i>",
				"permission" => "system_role_can_view"
			)
    	);

    	return $data;
	}

	public static function populateEditData($id)
	{
		$data['title'] = "Edit Role";
		$data['activeLink'] = "role";
		$data['subTitle'] = "Edit Role";
    	$data['subLinks'] = array(
			array
			(
				"title" => "Role list",
				"route" => "/system/roles",
				"icon" => "<i class='fa fa-th-list'></i>",
				"permission" => "system_role_can_view"
			),
			array
			(
				"title" => "Add Role",
				"route" => "/system/roles/create",
				"icon" => "<i class='fa fa-plus'></i>",
				"permission" => "system_role_can_add"
			),
    	);

		$data['role'] = RoleRepository::getRole($id);

    	return $data;
	}

	public static function populateShowData($id)
	{
		$data['title'] = "View Role Details";
		$data['activeLink'] = "role";
		$data['subTitle'] = "View Role Details";
		$data['subLinks'] = array(
			array
			(
				"title" => "Role List",
				"route" => "/system/roles",
				"icon" => "<i class='fa fa-th-list'></i>",
				"permission" => "system_role_can_view"
			),
			array
			(
				"title" => "Add Role",
				"route" => "/system/roles/create",
				"icon" => "<i class='fa fa-plus'></i>",
				"permission" => "system_role_can_add"
			),
			array
			(
				"title" => "Edit Role",
				"route" => "/system/roles/".$id.'/edit',
				"icon" => "<i class='fa fa-pencil'></i>",
				"permission" => "system_role_can_edit"
			),
			array
			(
				"title" => "Delete Role",
				"route" => "/system/roles/delete/".$id,
				"icon" => "<i class = 'fa fa-trash'></i>",
				"permission" => "system_role_can_delete"
			)
		);

		$data['role'] = RoleRepository::getRole($id);

		return $data;
	}

	public static function populatePermissionsData($id)
	{
		$data['title'] = "Role Permissions";
		$data['activeLink'] = "role";
		$data['subTitle'] = "Role Permissions";
		$data['subLinks'] = array(
			array
			(
				"title" => "Role List",
				"route" => "/system/roles",
				"icon" => "<i class='fa fa-th-list'></i>",
				"permission" => "system_role_can_view"
			),
			array
			(
				"title" => "Add Role",
				"route" => "/system/roles/create",
				"icon" => "<i class='fa fa-plus'></i>",
				"permission" => "system_role_can_add"
			)
		);

		$role = RoleRepository::getRole($id);
		$roles_permissions = PermissionRepository::getWhere("role_id",$id,"DATA_MODE");

		$data['role'] = $role;
		$data['permissions_parents'] = \Config::get("Permission.parents");
		$data['roles_permissions'] = $roles_permissions;
		$data['models'] = RoleController::getModels();

		return $data;
	}

	public static function populateSearchData()
	{
		$data['title'] = "Search for Role";
		$data['activeLink'] = "role";
		$data['subTitle'] = "Search For Role";
		$data['subLinks'] = array(
			array
			(
				"title" => "Role List",
				"route" => "/system/roles",
				"icon" => "<i class='fa fa-th-list'></i>",
				"permission" => "system_role_can_view"
			),
			array
			(
				"title" => "Add Role",
				"route" => "/system/roles/create",
				"icon" => "<i class='fa fa-plus'></i>",
				"permission" => "system_role_can_add"
			)
		);

		return $data;
	}

	public static function getRules()
	{
		return array(
			'role_name' => 'required',
		);
	}
}