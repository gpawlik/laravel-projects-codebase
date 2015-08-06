<?php namespace App\Http\Controllers;

use App\Role;
use App\Employee;
use App\Bank;
use App\Identification;
use Validator;
use Image;
use Hash;
use Session;
use Input;
use Redirect;
use Response;
use Auth;


class EmployeeController extends Controller {

	public function index()
	{
    if(self::checkUserPermissions("hrm_employee_can_view"))
		{
      $data['title'] = "Employees Data";
	    $data['employees'] = Employee::orderBy("updated_at","DESC")->paginate(20);
      $data['activeLink'] = "employee";
			$data['subLinks'] = array(
				array
				(
					"title" => "Add Employee",
					"route" => "/hrm/employees/add",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "hrm_employee_can_add"
				),
				array
				(
					"title" => "Search for employee",
					"icon" => "<i class='fa fa-search'></i>",
					"permission" => "hrm_employee_can_search"
				)
			);

      return view('dashboard.hrm.employees.index',$data);
    }
    else
    {
        return "You are not authorized";die();
    }
  }

	public function add()
	{
		if(self::checkUserPermissions("hrm_employee_can_add"))
		{
			$data['title'] = "Add Employee";
			$data['activeLink'] = "employee";

			//get banks
			$banks = \DB::table("banks")->orderBy("bank_name","ASC")->get();

			$banks_array = array();

      foreach ($banks as $bank) {
        $banks_array[$bank->id] = $bank->bank_name;
      }

			$data['banks'] = $banks_array;

			//get jobs
			$jobs = \DB::table("jobs")->orderBy("job_title","ASC")->get();

			$jobs_array = array();

      foreach ($jobs as $job) {
        $jobs_array[$job->id] = $job->job_title;
      }

			$data['jobs'] = $jobs_array;

      return view('dashboard.hrm.employees.add',$data);
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
