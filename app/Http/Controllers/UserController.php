<?php namespace App\Http\Controllers;

use App\User;
use App\Role;
use Response;
use Auth;


class UserController extends Controller {

	public function index()
	{
		$data['title'] = "Users";
    $data['users'] = User::orderBy("updated_at","ASC")->paginate(20);

		return view('dashboard.users.index',$data);
	}

  public function add()
  {
    	$data['title'] = "Users";

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

  }

  public function apiGetUsers()
  {
    $users = User::all();
    return Response::json(
        	$users
    	);
  }

}
