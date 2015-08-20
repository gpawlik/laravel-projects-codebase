<?php namespace App\Http\Controllers;

use App\Role;
use App\Employee;
use App\Bank;
use App\Accident;
use App\Job;
use Validator;
use Image;
use Hash;
use Session;
use Input;
use Redirect;
use Response;
use Auth;


class AccidentController extends Controller {

	public function index()
	{
    if(self::checkUserPermissions("hrm_accident_can_view"))
    {
      $data['title'] = "Accidents";
	    $data['accidents'] = Accident::orderBy("updated_at","DESC")->paginate(20);
      $data['activeLink'] = "accident";
			$data['subLinks'] = array(
				array
				(
					"title" => "Add Accident",
					"route" => "/hrm/accidents/add",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "hrm_accident_can_add"
				),
				array
				(
					"title" => "Search for accident",
					"route" => "/hrm/accidents/search",
					"icon" => "<i class='fa fa-search'></i>",
					"permission" => "hrm_accident_can_search"
				)
			);

      return view('dashboard.hrm.accidents.index',$data);
    }
    else
    {
        return "You are not authorized";die();
    }

  }

  public function add()
  {
    if(self::checkUserPermissions("hrm_accident_can_add"))
		{
      $data['title'] = "Add Accident";
      $data['activeLink'] = "accident";
	    $data['subLinks'] = array(
	      array
	      (
	        "title" => "Accidents",
					"route" => "/hrm/accidents",
	        "icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "hrm_accident_can_view"
	      )
	    );

      $data['employee_name'] = "";

      return view('dashboard.hrm.accidents.add',$data);
    }
    else
    {
        return "You are not authorized";die();
    }
  }

