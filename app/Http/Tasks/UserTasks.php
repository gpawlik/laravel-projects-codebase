<?php namespace App\Http\Tasks; 

use Illuminate\Http\Request;

use App\Http\Controllers\RoleController;
use App\Http\Tasks\CommonTasks;
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

class UserTasks
{
	public static function storeUserData(Request $request)
	{
		$rules = self::getRules();
		$rules["username"] = "required | unique:users";

		$validator = Validator::make($request -> all(), $rules);

		if ($validator->fails())
		{
			return Redirect::to('/system/users/create')
				->withErrors($validator)
				->withInput()
				->send();
		}
		else
		{
			$user = new User;

			if($request -> file('image_name'))
      		{
				$storageName = CommonTasks::prepareImage($request -> file('image_name'),200,200);
				$user -> image_name = $storageName;
			}
			else
			{
				$user -> image_name = null;
			}

			$user -> first_name = $request -> input("first_name");
			$user -> last_name = $request -> input("last_name");
			$user -> email = $request -> input("email");
			$user -> username = $request -> input("username");
			$user -> role_id = $request -> input("role_id");
			$user -> status = 2;
			$user -> password = Hash::make("password");

			$user -> save();
			Session::flash('message','User Added');
			return Redirect::to('/system/users')->send();
	  	}
	}

	public static function updateUserData(Request $request,$id)
	{
		$user = User::find($id);

		$rules = self::getRules();

		$validator = Validator::make($request -> all(), $rules);

		if ($validator->fails())
		{
			return Redirect::to('/system/users/'.$id.'/edit')
        		->withErrors($validator)
        		->withInput()
        		->send();
		}
	    else
	    {
			//DEAL WITH IMAGE FILE
			if($request -> file('image_name'))
			{
				if($user->image_name != null)
				{
					CommonTasks::deleteImage($user->image_name);
				}

				$storageName = CommonTasks::prepareImage($request -> file('image_name'),200,200);
				$user -> image_name = $storageName;
			}
			else
			{	
				if($request -> input("clear_check") == 'yes')
	        	{
					CommonTasks::deleteImage($user->image_name);
	          		$user->image_name = null;
	        	}	
			}

			$user -> first_name = $request -> input("first_name");
			$user -> last_name = $request -> input("last_name");
			$user -> email = $request -> input("email");
			$user -> username = $request -> input("username");
			$user -> role_id = $request -> input("role_id");

			$user -> push();
			Session::flash('message', "User Details Updated");
			return Redirect::to("/system/users")->send();
		}
	}

	public static function deleteUserData($id)
	{
		$user = User::find($id);

    	if($user -> image_name != null)
		{
      		if (file_exists(public_path('uploads/'.$user -> image_name)))
	  		{
	        	unlink(public_path('uploads/'.$user -> image_name));
	  		}
    	}

	    $user -> delete();

	    Session::flash('message', 'User deleted');
		return Redirect::to("/system/users")->send();
	}

	public static function resetUserPassword($id)
	{
		$user = User::find($id);

		$user -> status = 2;
		$user -> password = Hash::make("password");

		$user -> push();

		Session::flash('message', 'User\'s password reset');
		return Redirect::to("/system/users")->send();
	}

	public static function populateIndexData()
	{
		$data['title'] = "Users";
		$data['activeLink'] = "user";
		$data['subTitle'] = "All System Users";
    	$data['users'] = User::orderBy("updated_at","DESC")->paginate(20);
		$data['subLinks'] = array(
			array
			(
				"title" => "Add User",
				"route" => "/system/users/create",
				"icon" => "<i class='fa fa-plus'></i>",
				"permission" => "system_user_can_add"
			),
			array
			(
				"title" => "Search for User",
				"route" => "/system/users/search",
				"icon" => "<i class='fa fa-search'></i>",
				"permission" => "system_user_can_search"
			)
		);

		return $data;
	}

	public static function populateCreateData()
	{
		$data['title'] = "Add User";
		$data['activeLink'] = "user";
		$data['subTitle'] = "Add a System User";
		$data['subLinks'] = array(
			array
			(
				"title" => "User List",
				"route" => "/system/users",
				"icon" => "<i class='fa fa-th-list'></i>",
				"permission" => "system_user_can_view"
			)
		);


		$data['roles'] = CommonTasks::getSelectArray("roles","role_name","ASC");//CommonTasks::getRolesArray();

		return $data;
	}

	public static function populateEditData($id)
	{
		$user = User::find($id);

		$data['title'] = "Edit User";
		$data['activeLink'] = "user";
		$data['subTitle'] = "Edit System User Details";
		$data['subLinks'] = array(
			array
			(
				"title" => "User List",
				"route" => "/system/users",
				"icon" => "<i class='fa fa-th-list'></i>",
				"permission" => "system_user_can_view"
			)
		);
		$data['user'] = $user;

		$data['roles'] = CommonTasks::getSelectArray("roles","role_name","ASC");//CommonTasks::getRolesArray();
		$data['users_role'] = Role::where('id','=',$user -> role_id)->first();

		return $data;
	}

	public static function populateShowData($id)
	{
		$user = User::find($id);

		$data['title'] = "View User Details";
		$data['activeLink'] = "user";
		$data['subTitle'] = "View System User Details";
		$data['subLinks'] = array(
			array
			(
				"title" => "User List",
				"route" => "/system/users",
				"icon" => "<i class='fa fa-th-list'></i>",
				"permission" => "system_user_can_view"
			),
			array
			(
				"title" => "Add User",
				"route" => "/system/users/create",
				"icon" => "<i class='fa fa-plus'></i>",
				"permission" => "system_user_can_add"
			),
			array
			(
				"title" => "Edit User",
				"route" => "/system/users/".$id."/edit",
				"icon" => "<i class='fa fa-pencil'></i>",
				"permission" => "system_user_can_edit"
			),
			array
			(
				"title" => "Delete User",
				"route" => "/system/users/delete/".$id,
				"icon" => "<i class = 'fa fa-trash'></i>",
				"permission" => "system_user_can_delete"
			)
		);

		$data['user'] = $user;

		return $data;
	}

	public static function populateSearchData()
	{
		$data['title'] = "Search for User";
		$data['activeLink'] = "user";
		$data['subTitle'] = "Search For User";
		$data['subLinks'] = array(
			array
			(
				"title" => "Role List",
				"route" => "/system/users",
				"icon" => "<i class='fa fa-th-list'></i>",
				"permission" => "system_user_can_view"
			),
			array
			(
				"title" => "Add Role",
				"route" => "/system/users/create",
				"icon" => "<i class='fa fa-plus'></i>",
				"permission" => "system_user_can_add"
			)
		);	

		return $data;
	}

	public static function getRules()
	{
		return array(
			'first_name' => 'required',
			'last_name' => 'required',
			'username' => 'required',
			'email' => 'required',
		);

	}
}