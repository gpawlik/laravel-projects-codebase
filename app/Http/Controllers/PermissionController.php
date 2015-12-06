<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

use App\Http\Tasks\PermissionTasks;

class PermissionController extends Controller {

	public function index()
	{
		if(self::checkUserPermissions("system_permission_can_view"))
		{
			$data = PermissionTasks::populateIndexData();
			return view('dashboard.system.permissions.index',$data);
		}
		else
		{
			CommonTasks::throwUnauthorized();
		}
  	}

  	public function create()
  	{
		if(self::checkUserPermissions("system_permission_can_add"))
		{
			$data = PermissionTasks::populateCreateData();
		    return view('dashboard.system.permissions.add',$data);
		}
		else
		{
			CommonTasks::throwUnauthorized();
		}
  	}

  	public function store(Request $request)
  	{
		if(self::checkUserPermissions("system_permission_can_add"))
		{
	    	PermissionTasks::storePermissionData($request);
		}
		else
		{
			CommonTasks::throwUnauthorized();
		}
  	}

  	public function edit($id)
  	{
		if(self::checkUserPermissions("system_permission_can_edit"))
		{
	    	$data = PermissionTasks::populateEditData($id);
	    	return view('dashboard.system.permissions.edit',$data);
		}
		else
		{
			CommonTasks::throwUnauthorized();
		}
  	}

  	public function update(Request $request,$id)
  	{
		if(self::checkUserPermissions("system_permission_can_edit"))
		{
	    	PermissionTasks::updatePermissionData($request,$id);
		}
		else
		{
			CommonTasks::throwUnauthorized();
		}
  	}

	public function show($id)
	{
		if(self::checkUserPermissions("system_permission_can_view"))
		{
			$data = PermissionTasks::populateShowData($id);
			return view('dashboard.system.permissions.view',$data);
		}
		else
		{
			CommonTasks::throwUnauthorized();
		}
	}

  	public function delete($id)
  	{
		if(self::checkUserPermissions("system_permission_can_edit"))
		{
			PermissionTasks::deletePermissionData($id);
		}
		else
		{
			CommonTasks::throwUnauthorized();
		}
  	}

	public function search()
	{
		if(self::checkUserPermissions("system_permission_can_search"))
		{
			$data = PermissionTasks::populateSearchData();
			return view('dashboard.system.permissions.search',$data);
		}
		else
		{
			CommonTasks::throwUnauthorized();
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
}