  public function create()
  {
		if(self::checkUserPermissions("hrm_accident_can_add"))
		{
			$rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/hrm/accidents/add')
							->withErrors($validator)
							->withInput();
			}
			else
			{
				$employee = Input::get("employee");

				$employeeFirstName = array_pad(explode(" ", $employee,3),3,null)[0];
				$employeeLastName = array_pad(explode(" ", $employee,3),3,null)[1];
				$employeeEmail = str_replace(")","",str_replace("(", "", array_pad(explode(" ", $employee,3),3,null)[2]));

				if($employeeEmail != null)
				{
					$employeeDetails = \DB::table("employees")->where("email",$employeeEmail)->get()[0];

					if($employeeDetails -> employment_status == "TERMINATED")
					{
						return Redirect::to('/hrm/accidents/add')
									->withErrors("Employee not active")
									->withInput();
					}

					$employeeId = $employeeDetails->id;
				}
				else
				{
					return Redirect::to('/hrm/accidents/add')
								->withErrors("Employee not found")
								->withInput();
				}

				$accident = new Accident;

				$accident -> employee_id = $employeeId;
				$accident -> accident_date = Input::get("accident_date");
				$accident -> accident_time = (Input::get("accident_time") == ""? null : Input::get("accident_time"));
				$accident -> accident_report_date = Input::get("accident_report_date");
				$accident -> accident_report_time = (Input::get("accident_report_time") == ""?null : Input::get("accident_report_time"));
				$accident -> accident_description = (Input::get("accident_description") == ""?null : Input::get("accident_description"));
				$accident -> accident_location = (Input::get("accident_location") == ""?null : Input::get("accident_location"));
				$accident -> witness_1_name = (Input::get("witness_1_name") == ""?null : Input::get("witness_1_name"));
				$accident -> witness_2_name = (Input::get("witness_2_name") == ""?null : Input::get("witness_2_name"));
				$accident -> injury_type = Input::get("injury_type");
				$accident -> supervisor = (Input::get("supervisor") == ""?null : Input::get("supervisor"));
				$accident -> management_decision = (Input::get("management_decision")== ""?null : Input::get("management_decision"));

				$accident -> save();

				Session::flash('message','Accident Details Added');
				return Redirect::to('/hrm/accidents');

			}
    }
    else
    {
        return "You are not authorized";die();
    }
  }

	public function edit($id)
	{
		if(self::checkUserPermissions("hrm_accident_can_edit"))
		{
			$accident = Accident::find($id);

			$data['title'] = "Edit Accident Details";
			$data['activeLink'] = "accident";
			$data['subLinks'] = array(
        array
        (
          "title" => "Accident List",
          "route" => "/hrm/accidents",
          "icon" => "<i class='fa fa-th-list'></i>",
          "permission" => "hrm_accident_can_view"
        )
      );

			$employee = \DB::table("employees")->where("id",$accident->employee_id)->get();

			$data['employee_name'] = $employee[0]->first_name . " " . $employee[0]->last_name . " " . "(".$employee[0]->email.")";

			$data['accident'] = $accident;
			$data['injury_type'] = $accident -> injury_type;

			return view('dashboard.hrm.accidents.edit',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function update($id)
	{
		if(self::checkUserPermissions("hrm_accident_can_edit"))
		{
			$accident = Accident::find($id);

			$rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/hrm/accidents/edit/'.$id)
							->withErrors($validator)
							->withInput();
			}
			else
			{

				$employee = Input::get("employee");

				$employeeFirstName = array_pad(explode(" ", $employee,3),3,null)[0];
				$employeeLastName = array_pad(explode(" ", $employee,3),3,null)[1];
				$employeeEmail = str_replace(")","",str_replace("(", "", array_pad(explode(" ", $employee,3),3,null)[2]));

				if($employeeEmail != null)
				{
					$employeeDetails = \DB::table("employees")->where("email",$employeeEmail)->get()[0];

					if($employeeDetails -> employment_status == "TERMINATED")
					{
						return Redirect::to('/hrm/accidents/edit/'.$id)
									->withErrors("Employee not active")
									->withInput();
					}

					$employeeId = $employeeDetails->id;
				}
				else
				{
					return Redirect::to('/hrm/accidents/edit/'.$id)
								->withErrors("Employee not found")
								->withInput();
				}

				$accident -> employee_id = $employeeId;
				$accident -> accident_date = Input::get("accident_date");
				$accident -> accident_time = (Input::get("accident_time") == ""? null : Input::get("accident_time"));
				$accident -> accident_report_date = Input::get("accident_report_date");
				$accident -> accident_report_time = (Input::get("accident_report_time") == ""?null : Input::get("accident_report_time"));
				$accident -> accident_description = (Input::get("accident_description") == ""?null : Input::get("accident_description"));
				$accident -> accident_location = (Input::get("accident_location") == ""?null : Input::get("accident_location"));
				$accident -> witness_1_name = (Input::get("witness_1_name") == ""?null : Input::get("witness_1_name"));
				$accident -> witness_2_name = (Input::get("witness_2_name") == ""?null : Input::get("witness_2_name"));
				$accident -> injury_type = Input::get("injury_type");
				$accident -> supervisor = (Input::get("supervisor") == ""?null : Input::get("supervisor"));
				$accident -> management_decision = (Input::get("management_decision")== ""?null : Input::get("management_decision"));

				$accident -> push();

				Session::flash('message','Accident Details Updated');
				return Redirect::to('/hrm/accidents');
			}
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function view($id)
	{
		if(self::checkUserPermissions("hrm_accident_can_view"))
		{
			$accident = Accident::find($id);

			$data['title'] = "View Accident";
			$data['activeLink'] = "accident";
			$data['accident'] = $accident;

			$data['subLinks'] = array(
				array
				(
					"title" => "Accident List",
					"route" => "/hrm/accidents",
					"icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "hrm_accident_can_view"
				),
				array
				(
					"title" => "Add Accident",
					"route" => "/hrm/accidents/add",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "hrm_accident_can_add"
				),
				array
				(
					"title" => "Edit Accident",
					"route" => "/hrm/accidents/edit/".$id,
					"icon" => "<i class='fa fa-pencil'></i>",
					"permission" => "hrm_accident_can_edit"
				),
				array
				(
					"title" => "Delete Accident",
					"route" => "/hrm/accidents/delete/".$id,
					"icon" => "<i class = 'fa fa-trash'></i>",
					"permission" => "hrm_accident_can_delete"
				)
			);


			return view('dashboard.hrm.accidents.view',$data);
		}
		else
		{
				return "You are not authorized";die();
		}
	}

	public function delete($id)
  {
    if(self::checkUserPermissions("hrm_accident_can_delete"))
    {
      $accident = Accident::find($id);

      $accident -> delete();

      Session::flash('message', 'Accident deleted');
      return Redirect::to("/hrm/accidents");
    }
    else
    {
      return "You are not authorized";die();
    }
  }

	public function search()
	{
		if(self::checkUserPermissions("hrm_accident_can_search"))
		{
			$data['title'] = "Search for Accident";
			$data['activeLink'] = "accident";
			$data['subLinks'] = array(
				array
				(
					"title" => "Accident List",
					"route" => "/hrm/accidents",
					"icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "hrm_accident_can_view"
				),
				array
				(
					"title" => "Add Accident",
					"route" => "/hrm/accidents/add",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "hrm_accident_can_add"
				)
			);

			return view('dashboard.hrm.accidents.search',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function apiSearch($data)
	{
		$accidents = \DB::table("accidents")->select("accidents.id","accident_date","accident_time","accident_report_date","accident_report_time","supervisor","first_name","last_name")
		->join("employees","employees.id","=","accidents.employee_id")
		->where("accident_date","=",new \DateTime(date('F jS Y h:i:s A', strtotime($data))))
		->orWhere("accident_report_date","=",new \DateTime(date('F jS Y h:i:s A', strtotime($data))))
		->orWhere("first_name","ilike","%$data%")
		->orWhere("last_name","ilike","%$data%")
		->orWhere("supervisor","ilike","%$data%")

		->get();
	return Response::json(
				$accidents
		);
	}


	public function getRules()
	{
		return array(
			'accident_date' => 'required',
			'accident_report_date' => 'required',
			'employee' => 'required'
		);
	}

}
