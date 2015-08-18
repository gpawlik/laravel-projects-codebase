<?php namespace App\Http\Controllers;

use App\Role;
use App\Job;
use App\Leave;
use Validator;
use Image;
use Hash;
use Session;
use Input;
use Redirect;
use Response;
use Auth;
use Carbon\Carbon;


class LeaveController extends Controller {

	public function index()
	{
    if(self::checkUserPermissions("hrm_leave_can_view"))
		{
      $data['title'] = "Leave Days";
      $data['activeLink'] = "leave";
      $data['leaves'] = Leave::orderBy("updated_at","DESC")->paginate(20);

      $data['subLinks'] = array(
        array
        (
          "title" => "Add Leave",
          "route" => "/hrm/leaves/add",
          "icon" => "<i class='fa fa-plus'></i>",
          "permission" => "hrm_leave_can_add"
        ),
        array
        (
          "title" => "Search for Leave",
					"route" => "/hrm/leaves/search",
          "icon" => "<i class='fa fa-search'></i>",
          "permission" => "hrm_leave_can_search"
        )
      );


      return view('dashboard.hrm.leaves.index',$data);
    }
    else
    {
        return "You are not authorized";die();
    }
  }

	public function add()
	{
		if(self::checkUserPermissions("hrm_leave_can_add"))
		{
      $data['title'] = "Add Leave";
      $data['activeLink'] = "leave";
      $data['subLinks'] = array(
        array
        (
          "title" => "Leave Day List",
          "route" => "/hrm/leaves",
          "icon" => "<i class='fa fa-th-list'></i>",
          "permission" => "hrm_leave_can_view"
        )
      );

			//to avoid undefined employee_name error
			$data['employee_name'] = "";

      return view('dashboard.hrm.leaves.add',$data);
    }
    else
    {
        return "You are not authorized";die();
    }
	}

