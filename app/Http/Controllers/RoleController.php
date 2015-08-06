<?php namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\Permission;
use Validator;
use Image;
use Hash;
use Session;
use Input;
use Redirect;
use Response;
use Auth;


class RoleController extends Controller {

	public function index()
	{
		if(self::checkUserPermissions("system_role_can_view"))
		{
	    $data['title'] = "Roles";
			$data['activeLink'] = "role";
	    $data['roles'] = Role::orderBy("updated_at","DESC")->paginate(20);
	    $data['subLinks'] = array(
	      array
	      (
	        "title" => "Add Role",
	        "route" => "/system/roles/add",
	        "icon" => "<i class='fa fa-plus'></i>",
					"permission" => "system_role_can_add"
	      ),
	      array
	      (
	        "title" => "Search for Role",
	        "icon" => "<i class='fa fa-search'></i>",
					"permission" => "system_role_can_search"
	      )
	    );

	    return view('dashboard.system.roles.index',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
  }

  public function add()
  {
		if(self::checkUserPermissions("system_role_can_add"))
		{
			$data['title'] = "Add Role";
			$data['activeLink'] = "role";
	    $data['subLinks'] = array(
	      array
	      (
	        "title" => "Role list",
					"route" => "/system/roles",
	        "icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "system_role_can_view"
	      )
	    );

	    return view('dashboard.system.roles.add',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
  }

  public function create()
  {
		if(self::checkUserPermissions("system_role_can_add"))
		{
			$rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/system/roles/add')
							->withErrors($validator)
							->withInput();
			}
			else
			{
				$role = new Role;

				$role -> role_name = Input::get("role_name");

				$role -> save();

				Session::flash('message','Role Added');
				return Redirect::to('/system/roles');
			}
		}
		else
		{
			return "You are not authorized";die();
		}
  }

  public function edit($id)
  {
		if(self::checkUserPermissions("system_role_can_edit"))
		{
			$role = Role::find($id);

			$data['title'] = "Edit Role";
			$data['activeLink'] = "role";
			$data['role'] = $role;
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
	        "route" => "/system/roles/add",
	        "icon" => "<i class='fa fa-plus'></i>",
					"permission" => "system_role_can_add"
	      ),
	    );

	    return view('dashboard.system.roles.edit',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
  }

  public function update($id)
  {
		if(self::checkUserPermissions("system_role_can_edit"))
		{
			$role = Role::find($id);

			$rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/system/roles/edit/'.$id)
	        		->withErrors($validator)
	        		->withInput();
			}
	    else
	    {
				$role -> role_name = Input::get("role_name");

				$role -> push();
				Session::flash('message', "Role Details Updated");
				return Redirect::to("/system/roles");
			}
		}
		else
		{
			return "You are not authorized";die();
		}

  }

  public function view($id)
  {
		if(self::checkUserPermissions("system_role_can_view"))
		{
			$role = Role::find($id);

			$data['title'] = "View Role Details";
			$data['activeLink'] = "role";
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
						"route" => "/system/roles/add",
						"icon" => "<i class='fa fa-plus'></i>",
						"permission" => "system_role_can_add"
					)
				);

				$data['role'] = $role;

				return view('dashboard.system.roles.view',$data);
			}
			else
			{
				return "You are not authorized";die();
			}
  }

  public function delete($id)
  {
		if(self::checkUserPermissions("system_role_can_delete"))
		{
			$role = Role::find($id);

			//check if users are assigned to this role, if not delete role else error (to avoid cascade delete)
			$affiliatedUsers = \DB::table("users")->where("role_id",$role->id)->count();

			if($affiliatedUsers > 0)
			{
				Session::flash('message', 'Cannot delete role, Users are assigned to it');
				return Redirect::to("/system/roles");
			}
			else
			{
				$role -> delete();

				Session::flash('message', 'Role deleted');
				return Redirect::to("/system/roles");
			}
		}
		else
		{
			return "You are not authorized";die();
		}

  }

	public function permissions($id)
	{
		if(self::checkUserPermissions("system_role_can_permit"))
		{
			$role = Role::find($id);

			$data['title'] = "Role Permissions";
			$data['activeLink'] = "role";
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
						"route" => "/system/roles/add",
						"icon" => "<i class='fa fa-plus'></i>",
						"permission" => "system_role_can_add"
					)
				);

				$roles_permissions = \DB::table("permissions")->where("role_id",$role->id)->get();

				$data['role'] = $role;
				$data['permissions_parents'] = \Config::get("Permission.parents");
				$data['roles_permissions'] = $roles_permissions;
				$data['models'] = self::getModels();

				return view('dashboard.system.roles.permissions',$data);
			}
			else
			{
				return "You are not authorized";die();
			}
	}

	public function savePermissions($id)
	{
		if(self::checkUserPermissions("system_role_can_permit"))
		{
			//all checked permissions
			$selectedPermissions = Input::all();

			//remove the form token in front of input array
			array_shift($selectedPermissions);

			//select all where role_id = selected id
			$role = Role::find($id);

			//select all permissions with that role id
			$rolesPermissions = \DB::table("permissions")->where("role_id",$role->id);

			//var_dump($rolesPermissions);die();

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
			return Redirect::to("/system/roles/permissions/$id");

		}
		else
		{
			return "You are not authorized";die();
		}

	}

	public static function getModels()
	{
		$scan = scandir('../app');
    $models = array();

    foreach($scan as $file)
    {
      if(!is_dir("../app/$file"))
      {
        array_push($models, str_replace(".php", "", "App\\".$file));
      }
    }

		return $models;
	}

	public function getRules()
	{
		return array(
			'role_name' => 'required',
		);
	}

}
