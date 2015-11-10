<?php namespace App\Http\Controllers;

use App\Http\Tasks\BankTasks;
use Illuminate\Http\Request;

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
	      	$data['title'] = "Banks";
			$data['banks'] = Bank::orderBy("updated_at","DESC")->paginate(20);
	      	$data['activeLink'] = "bank";
			$data['subTitle'] = "Banks";
			$data['subLinks'] = array(
				array
				(
					"title" => "Add Bank",
					"route" => "/system/banks/create",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "system_bank_can_add"
				),
				array
				(
					"title" => "Search for bank",
					"icon" => "<i class='fa fa-search'></i>",
					"route" => "/system/banks/search",
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

  public function create()
  {
  	if(self::checkUserPermissions("system_bank_can_add"))
	{
    	$data['title'] = "Add Bank";
      	$data['activeLink'] = "bank";
		$data['subTitle'] = "Add a Bank";
      	$data['subLinks'] = array(
        	array
        	(
          		"title" => "Bank List",
          		"route" => "/system/banks",
          		"icon" => "<i class='fa fa-th-list'></i>",
          		"permission" => "system_bank_can_view"
        	)
      );

      return view('dashboard.system.banks.add',$data);
    }
    else
    {
        return "You are not authorized";die();
    }
  }

	public function store(Request $request)
	{
		if(self::checkUserPermissions("system_bank_can_add"))
		{
			$rules = self::getRules();
			$rules["bank_name"] = "required | unique:banks";

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/system/banks/create')
							->withErrors($validator)
							->withInput();
			}
			else
			{
				$bank = new Bank;

				$model = BankTasks::insertIntoModel($bank,$request);

				$model -> save();
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
			$data['subTitle'] = "Edit a Bank";
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

	public function update(Request $request,$id)
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
				$model = BankTasks::insertIntoModel($bank,$request);
				
				$model -> push();
				Session::flash('message', "Bank Details Updated");
				return Redirect::to("/system/banks");
			}

		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function show($id)
	{
		if(self::checkUserPermissions("system_bank_can_view"))
		{
			$bank = Bank::find($id);

			$data['title'] = "View Bank Details";
			$data['activeLink'] = "bank";
			$data['subTitle'] = "View Bank Details";
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
					"route" => "/system/banks/create",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "system_bank_can_add"
				),
				array
				(
					"title" => "Edit Bank",
					"route" => "/system/banks/".$id."/edit",
					"icon" => "<i class='fa fa-pencil'></i>",
					"permission" => "system_bank_can_edit"
				),
				array
				(
					"title" => "Delete Bank",
					"route" => "/system/banks/delete/".$id,
					"icon" => "<i class = 'fa fa-trash'></i>",
					"permission" => "system_bank_can_delete"
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

	public function search()
	{
		if(self::checkUserPermissions("system_bank_can_search"))
		{
			$data['title'] = "Search for Bank";
			$data['activeLink'] = "bank";
			$data['subTitle'] = "Search For Bank";
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
					"route" => "/system/banks/create",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "system_bank_can_add"
				)
			);

			return view('dashboard.system.banks.search',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function apiSearch($data)
	{
		$banks = \DB::table("banks")->select("id","bank_name","bank_swift_code")
		->where("bank_name","ilike","%$data%")
		->orWhere("bank_swift_code","ilike","%$data%")
		->get();
		
		return Response::json(
				$banks
		);
	}

  public function getRules()
  {
    return array(
     	'bank_name' => 'required'
    );

  }

}
