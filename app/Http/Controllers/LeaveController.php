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

}
