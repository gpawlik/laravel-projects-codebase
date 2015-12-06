<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Role;
use Validator;
use Image;
use Hash;
use Session;
use Input;
use Redirect;
use Response;
use Auth;

use App\Http\Tasks\UserTasks;
use App\Http\Tasks\CommonTasks;


class UserController extends Controller {

	public function index()
	{
		if(self::checkUserPermissions("system_user_can_view"))
		{
			$data = UserTasks::populateIndexData();
			return view('dashboard.system.users.index',$data);
		}
		else
		{
			CommonTasks::throwUnauthorized();
		}
	}

	public function create()
	{
		if(self::checkUserPermissions("system_user_can_add"))
		{
	    	$data = UserTasks::populateCreateData();
			return view('dashboard.system.users.add',$data);
		}
		else
		{
			CommonTasks::throwUnauthorized();
		}
  	}

	public function store(Request $request)
	{
		if(self::checkUserPermissions("system_user_can_add"))
		{
			UserTasks::storeUserData($request);
		}
		else
		{
			CommonTasks::throwUnauthorized();
		}
	}

	public function edit($id)
	{
		if(self::checkUserPermissions("system_user_can_edit"))
		{
			$data = UserTasks::populateEditData($id);
			return view('dashboard.system.users.edit',$data);
		}
		else
		{
			CommonTasks::throwUnauthorized();
		}
	}

	public function update(Request $request,$id)
	{
		if(self::checkUserPermissions("system_user_can_edit"))
		{
			UserTasks::updateUserData($request,$id);
		}
		else
		{
			CommonTasks::throwUnauthorized();
		}

	}

	public function show($id)
	{
		if(self::checkUserPermissions("system_user_can_view"))
		{
			$data = UserTasks::populateShowData($id);
			return view('dashboard.system.users.view',$data);
		}
		else
		{
			CommonTasks::throwUnauthorized();
		}
	}

	public function delete($id)
	{
		if(self::checkUserPermissions("system_user_can_delete"))
		{
			UserTasks::deleteUserData($id);
		}
		else
		{
			CommonTasks::throwUnauthorized();
		}
	}

	public function resetUserPassword($id)
	{
		if(self::checkUserPermissions("system_user_can_reset-password"))
		{
			UserTasks::resetUserPassword($id);
		}
		else
		{
			CommonTasks::throwUnauthorized();
		}
	}

	public function apiGetUsers($data)
	{
		$data = ucfirst($data);
		$users = \DB::table("users")->where("first_name","like","%$data%")->orWhere("last_name","like","%$data%")->get();
		return Response::json(
	    	$users
		);
	}

	public function search()
	{
		if(self::checkUserPermissions("system_user_can_search"))
		{
			$data = UserTasks::populateSearchData();
			return view('dashboard.system.users.search',$data);
		}
		else
		{
			CommonTasks::throwUnauthorized();
		}
	}

	public function apiSearch($data)
	{
		$users = \DB::table("users")->select("users.id","first_name","last_name","email","username","role_name")
		->join("roles","roles.id","=","users.role_id")
		->where("first_name","ilike","%$data%")
		->orWhere("last_name","ilike","%$data%")
		->orWhere("email","ilike","%$data%")
		->orWhere("username","ilike","%$data%")
		->orWhere("role_name","ilike","%$data%")

		->get();
		
		return Response::json(
				$users
		);
	}
}
