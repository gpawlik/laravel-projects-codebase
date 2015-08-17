<?php namespace App\Http\Controllers;

use App\Role;
use App\Employee;
use App\Rank;
use App\Bank;
use App\Training;
use App\Job;
use App\Branch;
use Validator;
use Image;
use Hash;
use Session;
use Input;
use Redirect;
use Response;
use Auth;


class TrainingController extends Controller {

	public function index()
	{
    if(self::checkUserPermissions("hrm_training_can_view"))
		{
      $data['title'] = "Employee Training";
      $data['activeLink'] = "training";
      $data['training'] = Training::orderBy("updated_at","DESC")->paginate(20);

      $data['subLinks'] = array(
        array
        (
          "title" => "Add Employee Training",
          "route" => "/hrm/training/add",
          "icon" => "<i class='fa fa-plus'></i>",
          "permission" => "hrm_training_can_add"
        ),
        array
        (
          "title" => "Search for employee training",
          "icon" => "<i class='fa fa-search'></i>",
          "permission" => "hrm_training_can_search"
        )
      );


      return view('dashboard.hrm.training.index',$data);
    }
		else
		{
				return "You are not authorized";die();
		}
  }

	public function add()
	{
		if(self::checkUserPermissions("hrm_training_can_add"))
		{
			$data['title'] = "Add Training";
      $data['activeLink'] = "training";
	    $data['subLinks'] = array(
	      array
	      (
	        "title" => "training list",
					"route" => "/hrm/training",
	        "icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "hrm_training_can_view"
	      )
	    );

			//to avoid undefined employee_name error
      $data['employee_name'] = "";
			$data['training_type'] = null;

      return view('dashboard.hrm.training.add',$data);
    }
		else
		{
				return "You are not authorized";die();
		}
	}

	public function create()
	{
		if(self::checkUserPermissions("hrm_training_can_add"))
		{
			$rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/hrm/training/add')
							->withErrors($validator)
							->withInput();
			}
			else
			{
				$employee = Input::get("employee");

				$employeeFirstName = array_pad(explode(" ", $employee,3),3,null)[0];
				$employeeLastName = array_pad(explode(" ", $employee,3),3,null)[1];
				$employeeEmail = str_replace(")","",str_replace("(", "", array_pad(explode(" ", $employee,3),3,null)[2]));

				//get user's leave days
				if($employeeEmail != null)
				{
					$employeeDetails = \DB::table("employees")->where("email",$employeeEmail)->get()[0];

					if($employeeDetails -> employment_status == "TERMINATED")
					{
						return Redirect::to('/hrm/training/add')
									->withErrors("Employee not active")
									->withInput();
					}

					$employeeId = $employeeDetails->id;


					$training = new Training;

					$training -> training_type = Input::get("training_type");
					$training -> training_start_date = Input::get("training_start_date");
					$training -> training_end_date = Input::get("training_end_date");
					$training -> training_total_cost = Input::get("training_total_cost");
					$training -> training_cost_components = Input::get("training_cost_components");
					$training -> employee_id = $employeeId;

					$training -> save();

					Session::flash('message','Training Details Saved Successfully');
					return Redirect::to('/hrm/training');

				}
				else
				{
					return Redirect::to('/hrm/training/add')
								->withErrors("Employee not found")
								->withInput();
				}

			}
    }
		else
		{
				return "You are not authorized";die();
		}
	}

	public function view($id)
	{
		if(self::checkUserPermissions("hrm_training_can_view"))
		{
			$training = Training::find($id);

			$data['title'] = "View Training Details";
			$data['activeLink'] = "training";
			$data['subLinks'] = array(
				array
	      (
	        "title" => "Training list",
					"route" => "/hrm/training",
	        "icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "hrm_training_can_view"
	      ),
				array
				(
					"title" => "Add Training",
					"route" => "/hrm/training/add",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "hrm_training_can_add"
				)
			);
			$data['training'] = $training;

			return view('dashboard.hrm.training.view',$data);
		}
		else
		{
				return "You are not authorized";die();
		}

	}

	public function edit($id)
	{
		if(self::checkUserPermissions("hrm_training_can_edit"))
		{
					$training = Training::find($id);

					$data['title'] = "Edit Training";
					$data['activeLink'] = "training";
					$data['subLinks'] = array(
						array
						(
							"title" => "Training List",
							"route" => "/hrm/training",
							"icon" => "<i class='fa fa-th-list'></i>",
							"permission" => "hrm_training_can_view"
						)
					);
					$data['training'] = $training;

					$employee = \DB::table("employees")->where("id",$training->employee_id)->get();

					$data['training_type'] = $training -> training_type;

					$data['employee_name'] = $employee[0]->first_name . " " . $employee[0]->last_name . " " . "(".$employee[0]->email.")";

					return view('dashboard.hrm.training.edit',$data);
		}
		else
		{
				return "You are not authorized";die();
		}

	}


	public function update($id)
	{
		if(self::checkUserPermissions("hrm_training_can_edit"))
		{
      $rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/hrm/training/edit/'.$id)
							->withErrors($validator)
							->withInput();
			}
			else
			{
        $employee = Input::get("employee");

				$employeeFirstName = array_pad(explode(" ", $employee,3),3,null)[0];
				$employeeLastName = array_pad(explode(" ", $employee,3),3,null)[1];
				$employeeEmail = str_replace(")","",str_replace("(", "", array_pad(explode(" ", $employee,3),3,null)[2]));

				//get user's leave days
				if($employeeEmail != null)
				{
					$employeeDetails = \DB::table("employees")->where("email",$employeeEmail)->get()[0];
					$employeeId = $employeeDetails->id;

          $training = Training::find($id);

					$training -> training_type = Input::get("training_type");
					$training -> training_start_date = Input::get("training_start_date");
					$training -> training_end_date = Input::get("training_end_date");
					$training -> training_total_cost = Input::get("training_total_cost");
					$training -> training_cost_components = Input::get("training_cost_components");
					$training -> employee_id = $employeeId;

          $training -> push();
          Session::flash('message','training Updated');
          return Redirect::to('/hrm/training');
				}
				else
				{
					return Redirect::to('/hrm/training/edit/'.$id)
								->withErrors("Employee not found")
								->withInput();
				}
    	}
		}
	}

	public function trainedEmployee($id)
	{
		if(self::checkUserPermissions("hrm_training_can_view"))
		{
			$employee = Employee::find($id);

			$data['title'] = "View Employee Training Details";
			$data['activeLink'] = "training";
			$data['subLinks'] = array(
				array
	      (
	        "title" => "Training list",
					"route" => "/hrm/training",
	        "icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "hrm_training_can_view"
	      )
			);

			$data['employee'] = $employee;

			return view('dashboard.hrm.employees.view',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function delete($id)
	{
		if(self::checkUserPermissions("hrm_training_can_delete"))
		{
			$training = Training::find($id);

      $training -> delete();

      Session::flash('message', 'Training deleted');
      return Redirect::to("/hrm/training");
    }
    else
    {
      return "You are not authorized";die();
    }
	}

	public function getRules()
	{
		return array(
			'training_type' => 'required',
			'training_start_date' => 'required',
			'training_end_date' => 'required',
			'training_total_cost' => 'required',
			'training_cost_components' => 'required',
			'employee' => 'required'
		);
	}

}
