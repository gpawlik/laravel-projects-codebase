<?php namespace App\Http\Controllers;

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
	    $data['title'] = "Company Details";
			$data['activeLink'] = "company";
			
			$companyDetailsContent = Company::all()->count();

			if($companyDetailsContent > 0)
			{
				$data['companyDetails'] =  Company::all()->first();
			}

			return view('dashboard.system.company.index',$data);
		}
		else
		{
				return "You are not authorized";die();
		}
  }

	public function save()
	{
		if(self::checkUserPermissions("system_company_can_edit"))
		{
			$rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/system/company')
							->withErrors($validator)
							->withInput();
			}
			else
			{
				$companyDetailsContent = Company::all()->count();

				if($companyDetailsContent > 0)
				{
					$companyDetails = Company::all()->first();

					if(Input::file('company_logo_name'))
					{
						if($companyDetails -> company_logo_name != null)
						{
							if(file_exists(public_path('uploads/' .$companyDetails -> company_logo_name)))
							{
								unlink(public_path("uploads/").$companyDetails -> company_logo_name);
							}
						}

						$image = Input::file('company_logo_name');

						$destinationImagePath = public_path('uploads/' . $image->getClientOriginalName());

						$resized_image = Image::make($image)->resize(200,200);

						$resized_image -> save($destinationImagePath);

						$companyDetails -> company_logo_name = $image -> getClientOriginalName();
					}
					else
					{
						if(Input::get('clear_check') == 'checked')
						{
							if(file_exists(public_path('uploads/' .$companyDetails -> company_logo_name)))
							{
								unlink(public_path("uploads/").$companyDetails -> company_logo_name);
							}
							$companyDetails -> company_logo_name = null;
						}

					}

					$companyDetails -> company_name = Input::get("company_name");
					$companyDetails -> company_description = Input::get("company_description");

					$companyDetails -> push();
					Session::flash('message','Company Information Saved');
					return Redirect::to('/system/company');

				}
				else
				{
					$company = new Company;

					$company -> company_name = Input::get("company_name");
					$company -> company_description = Input::get("company_description");

					if(Input::file('company_logo_name'))
					{
						$image = Input::file('company_logo_name');
						$destinationImagePath = public_path('uploads/' . $image->getClientOriginalName());

						$resized_image = Image::make($image)->resize(200,200);
						$company -> company_logo_name = $image->getClientOriginalName();

						$resized_image -> save($destinationImagePath);
					}
					else
					{
						$company -> company_logo_name = null;
					}

					$company -> save();
					Session::flash('message','Company Information Saved');
					return Redirect::to('/system/company');

				}

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
			'company_name' 				=> 'required',
			'company_description' => 'required'
		);
	}

}
