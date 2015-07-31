<?php namespace App\Http\Controllers;

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


class PermissionController extends Controller {

	public function index()
	{
		if(self::checkUserPermissions("system_permission_can_view"))
		{
	    $data['title'] = "Permissions";
	    $data['permissions'] = Permission::orderBy("permission_name","ASC")->paginate(20);
			$data['subLinks'] = array(
				array
				(
					"title" => "Add Permission",
					"route" => "/system/permissions/add",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "system_permission_can_add"
				),
				array
				(
					"title" => "Search for permission",
					"icon" => "<i class='fa fa-search'></i>",
					"permission" => "system_permission_can_search"
				)
			);

			return view('dashboard.permissions.index',$data);
		}
		else
		{
				return "You are not authorized";die();
		}
  }

  public function add()
  {
		if(self::checkUserPermissions("system_permission_can_add"))
		{
	    $data['title'] = "Add Permission";
	    $data['subLinks'] = array(
	      array
	      (
	        "title" => "Permission List",
	        "route" => "/system/permissions",
	        "icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "system_permission_can_view"
	      )
	    );

	    //Obtain list of roles
	    $roles = Role::all();
	    $roles_array = array();

	    foreach ($roles as $role) {
	      $roles_array[$role->id] = $role->role_name;
	    }

	    $data['roles'] = $roles_array;

	    return view('dashboard.permissions.add',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
  }

  public function create()
  {
		if(self::checkUserPermissions("system_permission_can_add"))
		{
	    $rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/system/permissions/add')
							->withErrors($validator)
							->withInput();
			}
			else
			{
	      $permission = new Permission;

	      $permission -> permission_name = Input::get("permission_name");
	      $permission -> role_id = Input::get("role_id");

				$permission -> save();
				Session::flash('message','Permission Added');
				return Redirect::to('/system/permissions');
	    }
		}
		else
		{
			return "You are not authorized";die();
		}
  }

  public function edit($id)
  {
		if(self::checkUserPermissions("system_permission_can_edit"))
		{
	    $permission = Permission::find($id);

	    $data['title'] = "Edit Permission";
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

	    //Obtain list of roles
	    $roles = Role::all();
	    $roles_array = array();

	    foreach ($roles as $role) {
	      $roles_array[$role->id] = $role->role_name;
	    }

	    $data['roles'] = $roles_array;
	    $data['permissions_role'] = Role::where('id','=',$permission -> role_id)->first();

	    return view('dashboard.permissions.edit',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
  }

  public function update($id)
  {
		if(self::checkUserPermissions("system_permission_can_edit"))
		{
	    $permission = Permission::find($id);

			$rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/system/permissions/edit/'.$id)
	        		->withErrors($validator)
	        		->withInput();
			}
	    else
	    {
				$permission -> permission_name = Input::get("permission_name");
				$permission -> role_id = Input::get("role_id");

				$permission -> push();
				Session::flash('message', "Permission Details Updated");
				return Redirect::to("/system/permissions");
			}

		}
		else
		{
			return "You are not authorized";die();
		}

  }

  public function delete($id)
  {
		if(self::checkUserPermissions("system_permission_can_edit"))
		{
	    $permission = Permission::find($id);

	    $permission -> delete();

	    Session::flash('message', 'Permission deleted');
			return Redirect::to("/system/permissions");
		}
		else
		{
			return "You are not authorized";die();
		}
  }

  public function getRules()
  {
    return array(
      'permission_name' => 'required'
    );

  }


}