	public function create()
	{
		if(self::checkUserPermissions("hrm_leave_can_add"))
		{
			$rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/hrm/leaves/add')
							->withErrors($validator)
							->withInput();
			}
			else
			{
				$employee = Input::get("employee");

				$employeeFirstName = array_pad(explode(" ", $employee,3),3,null)[0];
				$employeeLastName = array_pad(explode(" ", $employee,3),3,null)[1];
				$employeeEmail = str_replace(")","",str_replace("(", "", array_pad(explode(" ", $employee,3),3,null)[2]));

				//get number of leave days
				$numLeaveDays = self::getNumLeaveDays(Input::get("leave_start_date"), Input::get("leave_end_date"), Input::get("saturday_check"),  Input::get("sunday_check"));

				//get user's leave days
				if($employeeEmail != null)
				{
					$employeeDetails = \DB::table("employees")->where("email",$employeeEmail)->get()[0];

					if($employeeDetails -> employment_status == "TERMINATED")
					{
						return Redirect::to('/hrm/leaves/add')
									->withErrors("Employee not active")
									->withInput();
					}

					$employeeId = $employeeDetails->id;
				}
				else
				{
					return Redirect::to('/hrm/leaves/add')
								->withErrors("Employee not found")
								->withInput();
				}

				$currentYear = date('Y');
				$nextYear = date('Y', strtotime('+1 year'));

				$employeeLeaveDays = \DB::table("leaves")->where("employee_id",$employeeId)
					->where("created_at",">=",new \DateTime(date('F jS Y h:i:s A', strtotime($currentYear.'-01-01'))))
					->where("created_at","<",new \DateTime(date('F jS Y h:i:s A', strtotime($nextYear.'-01-01'))))
					->get();

				if(!empty($employeeLeaveDays))
				{
					//total employee leave days
					$totalEmployeeLeaveDays = 0;

					foreach($employeeLeaveDays as $leaveDay)
					{
						$totalEmployeeLeaveDays += self::getNumLeaveDays($leaveDay->leave_start_date, $leaveDay->leave_end_date, $leaveDay->saturday_inclusive, $leaveDay->sunday_inclusive);
					}

					$totalEmployeeLeaveDays+=$numLeaveDays;

					//get user's allowed leave days for the year
					$employeesAllowedLeaveDays = \DB::table("ranks")->where("id",$employeeDetails->rank_id)->get()[0]->allowed_number_of_leave_days;

					if($totalEmployeeLeaveDays > $employeesAllowedLeaveDays)
					{
						return Redirect::to('/hrm/leaves/add')
									->withErrors("Leave Days exceeds employee's allowed leave days")
									->withInput();
					}
					else
					{
						self::insertValues($employeeId);
						Session::flash('message','Leave Saved');
						return Redirect::to('/hrm/leaves');
					}

				}
				else
				{
					self::insertValues($employeeId);
					Session::flash('message','Leave Saved');
					return Redirect::to('/hrm/leaves');
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
		if(self::checkUserPermissions("hrm_leave_can_view"))
		{
			$leave = Leave::find($id);

			$data['title'] = "View Leave";
			$data['activeLink'] = "leave";
			$data['leave'] = $leave;

			$data['subLinks'] = array(
				array
				(
					"title" => "Leave List",
					"route" => "/hrm/leaves",
					"icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "hrm_leave_can_view"
				),
				array
				(
					"title" => "Add Leave",
					"route" => "/hrm/leaves/add",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "hrm_leave_can_add"
				)
			);


			return view('dashboard.hrm.leaves.view',$data);
		}
		else
		{
				return "You are not authorized";die();
		}
	}

	public function delete($id)
	{
		if(self::checkUserPermissions("hrm_leave_can_delete"))
		{
			$leave = Leave::find($id);

			$leave -> delete();

			Session::flash('message', 'Leave deleted');
			return Redirect::to("/hrm/leaves");
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	// public function edit($id)
	// {
	// 	if(self::checkUserPermissions("hrm_leave_can_edit"))
	// 	{
	// 		$leave= Leave::find($id);
	//
	// 		$data['title'] = "Edit Leave";
	// 		$data['activeLink'] = "leave";
	// 		$data['subLinks'] = array(
	// 			array
	// 			(
	// 				"title" => "Leave List",
	// 				"route" => "/hrm/leaves",
	// 				"icon" => "<i class='fa fa-th-list'></i>",
	// 				"permission" => "hrm_leave_can_view"
	// 			)
	// 		);
	// 		$data['leave'] = $leave;
	//
	// 		if($leave -> saturday_inclusive == "YES")
	// 		{
	// 			$data['saturday_checked'] = "YES";
	// 		}
	//
	// 		if($leave -> sunday_inclusive == "YES")
	// 		{
	// 			$data['sunday_checked'] = "YES";
	// 		}
	//
	// 		$employee = \DB::table("employees")->where("id",$leave->employee_id)->get();
	//
	// 		$data['employee_name'] = $employee[0]->first_name . " " . $employee[0]->last_name . " " . "(".$employee[0]->email.")";
	//
	// 		return view('dashboard.hrm.leaves.edit',$data);
	// 	}
	// 	else
	// 	{
	// 			return "You are not authorized";die();
	// 	}
	// }

	private static function insertValues($employeeId)
	{
		$leave = new Leave;

		$leave -> leave_start_date = Input::get("leave_start_date");
		$leave -> leave_end_date = Input::get("leave_end_date");

		if(Input::get("reason_for_leave"))
		{
			$leave -> reason_for_leave = Input::get("reason_for_leave");
		}
		else
		{
			$leave -> reason_for_leave = null;
		}

		if(Input::get("saturday_check") == "YES")
		{
			$leave -> saturday_inclusive = Input::get("saturday_check");
		}
		else
		{
			$leave -> saturday_inclusive = "NO";
		}

		if(Input::get("sunday_check") == "YES")
		{
			$leave -> sunday_inclusive = Input::get("sunday_check");
		}
		else
		{
			$leave -> sunday_inclusive = "NO";
		}

		$leave -> employee_id = $employeeId;

		$leave -> save();

	}

	public static function getNumLeaveDays($startDate,$endDate,$saturdayInput,$sundayInput)
	{

		$startDate = new \DateTime($startDate);
		$endDate = new \DateTime($endDate);

		$interval = \DateInterval::createFromDateString('1 day');
		$period = new \DatePeriod($startDate, $interval, $endDate);

		$leaveDaysCount = 0;

		//determine number of leave days
		foreach ( $period as $date )
		{
			$dayOfWeek = date('w', strtotime($date->format('Y-m-d H:i:s')));

			//0 - sunday, 6 - saturday

			if($dayOfWeek == "0")
			{
				if($saturdayInput == "YES")
				{
					++$leaveDaysCount;
					continue;
				}
				else
				{
					continue;
				}
			}

			if($dayOfWeek == "6")
			{
				if($sundayInput == "YES")
				{
					++$leaveDaysCount;
					continue;
				}
				else
				{
					continue;
				}
			}


			++$leaveDaysCount;

		}

		return $leaveDaysCount;
	}

	public function search()
	{
		if(self::checkUserPermissions("hrm_leave_can_search"))
		{
			$data['title'] = "Search for Employee Leaves";
			$data['activeLink'] = "leave";
			$data['subLinks'] = array(
				array
				(
					"title" => "Rank List",
					"route" => "/hrm/leaves",
					"icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "hrm_leave_can_view"
				),
				array
				(
					"title" => "Add Leave",
					"route" => "/hrm/leaves/add",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "hrm_leave_can_add"
				)
			);

			return view('dashboard.hrm.leaves.search',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function apiSearch($data)
	{
		$leaves = \DB::table("leaves")->select("leaves.id","leave_start_date","leave_end_date","saturday_inclusive","sunday_inclusive","first_name","last_name")
		->join("employees","employees.id","=","leaves.employee_id")
		->where("leave_end_date",">=",new \DateTime(date('F jS Y h:i:s A', strtotime($data))))
		->where("leave_start_date","<=",new \DateTime(date('F jS Y h:i:s A', strtotime($data))))
		->orWhere("first_name","ilike","%$data%")
		->orWhere("last_name","ilike","%$data%")
		->get();
	return Response::json(
				$leaves
		);
	}


	public function getRules()
	{
		return array(
			'leave_start_date' => 'required',
			'leave_end_date' => 'required',
			'employee' => 'required'
		);

	}

}
