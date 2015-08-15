<?php namespace App\Http\Controllers;

use App\Role;
use App\Employee;
use App\Rank;
use App\Bank;
use App\Identification;
use App\Job;
use App\Termination;
use App\EmployeeArchive;
use App\Branch;
use Validator;
use Image;
use Hash;
use Session;
use Input;
use Redirect;
use Response;
use Auth;


class TerminationController extends Controller {

	public function index()
	{
    if(self::checkUserPermissions("hrm_termination_can_view"))
		{
      $data['title'] = "Job Terminations / Resignations";
      $data['activeLink'] = "termination";
      $data['terminations'] = Termination::orderBy("updated_at","DESC")->paginate(20);

      $data['subLinks'] = array(
				array
				(
					"title" => "Add Job Termination",
					"route" => "/hrm/job_terminations/add",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "hrm_termination_can_add"
				),
				array
				(
					"title" => "Search for job Termination",
					"icon" => "<i class='fa fa-search'></i>",
					"permission" => "hrm_termination_can_search"
				)
			);


      return view('dashboard.hrm.terminations.index',$data);
  	}
	}

	public function add()
	{
		if(self::checkUserPermissions("hrm_termination_can_add"))
		{
      $data['title'] = "Add Job Termination";
      $data['activeLink'] = "termination";
	    $data['subLinks'] = array(
	      array
	      (
	        "title" => "Job Termination list",
					"route" => "/hrm/job_terminations",
	        "icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "hrm_termination_can_view"
	      )
	    );


      return view('dashboard.hrm.terminations.add',$data);
    }
    else
    {
        return "You are not authorized";die();
    }
	}

	public function create()
	{
		if(self::checkUserPermissions("hrm_termination_can_add"))
		{
			$rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/hrm/job_terminations/add')
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

					$termination = new Termination;

					$termination -> date_of_termination = Input::get("date_of_termination");
					$termination -> reason_for_termination = Input::get("reason_for_termination");

					if(Input::get("details_of_termination"))
					{
						$termination -> details_of_termination = Input::get("details_of_termination");
					}
					else
					{
						$termination -> details_of_termination = null;
					}

					if(Input::get("resignation_list"))
					{
						$termination -> resignation_list = Input::get("resignation_list");
					}
					else
					{
						$termination -> resignation_list = null;
					}

					$termination -> employee_id = $employeeId;

					$termination -> save();

					//deactivate employee
					$employeeToDeactivate = Employee::find($employeeId);
					$employeeToDeactivate -> employment_status = "TERMINATED";

					$employeeToDeactivate -> push();

					Session::flash('message','Job Termination Done Successfully');
					return Redirect::to('/hrm/job_terminations');

				}
				else
				{
					return Redirect::to('/hrm/job_terminations/add')
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
		if(self::checkUserPermissions("hrm_termination_can_view"))
		{
			$termination = Termination::find($id);

			$data['title'] = "View Termination Details";
			$data['activeLink'] = "termination";
			$data['subLinks'] = array(
				array
	      (
	        "title" => "Job Termination list",
					"route" => "/hrm/job_terminations",
	        "icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "hrm_termination_can_view"
	      ),
				array
				(
					"title" => "Add Termination",
					"route" => "/hrm/job_terminations/add",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "hrm_termination_can_add"
				)
			);
			$data['termination'] = $termination;

			return view('dashboard.hrm.terminations.view',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function terminatedEmployeeDetails($id)
	{
		if(self::checkUserPermissions("hrm_termination_can_view"))
		{
			$employee = Employee::find($id);

			$data['title'] = "View Terminated Employee Details";
			$data['activeLink'] = "termination";
			$data['subLinks'] = array(
				array
	      (
	        "title" => "Job Termination list",
					"route" => "/hrm/job_terminations",
	        "icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "hrm_termination_can_view"
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

	public function getRules()
	{
		return array(
			'date_of_termination' => 'required',
			'reason_for_termination' => 'required',
			'employee' => 'required',
		);
	}

}
