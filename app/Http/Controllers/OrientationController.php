<?php namespace App\Http\Controllers;

use App\User;
use App\Employee;
use App\Orientation;
use Auth;
use Validator;
use Input;
use Redirect;
use Response;
use Session;
use Hash;
use Image;

class OrientationController extends Controller {


	public function index()
	{
    if(self::checkUserPermissions("hrm_orientation_can_view"))
		{
      $data['title'] = "Orientations";
      $data['activeLink'] = "orientation";
			$data['subTitle'] = "Staff Orientation Records";
      $data['orientations'] = Orientation::orderBy("updated_at","DESC")->paginate(20);

      $data['subLinks'] = array(
        array
        (
          "title" => "Add Orientation",
          "route" => "/hrm/orientations/add",
          "icon" => "<i class='fa fa-plus'></i>",
          "permission" => "hrm_orientation_can_add"
        ),
        array
        (
          "title" => "Search for Orientation",
					"route" => "/hrm/orientations/search",
          "icon" => "<i class='fa fa-search'></i>",
          "permission" => "hrm_orientation_can_search"
        )
      );


      return view('dashboard.hrm.orientations.index',$data);
    }
    else
    {
        return "You are not authorized";die();
    }
  }

  public function add()
	{
		if(self::checkUserPermissions("hrm_orientation_can_add"))
		{
      $data['title'] = "Add Orientation";
      $data['activeLink'] = "orientation";
			$data['subTitle'] = "Add Staff Orientation";
      $data['subLinks'] = array(
        array
        (
          "title" => "List of Orientations",
          "route" => "/hrm/orientations",
          "icon" => "<i class='fa fa-th-list'></i>",
          "permission" => "hrm_orientation_can_view"
        )
      );

      //to avoid undefined employee_name error
      $data['employee_name'] = "";

      return view('dashboard.hrm.orientations.add',$data);
    }
    else
    {
        return "You are not authorized";die();
    }
	}

  public function create()
  {
    if(self::checkUserPermissions("hrm_orientation_can_add"))
		{
      $rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/hrm/orientations/add')
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
						return Redirect::to('/hrm/orientations/add')
									->withErrors("Employee not active")
									->withInput();
					}

					$employeeId = $employeeDetails->id;

          $orientation = new Orientation;

          $orientation -> orientation_start_date = Input::get("orientation_start_date");
          $orientation -> orientation_end_date = Input::get("orientation_end_date");
          $orientation -> orientation_outcome = Input::get("orientation_outcome");
          $orientation -> employee_id = $employeeId;

          $orientation -> save();
          Session::flash('message','Orientation Saved');
          return Redirect::to('/hrm/orientations');
				}
				else
				{
					return Redirect::to('/hrm/orientations/add')
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

  public function edit($id)
  {
    if(self::checkUserPermissions("hrm_orientation_can_edit"))
		{
      		$orientation = Orientation::find($id);

    			$data['title'] = "Edit Orientation";
    			$data['activeLink'] = "orientation";
					$data['subTitle'] = "Edit Staff Orientation Details";
    			$data['subLinks'] = array(
    				array
    				(
    					"title" => "Orientation List",
    					"route" => "/hrm/orientations",
    					"icon" => "<i class='fa fa-th-list'></i>",
    					"permission" => "hrm_orientation_can_view"
    				)
    			);
    			$data['orientation'] = $orientation;

          $data['orientation_outcome'] = $orientation -> orientation_outcome;

    			$employee = \DB::table("employees")->where("id",$orientation->employee_id)->get();

    			$data['employee_name'] = $employee[0]->first_name . " " . $employee[0]->last_name . " " . "(".$employee[0]->email.")";

    			return view('dashboard.hrm.orientations.edit',$data);
    }
    else
    {
        return "You are not authorized";die();
    }

  }

  public function update($id)
  {
    if(self::checkUserPermissions("hrm_orientation_can_edit"))
		{
      $rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/hrm/orientations/edit/'.$id)
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

          $orientation = Orientation::find($id);

          $orientation -> orientation_start_date = Input::get("orientation_start_date");
          $orientation -> orientation_end_date = Input::get("orientation_end_date");
          $orientation -> orientation_outcome = Input::get("orientation_outcome");
          $orientation -> employee_id = $employeeId;

          $orientation -> push();
          Session::flash('message','Orientation Updated');
          return Redirect::to('/hrm/orientations');
				}
				else
				{
					return Redirect::to('/hrm/orientations/edit/'.$id)
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
		if(self::checkUserPermissions("hrm_orientation_can_view"))
		{
			$orientation = Orientation::find($id);

			$data['title'] = "View Orientation";
			$data['activeLink'] = "orientation";
			$data['subTitle'] = "View Staff Orientation Details";
			$data['orientation'] = $orientation;

			$data['subLinks'] = array(
				array
				(
					"title" => "Orientation List",
					"route" => "/hrm/orientations",
					"icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "hrm_orientation_can_view"
				),
				array
				(
					"title" => "Add Orientation",
					"route" => "/hrm/orientations/add",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "hrm_orientation_can_add"
				),
				array
				(
					"title" => "Edit Orientation",
					"route" => "/hrm/orientations/edit/".$id,
					"icon" => "<i class='fa fa-pencil'></i>",
					"permission" => "hrm_orientation_can_edit"
				),
				array
				(
					"title" => "Delete Orientation",
					"route" => "/hrm/orientations/delete/".$id,
					"icon" => "<i class = 'fa fa-trash'></i>",
					"permission" => "hrm_orientation_can_delete"
				)
			);


			return view('dashboard.hrm.orientations.view',$data);
		}
		else
		{
				return "You are not authorized";die();
		}
	}


  public function delete($id)
  {
    if(self::checkUserPermissions("hrm_orientation_can_delete"))
    {
      $orientation = Orientation::find($id);

      $orientation -> delete();

      Session::flash('message', 'Orientation deleted');
      return Redirect::to("/hrm/orientations");
    }
    else
    {
      return "You are not authorized";die();
    }
  }

	public function search()
	{
		if(self::checkUserPermissions("hrm_orientation_can_search"))
		{
			$data['title'] = "Search for Orientation";
			$data['activeLink'] = "orientation";
			$data['subTitle'] = "Search for Staff Orientation Record";
			$data['subLinks'] = array(
				array
				(
					"title" => "Orientation List",
					"route" => "/hrm/orientations",
					"icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "hrm_orientation_can_view"
				),
				array
				(
					"title" => "Add Orientation",
					"route" => "/hrm/orientations/add",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "hrm_orientation_can_add"
				)
			);

			return view('dashboard.hrm.orientations.search',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function apiSearch($data)
	{
		$orientations = \DB::table("orientations")->select("orientations.id","orientation_start_date","orientation_end_date","orientation_outcome","first_name","last_name")
		->join("employees","employees.id","=","orientations.employee_id")
		->where("orientation_end_date",">=",new \DateTime(date('F jS Y h:i:s A', strtotime($data))))
		->where("orientation_start_date","<=",new \DateTime(date('F jS Y h:i:s A', strtotime($data))))
		->orWhere("first_name","ilike","%$data%")
		->orWhere("last_name","ilike","%$data%")
		->orWhere("orientation_outcome","ilike","%$data%")

		->get();
	return Response::json(
				$orientations
		);
	}

  public function getRules()
  {
    return array(
      'orientation_start_date' => 'required',
      'orientation_end_date' => 'required',
      'orientation_outcome' => 'required',
      'employee' => 'required'
    );

  }

}
