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
    if(self::checkUserPermissions("employees_employee_can_view"))
		{
      $data['title'] = "Employees Data";
	    $data['employees'] = Employee::orderBy("updated_at","DESC")->paginate(20);
      $data['activeLink'] = "identification";
			$data['subLinks'] = array(
				array
				(
					"title" => "Add Employee",
					"route" => "/employees/employees_data/add",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "system_identification_can_add"
				),
				array
				(
					"title" => "Search for employee",
					"icon" => "<i class='fa fa-search'></i>",
					"permission" => "employees_employee_can_search"
				)
			);

      return view('dashboard.employees.employees_data.index',$data);
    }
    else
    {
        return "You are not authorized";die();
    }
  }

}
