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
		$data['title'] = "Users";
    $data['users'] = User::orderBy("updated_at","ASC")->paginate(20);
		$data['subLinks'] = array(
			array
			(
				"title" => "Add User",
				"route" => "/system/users/add",
				"icon" => "<i class='fa fa-plus'></i>",
				"permission" => "system_user_can_add"
			),
			array
			(
				"title" => "Search for User",
				"icon" => "<i class='fa fa-search'></i>",
				"permission" => "system_user_can_search"
			)
		);

		return view('dashboard.users.index',$data);
	}

  public function add()
  {
    	$data['title'] = "Add User";
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

      return view('dashboard.users.add',$data);
  }

  public function create()
  {
		$rules = self::getRules();

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::to('/system/users/add')
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

	public function edit($id)
	{
		$user = User::find($id);

		$data['title'] = "Edit User";
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

		return view('dashboard.users.edit',$data);
	}

	public function update($id)
	{
		$user = User::find($id);

		$rules = self::getRules();

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::to('/system/users/edit/'.$id)
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

	public function view($id)
	{
		$user = User::find($id);

		$data['title'] = "View User Details";
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
				"route" => "/system/users/add",
				"icon" => "<i class='fa fa-plus'></i>",
				"permission" => "system_user_can_add"
			)
		);
		$data['user'] = $user;

		return view('dashboard.users.view',$data);
	}

	public function delete($id)
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

  public function apiGetUsers()
  {
    $users = User::all();
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
