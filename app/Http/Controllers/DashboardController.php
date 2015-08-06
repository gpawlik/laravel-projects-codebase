<?php namespace App\Http\Controllers;

use App\Job;
use App\User;
use App\Role;
use App\Department;
use Auth;
use Validator;
use Input;
use Redirect;
use Session;
use Hash;
use Image;

class DashboardController extends Controller {


	public function index()
	{
		$data['title'] = "Dashboard";

		$departmentsCount = Department::all()->count();
		$data['departmentsCount'] = $departmentsCount;

		$jobCount = Job::all()->count();
		$data['jobCount'] = $jobCount;

		return view('dashboard.index',$data);
	}

	public function profile()
	{
		$user = User::find(Auth::user()->id);

		$data['title'] = "My Profile";
		$data['user'] = $user;


		return view('dashboard.profile',$data);
	}

	public function saveProfile()
	{
		$user = User::find(Auth::user()->id);

		$rules = self::getRules();

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::to('/dashboard/profile')
						->withErrors($validator)
						->withInput();
		}
		else
		{
			if(Input::get('password'))
			{
				if(Input::get('password') !== Input::get('confirm_password'))
				{
					return Redirect::to('/dashboard/profile')
	        		->withErrors("Passwords do not match")
	        		->withInput();
				}
				else
				{
					$user->password = Hash::make(Input::get('password'));
				}
			}
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

			$user -> push();
			Session::flash('message', "Your Profile has been Updated");
			return Redirect::to("/dashboard/profile");
		}
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
