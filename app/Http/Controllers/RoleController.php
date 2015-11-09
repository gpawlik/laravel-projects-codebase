<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Tasks\RoleTasks;

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
			$data['subTitle'] = "Roles";
	    $data['roles'] = Role::orderBy("updated_at","DESC")->paginate(20);
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

	    return view('dashboard.system.roles.index',$data);
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

	    return view('dashboard.system.roles.add',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
  }

  public function store(Request $request)
  {
		if(self::checkUserPermissions("system_role_can_add"))
		{
			$rules = self::getRules();
			$rules["role_name"] = "required | unique:roles";

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/system/roles/create')
							->withErrors($validator)
							->withInput();
			}
			else
			{
				$role = new Role;

				$model = RoleTasks::insertIntoModel($role,$request);

				$model -> save();

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
			$data['subTitle'] = "Edit Role";
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
	        "route" => "/system/roles/create",
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

  public function update(Request $request, $id)
  {
		if(self::checkUserPermissions("system_role_can_edit"))
		{
			$role = Role::find($id);

			$rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/system/roles/'.$id.'/edit')
	        		->withErrors($validator)
	        		->withInput();
			}
	    else
	    {
				$model = RoleTasks::insertIntoModel($role,$request);

				$model -> push();
				Session::flash('message', "Role Details Updated");
				return Redirect::to("/system/roles");
			}
		}
		else
		{
			return "You are not authorized";die();
		}

  }

  public function show($id)
  {
		if(self::checkUserPermissions("system_role_can_view"))
		{
			$role = Role::find($id);

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

	public function search()
	{
		if(self::checkUserPermissions("system_role_can_search"))
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

			return view('dashboard.system.roles.search',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function apiSearch($data)
	{
		$roles = \DB::table("roles")->select("id","role_name")
		->where("role_name","ilike","%$data%")

		->get();
	return Response::json(
				$roles
		);
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
