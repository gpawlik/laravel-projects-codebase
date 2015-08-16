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

      return view('dashboard.hrm.training.add',$data);
    }
	}

	public function create()
	{

	}

}
