<?php namespace App\Http\Controllers;

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


class UserController extends Controller {

	public function index()
	{
		if(self::checkUserPermissions("system_user_can_view"))
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

			return view('dashboard.system.users.index',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
	}

  public function create()
  {
		if(self::checkUserPermissions("system_user_can_add"))
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

	      //Obtain list of roles
	      $roles = Role::all();
	      $roles_array = array();

	      foreach ($roles as $role) {
	        $roles_array[$role->id] = $role->role_name;
	      }

	      $data['roles'] = $roles_array;

	      return view('dashboard.system.users.add',$data);
			}
			else
			{
				return "You are not authorized";die();
			}
  }

  public function store()
  {
		if(self::checkUserPermissions("system_user_can_add"))
		{
			$rules = self::getRules();
			$rules["username"] = "required | unique:users";

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/system/users/create')
							->withErrors($validator)
							->withInput();
			}
			else
			{
				$user = new User;

				if(Input::file(('image_name')))
	      {

		      $image = Input::file('image_name');

		      $destinationImagePath = public_path('uploads/' . str_replace(" ","_",$image->getClientOriginalName()));

		      $resizedImage = Image::make($image)->resize(200,200);

		      $user -> image_name = str_replace(" ","_",$image->getClientOriginalName());

		      $resizedImage -> save($destinationImagePath);
	      }
				else
	      {
	        $user -> image_name = null;
	      }

				$user -> first_name = Input::get("first_name");
				$user -> last_name = Input::get("last_name");
				$user -> email = Input::get("email");
				$user -> username = Input::get("username");
				$user -> role_id = Input::get("role_id");
				$user -> status = 2;
				$user -> password = Hash::make("password");

				$user -> save();
				Session::flash('message','User Added');
				return Redirect::to('/system/users');

		  }
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function edit($id)
	{
		if(self::checkUserPermissions("system_user_can_edit"))
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

			//Obtain list of roles
			$roles = Role::all();
			$roles_array = array();

			foreach ($roles as $role) {
				$roles_array[$role->id] = $role->role_name;
			}

			$data['roles'] = $roles_array;
			$data['users_role'] = Role::where('id','=',$user -> role_id)->first();

			return view('dashboard.system.users.edit',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function update($id)
	{
		if(self::checkUserPermissions("system_user_can_edit"))
		{
			$user = User::find($id);

			$rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/system/users/'.$id.'/edit')
	        		->withErrors($validator)
	        		->withInput();
			}
	    else
	    {
				//DEAL WITH IMAGE FILE
	      if(Input::file(('image_name')))
	      {
	          if($user->image_name != null)
	          {
	            if (file_exists(public_path('uploads/'.$user -> image_name)))
	        		{
	              unlink(public_path('uploads/'.$user -> image_name));
	        		}
	          }

	          $image = Input::file('image_name');

	          $destinationImagePath = public_path('uploads/' . str_replace(" ","_",$image->getClientOriginalName()));

	          $resizedImage = Image::make($image)->resize(200,200);

	          $user -> image_name = str_replace(" ","_",$image->getClientOriginalName());

	          $resizedImage -> save($destinationImagePath);

	      }
	      else
	      {
					if(Input::get("clear_check") == 'yes')
	        {
	          if(file_exists(public_path('uploads/'.$user -> image_name)))
	          {
	            unlink(public_path('uploads/'.$user -> image_name));
	          }
	          $user->image_name = null;
	        }
				}

				$user -> first_name = Input::get("first_name");
				$user -> last_name = Input::get("last_name");
				$user -> email = Input::get("email");
				$user -> username = Input::get("username");
				$user -> role_id = Input::get("role_id");

				$user -> push();
				Session::flash('message', "User Details Updated");
				return Redirect::to("/system/users");
			}
		}
		else
		{
			return "You are not authorized";die();
		}

	}

	public function show($id)
	{
		if(self::checkUserPermissions("system_user_can_view"))
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

			return view('dashboard.system.users.view',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function delete($id)
	{
		if(self::checkUserPermissions("system_user_can_delete"))
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
			return Redirect::to("/system/users");
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function resetUserPassword($id)
	{
			$user = User::find($id);

			$user -> status = 2;
			$user -> password = Hash::make("password");

			$user -> push();

			Session::flash('message', 'User\'s password reset');
			return Redirect::to("/system/users");
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

			return view('dashboard.system.users.search',$data);
		}
		else
		{
			return "You are not authorized";die();
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

	public function getRules()
	{
		return array(
			'first_name' => 'required',
			'last_name' => 'required',
			'username' => 'required',
			'email' => 'required',
		);

	}

}
