<?php namespace App\Http\Controllers;

use App\Role;
use App\Permission;
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
	    $data['title'] = "Company Details";

			return view('dashboard.company.index',$data);
		}
		else
		{
				return "You are not authorized";die();
		}
  }

}
