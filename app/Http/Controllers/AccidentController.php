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
      $data['supervisor_name'] = "";

      return view('dashboard.hrm.accidents.add',$data);
    }
    else
    {
        return "You are not authorized";die();
    }
  }

  public function create()
  {

  }

}
