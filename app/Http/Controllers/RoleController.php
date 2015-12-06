<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

use App\Http\Tasks\RoleTasks;
use App\Http\Tasks\CommonTasks;


class RoleController extends Controller {

	public function index()
	{
		if(self::checkUserPermissions("system_role_can_view"))
		{
	    	$data = RoleTasks::populateIndexData();
	    	return view('dashboard.system.roles.index',$data);
		}
		else
		{
			CommonTasks::throwUnauthorized();
		}
  	}

  	public function create()
  	{
		if(self::checkUserPermissions("system_role_can_add"))
		{
			$data = RoleTasks::populateCreateData();
	    	return view('dashboard.system.roles.add',$data);
		}
		else
		{
			CommonTasks::throwUnauthorized();
		}
  	}

  	public function store(Request $request)
  	{
		if(self::checkUserPermissions("system_role_can_add"))
		{
			RoleTasks::storeRoleData($request);
		}
		else
		{
			CommonTasks::throwUnauthorized();
		}
  	}

  	public function edit($id)
  	{
		if(self::checkUserPermissions("system_role_can_edit"))
		{
			$data = RoleTasks::populateEditData($id);
	    	return view('dashboard.system.roles.edit',$data);
		}
		else
		{
			CommonTasks::throwUnauthorized();
		}
  	}

  	public function update(Request $request,$id)
  	{
		if(self::checkUserPermissions("system_role_can_edit"))
		{
			RoleTasks::updateRoleData($request, $id);
		}
		else
		{
			CommonTasks::throwUnauthorized();
		}
  	}

  	public function show($id)
  	{
		if(self::checkUserPermissions("system_role_can_view"))
		{
			$data = RoleTasks::populateShowData($id);
			return view('dashboard.system.roles.view',$data);
		}
		else
		{
			CommonTasks::throwUnauthorized();
		}
  	}

  	public function delete($id)
  	{
		if(self::checkUserPermissions("system_role_can_delete"))
		{
			RoleTasks::deleteRoleData($id);
		}
		else
		{
			CommonTasks::throwUnauthorized();
		}
  	}

	public function permissions($id)
	{
		if(self::checkUserPermissions("system_role_can_permit"))
		{
			$data = RoleTasks::populatePermissionsData($id);
			return view('dashboard.system.roles.permissions',$data);
		}
		else
		{
			CommonTasks::throwUnauthorized();
		}
	}

	public function savePermissions(Request $request,$id)
	{
		if(self::checkUserPermissions("system_role_can_permit"))
		{
			RoleTasks::savePermissions($request,$id);
		}
		else
		{
			CommonTasks::throwUnauthorized();
		}

	}

	public function search()
	{
		if(self::checkUserPermissions("system_role_can_search"))
		{
			$data = RoleTasks::populateSearchData();
			return view('dashboard.system.roles.search',$data);
		}
		else
		{
			CommonTasks::throwUnauthorized();
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
}
