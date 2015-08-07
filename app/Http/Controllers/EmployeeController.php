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
			$data['subLinks'] = array(
        array
        (
          "title" => "Employee List",
          "route" => "/hrm/employees",
          "icon" => "<i class='fa fa-th-list'></i>",
          "permission" => "hrm_employee_can_view"
        )
      );

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

			//get identification
			$ids = \DB::table("identification")->orderBy("identification_name","ASC")->get();

			$ids_array = array();

      foreach ($ids as $id) {
        $ids_array[$id->id] = $id->identification_name;
      }

			$data['ids'] = $ids_array;

      return view('dashboard.hrm.employees.add',$data);
    }
    else
    {
        return "You are not authorized";die();
    }
	}

	public function create()
	{
		if(self::checkUserPermissions("hrm_employee_can_add"))
		{
			$rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/hrm/employees/add')
							->withErrors($validator)
							->withInput();
			}
			else
			{
				$employee = new Employee;

				//check if picture is uploaded and do the necessaries
				if(Input::file(('picture_name')))
	      {

		      $image = Input::file('picture_name');

		      $destinationImagePath = public_path('uploads/' . str_replace(" ","_",$image->getClientOriginalName()));

		      $resizedImage = Image::make($image)->resize(200,200);

		      $employee -> picture_name = str_replace(" ","_",$image->getClientOriginalName());

		      $resizedImage -> save($destinationImagePath);
	      }
				else
	      {
	        $employee -> picture_name = null;
	      }

				//insert values
				$employee -> staff_number = Input::get("staff_number");
				$employee -> first_name = Input::get("first_name");
				$employee -> last_name = Input::get("last_name");

				if(Input::get("other_names"))
				{
					$employee -> other_names = Input::get("other_names");
				}
				else
				{
					$employee -> other_names = null;
				}

				$employee -> date_of_birth = Input::get("date_of_birth");
				$employee -> marital_status = Input::get("marital_status");

				if(Input::get("spouse_name"))
				{
					$employee -> spouse_name = Input::get("spouse_name");
				}
				else
				{
					$employee -> spouse_name = null;
				}

				$employee -> next_of_kin = Input::get("next_of_kin");
				$employee -> gender = Input::get("gender");

				if(Input::get("social_security_number"))
				{
					$employee -> social_security_number = Input::get("social_security_number");
				}
				else
				{
					$employee -> social_security_number = null;
				}

				$employee -> email = Input::get("email");
				$employee -> telephone_number = Input::get("telephone_number");
				$employee -> mailing_address = Input::get("mailing_address");
				$employee -> residential_address = Input::get("residential_address");
				$employee -> emergency_contact_name = Input::get("emergency_contact_name");
				$employee -> emergency_contact_number = Input::get("emergency_contact_number");

				if(Input::get("alergies"))
				{
					$employee -> alergies = Input::get("alergies");
				}
				else
				{
					$employee -> alergies = null;
				}

				$employee -> fathers_name = Input::get("fathers_name");
				$employee -> mothers_name = Input::get("mothers_name");
				$employee -> bank_account_number = Input::get("bank_account_number");
				$employee -> qualifications = Input::get("qualifications");
				$employee -> date_of_hire = Input::get("date_of_hire");
				$employee -> basic_salary = Input::get("basic_salary");

				$employee -> identification_id = Input::get("identification");
				$employee -> identification_number = Input::get("identification_number");

				$employee -> job_id = Input::get("job");
				$employee -> bank_id = Input::get("bank");

				$employee -> save();
				Session::flash('message','Employee Added');
				return Redirect::to('/hrm/employees');

			}
    }
    else
    {
        return "You are not authorized";die();
    }
	}

	public function getRules()
	{
		return array(
			'staff_number' => 'required',
			'first_name' => 'required',
			'last_name' => 'required',
			'other_names' => 'required',
			'date_of_birth' => 'required',
			'marital_status' => 'required',
			'next_of_kin' => 'required',
			'gender' => 'required',
			'email' => 'required',
			'telephone_number' => 'required',
			'mailing_address' => 'required',
			'residential_address' => 'required',
			'emergency_contact_name' => 'required',
			'emergency_contact_number' => 'required',
			'fathers_name' => 'required',
			'mothers_name' => 'required',
			'bank' => 'required',
			'bank_account_number' => 'required',
			'identification' => 'required',
			'identification_number' => 'required',
			'qualifications' => 'required',
			'date_of_hire' => 'required',
			'basic_salary' => 'required',
			'job' => 'required',
			'basic_salary' => 'required',
		);

	}

}
