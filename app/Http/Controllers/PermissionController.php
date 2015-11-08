<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Tasks\PermissionTasks;

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

			return view('dashboard.system.permissions.index',$data);
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

		    //Obtain list of roles
		    $roles = Role::all();
		    $roles_array = array();

		    foreach ($roles as $role) {
		      $roles_array[$role->id] = $role->role_name;
		    }

		    $data['roles'] = $roles_array;

		    return view('dashboard.system.permissions.add',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
  }

  public function store(Request $request)
  {
		if(self::checkUserPermissions("system_permission_can_add"))
		{
	    	$rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/system/permissions/create')
							->withErrors($validator)
							->withInput();
			}
			else
			{
	      		$permission = new Permission;

	      		$model = PermissionTasks::insertIntoModel($permission, $request);

				$model -> save();
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

	    //Obtain list of roles
	    $roles = Role::all();
	    $roles_array = array();

	    foreach ($roles as $role) {
	      $roles_array[$role->id] = $role->role_name;
	    }

	    $data['roles'] = $roles_array;
	    $data['permissions_role'] = Role::where('id','=',$permission -> role_id)->first();

	    return view('dashboard.system.permissions.edit',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
  }

  public function update(Request $request,$id)
  {
		if(self::checkUserPermissions("system_permission_can_edit"))
		{
	    	$permission = Permission::find($id);

			$rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/system/permissions/'.$id.'/edit')
	        		->withErrors($validator)
	        		->withInput();
			}
	    	else
	    	{
				$model = PermissionTasks::insertIntoModel($permission, $request);

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

	public function show($id)
	{
		if(self::checkUserPermissions("system_permission_can_view"))
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

			return view('dashboard.system.permissions.view',$data);
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

	public function search()
	{
		if(self::checkUserPermissions("system_permission_can_search"))
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

			return view('dashboard.system.permissions.search',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function apiSearch($data)
	{
		$permissions = \DB::table("permissions")->select("permissions.id","permission_name","role_name")
		->join("roles","roles.id","=","permissions.role_id")
		->where("permission_name","ilike","%$data%")
		->orWhere("role_name","ilike","%$data%")

		->get();
	return Response::json(
				$permissions
		);
	}

  public function getRules()
  {
    return array(
      'permission_name' => 'required'
    );

  }


}
