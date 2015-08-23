<?php namespace App\Http\Controllers;

use App\User;
use App\Employee;
use App\Loan;
use App\Bank;
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
      $data['title'] = "Loans";
      $data['activeLink'] = "loan";
			$data['subTitle'] = "Staff Loans";
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
			$data['subTitle'] = "Add Staff Loan";
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
    if(self::checkUserPermissions("hrm_loan_can_edit"))
		{
  		$loan = Loan::find($id);

			$data['title'] = "Edit Loan";
			$data['activeLink'] = "loan";
			$data['subTitle'] = "Edit Staff Loan Details";
			$data['subLinks'] = array(
				array
				(
					"title" => "Loan List",
					"route" => "/hrm/loans",
					"icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "hrm_loan_can_view"
				)
			);
			$data['loan'] = $loan;

      $data['loan_type'] = $loan -> loan_type;

			$employee = \DB::table("employees")->where("id",$loan->employee_id)->get();

			$data['employee_name'] = $employee[0]->first_name . " " . $employee[0]->last_name . " " . "(".$employee[0]->email.")";

			//get jobs
			$banks = \DB::table("banks")->orderBy("bank_name","ASC")->get();

			$banks_array = array();

			foreach ($banks as $bank) {
        $banks_array[$bank->id] = $bank->bank_name;
      }

			$data['banks'] = $banks_array;

			$data['loans_bank'] = Bank::where('id','=',$loan -> bank_id)->first();

			return view('dashboard.hrm.loans.edit',$data);
    }
    else
    {
        return "You are not authorized";die();
    }
  }

  public function update($id)
  {
		if(self::checkUserPermissions("hrm_loan_can_edit"))
		{
			$rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/hrm/loans/edit/'.$id)
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
						return Redirect::to('/hrm/loans/edit/'.$id)
									->withErrors("Employee not active")
									->withInput();
					}

					$employeeId = $employeeDetails->id;

          $loan = Loan::find($id);

          if(Input::get("loan_type") == "BANK LOAN" && !Input::get("bank"))
          {
            return Redirect::to('/hrm/loans/edit/'.$id)
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

          $loan -> push();
          Session::flash('message','Loan Details Updated');
          return Redirect::to('/hrm/loans');
				}
				else
				{
					return Redirect::to('/hrm/loans/edit/'.$id)
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
		if(self::checkUserPermissions("hrm_loan_can_view"))
		{
			$loan = Loan::find($id);

			$data['title'] = "View Staff Loan Details";
			$data['activeLink'] = "loan";
			$data['subTitle'] = "View Staff Loan Details";
			$data['subLinks'] = array(
				array
				(
					"title" => "Employee Loan List",
					"route" => "/hrm/loans",
					"icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "hrm_loan_can_view"
				),
				array
        (
          "title" => "Add Loan",
          "route" => "/hrm/loans/add",
          "icon" => "<i class='fa fa-plus'></i>",
          "permission" => "hrm_loan_can_add"
        ),
				array
				(
					"title" => "Edit Loan details",
					"route" => "/hrm/loans/edit/".$id,
					"icon" => "<i class='fa fa-pencil'></i>",
					"permission" => "hrm_loan_can_edit"
				),
				array
				(
					"title" => "Delete Loan",
					"route" => "/hrm/loan/delete/".$id,
					"icon" => "<i class = 'fa fa-trash'></i>",
					"permission" => "hrm_loan_can_delete"
				),
				array(
					"title" => "Mark as Paid",
					"route" => "/hrm/loans/payment_finished/".$id,
					"icon" => "<i class='fa fa-check-circle'></i>",
					"permission" => "hrm_loan_can_complete"
				),
				array(
					"title" => "Revert Payment",
					"route" => "/hrm/loans/revert_payment/".$id,
					"icon" => "<i class='fa fa-undo'></i>",
					"permission" => "hrm_loan_can_revert"
				)
			);

			$data['loan'] = $loan;

			return view('dashboard.hrm.loans.view',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
  }

  public function delete($id)
  {
		if(self::checkUserPermissions("hrm_loan_can_delete"))
    {
      $loan = Loan::find($id);

      $loan -> delete();

      Session::flash('message', 'Loan deleted');
      return Redirect::to("/hrm/loans");
    }
    else
    {
      return "You are not authorized";die();
    }
  }

	public function paymentFinished($id)
	{
		$loan = Loan::find($id);

		$loan -> payment_status = "PAID";

		$loan -> push();
		Session::flash('message','Loan Payment Done');
		return Redirect::to('/hrm/loans');
	}

	public function revertPayment($id)
	{
		$loan = Loan::find($id);

		$loan -> payment_status = "PAYING";

		$loan -> push();
		Session::flash('message','Loan Payment Reverted');
		return Redirect::to('/hrm/loans');
	}

	public function search()
	{
		if(self::checkUserPermissions("hrm_loan_can_search"))
		{
			$data['title'] = "Search for Loan";
			$data['activeLink'] = "loan";
			$data['subTitle'] = "Search for Staff Loan";
			$data['subLinks'] = array(
				array
				(
					"title" => "Loan List",
					"route" => "/hrm/loans",
					"icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "hrm_loan_can_view"
				),
				array
				(
					"title" => "Add Loan",
					"route" => "/hrm/loans/add",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "hrm_loan_can_add"
				)
			);

			return view('dashboard.hrm.loans.search',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function apiSearch($data)
	{
		$loans = \DB::table("staff_loans")->select("staff_loans.id","start_date","end_date","payment_status","loan_type","first_name","last_name")
		->join("employees","employees.id","=","staff_loans.employee_id")
		->where("end_date",">=",new \DateTime(date('F jS Y h:i:s A', strtotime($data))))
		->where("start_date","<=",new \DateTime(date('F jS Y h:i:s A', strtotime($data))))
		->orWhere("first_name","ilike","%$data%")
		->orWhere("last_name","ilike","%$data%")
		->orWhere("payment_status","ilike","%$data%")
		->orWhere("loan_type","ilike","%$data%")
		->get();
	return Response::json(
				$loans
		);
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
