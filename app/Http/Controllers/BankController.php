<?php namespace App\Http\Controllers;

use App\Role;
use App\Permission;
use App\Bank;
use Validator;
use Image;
use Hash;
use Session;
use Input;
use Redirect;
use Response;
use Auth;


class BankController extends Controller {

	public function index()
	{
    if(self::checkUserPermissions("system_bank_can_view"))
		{
      $data['title'] = "Permissions";
	    $data['banks'] = Bank::orderBy("updated_at","DESC")->paginate(20);
      $data['activeLink'] = "bank";
			$data['subLinks'] = array(
				array
				(
					"title" => "Add Bank",
					"route" => "/system/banks/add",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "system_bank_can_add"
				),
				array
				(
					"title" => "Search for bank",
					"icon" => "<i class='fa fa-search'></i>",
					"permission" => "system_bank_can_search"
				)
			);

      return view('dashboard.system.banks.index',$data);
    }
    else
    {
        return "You are not authorized";die();
    }
  }

  public function add()
  {
    if(self::checkUserPermissions("system_bank_can_add"))
		{
      $data['title'] = "Banks";
      $data['activeLink'] = "bank";
      $data['subLinks'] = array(
        array
        (
          "title" => "Bank List",
          "route" => "/system/banks",
          "icon" => "<i class='fa fa-th-list'></i>",
          "permission" => "system_banks_can_view"
        )
      );

      return view('dashboard.system.banks.add',$data);
    }
    else
    {
        return "You are not authorized";die();
    }
  }

	public function create()
	{
		if(self::checkUserPermissions("system_bank_can_add"))
		{
			$rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/system/banks/add')
							->withErrors($validator)
							->withInput();
			}
			else
			{
				$bank = new Bank;

				$bank -> bank_name = Input::get("bank_name");
				$bank -> bank_swift_code = Input::get("bank_swift_code");

				$bank -> save();
				Session::flash('message','Bank Added');
				return Redirect::to('/system/banks');
			}
    }
    else
    {
        return "You are not authorized";die();
    }
	}

	public function edit($id)
	{
		if(self::checkUserPermissions("system_bank_can_edit"))
		{
	    $bank = Bank::find($id);

	    $data['title'] = "Edit Bank";
			$data['activeLink'] = "bank";
	    $data['subLinks'] = array(
	      array
	      (
	        "title" => "Bank List",
	        "route" => "/system/banks",
	        "icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "system_bank_can_view"
	      )
	    );
	    $data['bank'] = $bank;

	    return view('dashboard.system.banks.edit',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function update($id)
	{
		if(self::checkUserPermissions("system_bank_can_edit"))
		{
	    $bank = Bank::find($id);

			$rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/system/banks/edit/'.$id)
	        		->withErrors($validator)
	        		->withInput();
			}
	    else
	    {
				$bank -> bank_name = Input::get("bank_name");
				$bank -> bank_swift_code = Input::get("bank_swift_code");

				$bank -> push();
				Session::flash('message', "Bank Details Updated");
				return Redirect::to("/system/banks");
			}

		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function view($id)
	{
		if(self::checkUserPermissions("system_bank_can_view"))
		{
			$bank = Bank::find($id);

			$data['title'] = "View Bank Details";
			$data['activeLink'] = "bank";
			$data['subLinks'] = array(
				array
				(
					"title" => "Bank List",
					"route" => "/system/banks",
					"icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "system_bank_can_view"
				),
				array
				(
					"title" => "Add Bank",
					"route" => "/system/banks/add",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "system_bank_can_add"
				)
			);
			$data['bank'] = $bank;

			return view('dashboard.system.banks.view',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function delete($id)
	{
		if(self::checkUserPermissions("system_bank_can_delete"))
		{
			$bank = Bank::find($id);

			$bank -> delete();

			Session::flash('message', 'Bank deleted');
			return Redirect::to("/system/banks");
		}
		else
		{
			return "You are not authorized";die();
		}
	}

  public function getRules()
  {
    return array(
      'bank_name' => 'required'
    );

  }

}
