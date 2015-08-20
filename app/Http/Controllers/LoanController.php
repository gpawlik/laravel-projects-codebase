<?php namespace App\Http\Controllers;

use App\User;
use App\Employee;
use App\Loan;
use Auth;
use Validator;
use Input;
use Redirect;
use Response;
use Session;
use Hash;
use Image;

class LoanController extends Controller {


	public function index()
	{
    if(self::checkUserPermissions("hrm_loan_can_view"))
		{
      $data['title'] = "loans";
      $data['activeLink'] = "loan";
      $data['loans'] = Loan::orderBy("updated_at","DESC")->paginate(20);

      $data['subLinks'] = array(
        array
        (
          "title" => "Add Loan",
          "route" => "/hrm/loans/add",
          "icon" => "<i class='fa fa-plus'></i>",
          "permission" => "hrm_loan_can_add"
        ),
        array
        (
          "title" => "Search for Loan",
					"route" => "/hrm/loans/search",
          "icon" => "<i class='fa fa-search'></i>",
          "permission" => "hrm_loan_can_search"
        )
      );


      return view('dashboard.hrm.loans.index',$data);
    }
    else
    {
        return "You are not authorized";die();
    }

  }

  public function add()
  {
    if(self::checkUserPermissions("hrm_loan_can_add"))
		{
      $data['title'] = "Add Loan";
      $data['activeLink'] = "loan";
      $data['subLinks'] = array(
        array
        (
          "title" => "List of Loans",
          "route" => "/hrm/loans",
          "icon" => "<i class='fa fa-th-list'></i>",
          "permission" => "hrm_loan_can_view"
        )
      );

      //get banks
			$banks = \DB::table("banks")->orderBy("bank_name","ASC")->get();

			$banks_array = array();

      foreach ($banks as $bank) {
        $banks_array[$bank->id] = $bank->bank_name;
      }

			$data['banks'] = $banks_array;


      //to avoid undefined employee_name error
      $data['employee_name'] = "";

      return view('dashboard.hrm.loans.add',$data);
    }
    else
    {
        return "You are not authorized";die();
    }
  }

  public function create()
  {
    if(self::checkUserPermissions("hrm_loan_can_add"))
		{
      $rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/hrm/loans/add')
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
						return Redirect::to('/hrm/loans/add')
									->withErrors("Employee not active")
									->withInput();
					}

					$employeeId = $employeeDetails->id;

          $loan = new Loan;

          if(Input::get("loan_type") == "BANK LOAN" && !Input::get("bank"))
          {
            return Redirect::to('/hrm/loans/add')
                  ->withErrors("Bank Required")
                  ->withInput();
          }

          $loan -> loan_type = Input::get("loan_type");
          $loan -> payment_frequency = Input::get("payment_frequency");
          $loan -> amount = Input::get("amount");
          $loan -> start_date = Input::get("start_date");
          $loan -> end_date = Input::get("end_date");
          $loan -> payment_status = "PAYING";

          if(Input::get("loan_type") == "BANK LOAN")
          {
            $loan -> bank_id = (Input::get("bank") == "" ? null : Input::get("bank"));
          }
          else
          {
            $loan -> bank_id = null;
          }

          $loan -> employee_id = $employeeId;

          $loan -> save();
          Session::flash('message','Loan Details Saved');
          return Redirect::to('/hrm/loans');
				}
				else
				{
					return Redirect::to('/hrm/loans/add')
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
    if(self::checkUserPermissions("hrm_loans_can_edit"))
		{
      		$orientation = Orientation::find($id);

    			$data['title'] = "Edit Orientation";
    			$data['activeLink'] = "orientation";
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

  }

  public function view($id)
  {

  }

  public function delete($id)
  {

  }


  public function getRules()
  {
    return array(
      'payment_frequency' => 'required',
      'amount' => 'required',
      'start_date' => 'required',
      'end_date' => 'required',
			'employee' => 'required'
    );

  }
}
