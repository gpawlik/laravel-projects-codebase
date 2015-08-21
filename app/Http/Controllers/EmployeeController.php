<?php namespace App\Http\Controllers;

use App\Role;
use App\Employee;
use App\Bank;
use App\Identification;
use App\Job;
use Excel;
use App\Tax;
use App\Branch;
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
	    $data['employees'] =	\DB::table("employees")->where("employment_status","ACTIVE")->orderBy("updated_at","DESC")->paginate(20);
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
					"route" => "/hrm/employees/search",
					"icon" => "<i class='fa fa-search'></i>",
					"permission" => "hrm_employee_can_search"
				),
				array
				(
					'title' => 'Export To XLS',
					'route' => '/hrm/employees/exportXLS',
					'icon' => '<i class="fa fa-file-excel-o"></i>',
					"permission" => "hrm_employee_can_export"
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

			//get ranks
			// $ranks = \DB::table("ranks")->orderBy("rank_name","ASC")->get();
			//
			// $ranks_array = array();
			//
      // foreach ($ranks as $rank) {
      //   $ranks_array[$rank->id] = $rank->rank_name;
      // }
			//
			// $data['ranks'] = $ranks_array;

			//get branches
			$branches = \DB::table("branches")->orderBy("branch_name","ASC")->get();

			$branches_array = array();

      foreach ($branches as $branch) {
        $branches_array[$branch->id] = $branch->branch_name;
      }

			$data['branches'] = $branches_array;

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
			$rules["staff_number"] = "required | unique:employees";

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
				$employee -> basic_salary = (Input::get("basic_salary") == ""? 0 : Input::get("basic_salary"));
				$employee -> employee_welfare_contribution = (Input::get("employee_welfare_contribution") == ""? 0: Input::get("employee_welfare_contribution"));
				$employee -> allowances = (Input::get("allowances") == ""? 0 : Input::get("allowances"));
				$employee -> branch_id = Input::get("branch");

				if(Input::get("tax_identification_number"))
				{
					$employee -> tax_identification_number = Input::get("tax_identification_number");
				}
				else
				{
					$employee -> tax_identification_number = null;
				}

				if(Input::get("number_of_dependants"))
				{
					$employee -> number_of_dependants = Input::get("number_of_dependants");
				}
				else
				{
					$employee -> number_of_dependants = null;
				}

				$employee -> identification_id = Input::get("identification");
				$employee -> identification_number = Input::get("identification_number");
				//$employee -> leave_entitlement_days = (Input::get("leave_entitlement_days") == ""?0:Input::get("leave_entitlement_days"));

				$employee -> job_id = Input::get("job");
				$employee -> bank_id = Input::get("bank");
				//$employee -> rank_id = Input::get("rank");
				$employee -> employment_status = "ACTIVE";

				// //calculate net salary
				// $grossSalary = (Input::get("gross_salary") == ""? 0 : Input::get("gross_salary"));
				// $incomeTax = (Input::get("income_tax") == ""? 0 : Input::get("income_tax"));
				// $ssnit = (Input::get("ssnit") == ""? 0 : Input::get("ssnit"));
				// $employerWelfare = (Input::get("employer_welfare_contribution") == ""? 0: Input::get("employer_welfare_contribution"));
				// $employeeWelfare = (Input::get("employee_welfare_contribution") == ""? 0: Input::get("employee_welfare_contribution"));
				// $allowances = (Input::get("allowances") == ""? 0 : Input::get("allowances"));
				//
				// $netSalary = $grossSalary - ($incomeTax + $ssnit + $employerWelfare + $employeeWelfare) + $allowances;
				//
				// $employee -> net_salary = $netSalary;

				$employee -> save();

				self::calculateEmployeesNetSalary();

				Session::flash('message','Employee Added');
				return Redirect::to('/hrm/employees');

			}
    }
    else
    {
        return "You are not authorized";die();
    }
	}

	public function edit($id)
	{
		if(self::checkUserPermissions("hrm_employee_can_edit"))
		{
			$employee = Employee::find($id);

			$data['title'] = "Edit Employee";
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

			$data['employee'] = $employee;

			//get banks
			$banks = \DB::table("banks")->orderBy("bank_name","ASC")->get();

			$banks_array = array();

      foreach ($banks as $bank) {
        $banks_array[$bank->id] = $bank->bank_name;
      }

			$data['banks'] = $banks_array;
			$data['employees_bank'] = Bank::where('id','=',$employee -> bank_id)->first();

			//get jobs
			$jobs = \DB::table("jobs")->orderBy("job_title","ASC")->get();

			$jobs_array = array();

      foreach ($jobs as $job) {
        $jobs_array[$job->id] = $job->job_title;
      }

			$data['jobs'] = $jobs_array;
			$data['employees_job'] = Job::where('id','=',$employee -> job_id)->first();

			//get identification
			$ids = \DB::table("identification")->orderBy("identification_name","ASC")->get();

			$ids_array = array();

      foreach ($ids as $id) {
        $ids_array[$id->id] = $id->identification_name;
      }

			$data['ids'] = $ids_array;
			$data['employees_id'] = Identification::where('id','=',$employee -> identification_id)->first();

			//get ranks
			// $ranks = \DB::table("ranks")->orderBy("rank_name","ASC")->get();
			//
			// $ranks_array = array();
			//
      // foreach ($ranks as $rank) {
      //   $ranks_array[$rank->id] = $rank->rank_name;
      // }
			//
			// $data['ranks'] = $ranks_array;
			//$data['employees_rank'] = Rank::where('id','=',$employee -> rank_id)->first();

			//get branches
			$branches = \DB::table("branches")->orderBy("branch_name","ASC")->get();

			$branches_array = array();

      foreach ($branches as $branch) {
        $branches_array[$branch->id] = $branch->branch_name;
      }

			$data['branches'] = $branches_array;
			$data['employees_branch'] = Branch::where('id','=',$employee -> branch_id)->first();

			return view('dashboard.hrm.employees.edit',$data);
		}
		else
		{
				return "You are not authorized";die();
		}
	}

	public function update($id)
	{
		if(self::checkUserPermissions("hrm_employee_can_edit"))
		{
			$employee = Employee::find($id);

			$rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/hrm/employees/edit/'.$id)
	        		->withErrors($validator)
	        		->withInput();
			}
	    else
	    {
				//DEAL WITH IMAGE FILE
	      if(Input::file(('picture_name')))
	      {
	          if($employee -> picture_name != null)
	          {
	            if (file_exists(public_path('uploads/'.$employee -> picture_name)))
	        		{
	              unlink(public_path('uploads/'.$employee -> picture_name));
	        		}
	          }

	          $image = Input::file('picture_name');

	          $destinationImagePath = public_path('uploads/' . str_replace(" ","_",$image->getClientOriginalName()));

	          $resizedImage = Image::make($image)->resize(200,200);

	          $employee -> picture_name = str_replace(" ","_",$image->getClientOriginalName());

	          $resizedImage -> save($destinationImagePath);

	      }
	      else
	      {
					if(Input::get("clear_check") == 'yes')
	        {
	          if(file_exists(public_path('uploads/'.$employee -> picture_name)))
	          {
	            unlink(public_path('uploads/'.$employee -> picture_name));
	          }
	          $employee -> picture_name = null;
	        }
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
				$employee -> basic_salary = (Input::get("basic_salary") == ""? 0 : Input::get("basic_salary"));
				$employee -> employee_welfare_contribution = (Input::get("employee_welfare_contribution") == ""? 0: Input::get("employee_welfare_contribution"));
				$employee -> allowances = (Input::get("allowances") == ""? 0 : Input::get("allowances"));
				$employee -> branch_id = Input::get("branch");

				if(Input::get("tax_identification_number"))
				{
					$employee -> tax_identification_number = Input::get("tax_identification_number");
				}
				else
				{
					$employee -> tax_identification_number = null;
				}

				if(Input::get("number_of_dependants"))
				{
					$employee -> number_of_dependants = Input::get("number_of_dependants");
				}
				else
				{
					$employee -> number_of_dependants = null;
				}

				$employee -> identification_id = Input::get("identification");
				$employee -> identification_number = Input::get("identification_number");
				//$employee -> leave_entitlement_days = (Input::get("leave_entitlement_days") == ""?0:Input::get("leave_entitlement_days"));

				$employee -> job_id = Input::get("job");
				$employee -> bank_id = Input::get("bank");
				//$employee -> rank_id = Input::get("rank");

				// //calculate net salary
				// $grossSalary = (Input::get("gross_salary") == ""? 0 : Input::get("gross_salary"));
				// $incomeTax = (Input::get("income_tax") == ""? 0 : Input::get("income_tax"));
				// $ssnit = (Input::get("ssnit") == ""? 0 : Input::get("ssnit"));
				// $employerWelfare = (Input::get("employer_welfare_contribution") == ""? 0: Input::get("employer_welfare_contribution"));
				// $employeeWelfare = (Input::get("employee_welfare_contribution") == ""? 0: Input::get("employee_welfare_contribution"));
				// $allowances = (Input::get("allowances") == ""? 0 : Input::get("allowances"));
				//
				// $netSalary = $grossSalary - ($incomeTax + $ssnit + $employerWelfare + $employeeWelfare) + $allowances;
				//
				// $employee -> net_salary = $netSalary;

				$employee -> push();

				self::calculateEmployeesNetSalary();

				Session::flash('message', "Employee Details Updated");
				return Redirect::to("/hrm/employees");

			}

		}
		else
		{
				return "You are not authorized";die();
		}
	}

	public function view($id)
	{
		if(self::checkUserPermissions("hrm_employee_can_view"))
		{
			$employee = Employee::find($id);

			$data['title'] = "View Employee Details";
			$data['activeLink'] = "employee";
			$data['subLinks'] = array(
				array
				(
					"title" => "Employee List",
					"route" => "/hrm/employees",
					"icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "hrm_employee_can_view"
				),
				array
				(
					"title" => "Add Employee",
					"route" => "/hrm/employees/add",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "hrm_employee_can_add"
				),
				array
				(
					"title" => "Edit Employee",
					"route" => "/hrm/employees/edit/".$id,
					"icon" => "<i class='fa fa-pencil'></i>",
					"permission" => "hrm_employee_can_edit"
				),
				array
				(
					"title" => "Delete Employee",
					"route" => "/hrm/employees/delete/".$id,
					"icon" => "<i class = 'fa fa-trash'></i>",
					"permission" => "hrm_employee_can_delete"
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

	public function delete($id)
	{
		if(self::checkUserPermissions("hrm_employee_can_delete"))
		{
			$employee = Employee::find($id);

	    if($employee -> picture_name != null)
			{

	      if (file_exists(public_path('uploads/'.$employee -> picture_name)))
	  		{
	        unlink(public_path('uploads/'.$employee -> picture_name));
	  		}

	    }

	    $employee -> delete();

	    Session::flash('message', 'Employee deleted');
			return Redirect::to("/hrm/employees");
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function apiGetEmployees($data)
	{
		$data = ucfirst($data);
		$employees = \DB::table("employees")->where("employment_status","ACTIVE")->where("first_name","like","%$data%")
			->orWhere("last_name","like","%$data%")
			->where("employment_status","ACTIVE")->get();
		return Response::json(
					$employees
			);
	}

	public function search()
	{
		if(self::checkUserPermissions("hrm_employee_can_search"))
		{
			$data['title'] = "Search For an Employee";
			$data['activeLink'] = "employee";
			$data['subLinks'] = array(
				array
				(
					"title" => "Employee List",
					"route" => "/hrm/employees",
					"icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "hrm_employee_can_view"
				),
				array
				(
					"title" => "Add Employee",
					"route" => "/hrm/employees/add",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "hrm_employee_can_add"
				)
			);

			return view('dashboard.hrm.employees.search',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function apiSearch($data)
	{
		$employees = \DB::table("employees")->select('id', 'staff_number', 'first_name', 'last_name', 'email')
			->where("employment_status","ACTIVE")->where("first_name","ilike","%$data%")
			->orWhere("last_name","ilike","%$data%")->where("employment_status","ACTIVE")
			->orWhere("email","ilike","%$data%")->where("employment_status","ACTIVE")
			->get();
		return Response::json(
					$employees
			);
	}

	public static function calculateEmployeesNetSalary()
	{
		$employees = Employee::all();
		$taxModel = Tax::all();
		$ssnit = \DB::table("hrm_config")->get()[0]->ssnit_percentage;

		$employerWelfareContribution = \DB::table("hrm_config")->get()[0]->employer_welfare_contribution;

		foreach($employees as $employee)
		{
			$taxAmount = 0;
			$employeeBasicSalary = $employee -> basic_salary;

			//taxable after ssnit deduction
			$employeeTaxable = $employeeBasicSalary - (($ssnit / 100) * $employeeBasicSalary);

			$salaryTracker = $employeeTaxable;

			foreach($taxModel as $tax)
			{
				if($tax -> step == "first")
				{
					if($salaryTracker > $tax -> amount_limit)
					{
						$salaryTracker -= $tax -> amount_limit;
						$taxAmount += (($tax -> rate) / 100) * ($tax -> amount_limit);
					}
					else
					{
						$taxAmount += (($tax -> rate) / 100) * ($salaryTracker);
						break;
					}
				}

				if($tax -> step == "next")
				{
					if($salaryTracker > $tax -> amount_limit)
					{
						$salaryTracker -= $tax -> amount_limit;
						$taxAmount += (($tax -> rate) / 100) * ($tax -> amount_limit);
					}
					else
					{
						$taxAmount += (($tax -> rate) / 100) * ($salaryTracker);
						break;
					}


				}

				if($tax -> step == "exceeding")
				{
					$taxAmount += (($tax -> rate) / 100) * ($salaryTracker);
					break;
				}

			}

			$employeeTakeHome = $employeeTaxable  - $taxAmount;

			$employeeNetSalary = $employeeTakeHome + ($employee -> allowances)  - ( $employee -> employee_welfare_contribution +  $employerWelfareContribution);


			$employee -> taxable_salary = $employeeTaxable;

			$employee -> tax_amount = $taxAmount;

			$employee -> ssnit_amount = (($ssnit / 100) * $employeeBasicSalary);

			$employee -> net_salary = $employeeNetSalary;

			$employee -> save();
		}
	}

	public function exportXLS()
  {
    Excel::create('Employees Report', function($excel) {

      $excel->sheet('Employees Report', function($sheet) {
        $employees = \DB::table("employees")->where("employment_status","ACTIVE")->orderBy('last_name','ASC')->get();
        $sheet->loadView('dashboard.hrm.employees.reports.xls_report', ['employees' => $employees]);
      });
    })->download('xls');
  }

	public function getRules()
	{
		return array(
			'staff_number' => 'required',
			'first_name' => 'required',
			'last_name' => 'required',
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
			'job' => 'required'
			//'rank' => 'required',
		);

	}

}
