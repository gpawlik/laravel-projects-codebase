<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Tasks\CommonTasks;
use App\Http\Tasks\CompanyTasks;

use App\Role;
use App\Permission;
use App\Company;
use Validator;
use Image;
use Hash;
use Session;
use Input;
use Redirect;
use Response;
use Auth;


class CompanyController extends Controller {

	public function index()
	{
		if(self::checkUserPermissions("system_company_can_edit"))
		{
	    	$data = CompanyTasks::populateIndexData();
			return view('dashboard.system.company.index',$data);
		}
		else
		{
			CommonTasks::throwUnauthorized();
		}
  	}

	public function save(Request $request)
	{
		if(self::checkUserPermissions("system_company_can_edit"))
		{
			CompanyTasks::saveCompanyDetails($request);
		}
		else
		{
			CommonTasks::throwUnauthorized();
		}
	}
}
