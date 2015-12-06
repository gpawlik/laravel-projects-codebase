<?php namespace App\Http\Tasks; 

use Illuminate\Http\Request;

use App\Role;
use App\Company;
use Validator;
use Image;
use Hash;
use Session;
use Input;
use Redirect;
use Response;
use Auth;

class CompanyTasks
{
	public static function populateIndexData()
	{
		$data['title'] = "Company Details";
		$data['activeLink'] = "company";
		$data['subTitle'] = "Company Details";

		$companyDetailsContent = Company::all()->count();

		if($companyDetailsContent > 0)
		{
			$data['companyDetails'] =  Company::all()->first();
		}

		return $data;
	}

	public static function saveCompanyDetails(Request $request)
	{
		$rules = self::getRules();

		$validator = Validator::make($request -> all(), $rules);

		if ($validator->fails())
		{
			return Redirect::to('/system/company')
				->withErrors($validator)
				->withInput()
				->send();
		}
		else
		{
			$companyDetailsContent = Company::all()->count();

			if($companyDetailsContent > 0)
			{
				$companyDetails = Company::all()->first();

				if($request -> file('company_logo_name'))
				{
					if($companyDetails -> company_logo_name != null)
					{
						if(file_exists(public_path('uploads/' .$companyDetails -> company_logo_name)))
						{
							unlink(public_path("uploads/").$companyDetails -> company_logo_name);
						}
					}

					$image = $request -> file('company_logo_name');

					$storageImageName = time()."_".str_replace(" ","_",$image->getClientOriginalName());

					$destinationImagePath = public_path('uploads/' . $storageImageName);

					$resized_image = Image::make($image)->resize(200,200);

					$resized_image -> save($destinationImagePath);

					$companyDetails -> company_logo_name = $storageImageName;
				}
				else
				{
					if($request -> get('clear_check') == 'checked')
					{
						if(file_exists(public_path('uploads/' .$companyDetails -> company_logo_name)))
						{
							unlink(public_path("uploads/").$companyDetails -> company_logo_name);
						}

						$companyDetails -> company_logo_name = null;
					}

				}

				$companyDetails -> company_name = $request -> get("company_name");
				$companyDetails -> company_description = $request -> get("company_description");
				$companyDetails -> company_address = ($request->input("company_address") == "" ? null : $request->input("company_address"));
				$companyDetails -> company_telephone = ($request->input("company_telephone") == "" ? null : $request->input("company_telephone"));
				$companyDetails -> company_tin_number = ($request->input("company_tin_number") == "" ? null : $request->input("company_tin_number"));
				$companyDetails -> company_ssnit_number = ($request->input("company_ssnit_number") == "" ? null : $request->input("company_ssnit_number"));
				$companyDetails -> company_email = ($request->input("company_email") == "" ? null : $request->input("company_email"));
				$companyDetails -> company_website = ($request->input("company_website") == "" ? null : $request->input("company_website"));


				$companyDetails -> push();
				Session::flash('message','Company Information Saved');
				return Redirect::to('/system/company')->send();

			}
			else
			{
				$company = new Company;

				$company -> company_name = $request -> get("company_name");
				$company -> company_description = $request -> get("company_description");
				$company -> company_address = ($request->input("company_address") == "" ? null : $request->input("company_address"));
				$company -> company_telephone = ($request->input("company_telephone") == "" ? null : $request->input("company_telephone"));
				$company -> company_tin_number = ($request->input("company_tin_number") == "" ? null : $request->input("company_tin_number"));
				$company -> company_ssnit_number = ($request->input("company_ssnit_number") == "" ? null : $request->input("company_ssnit_number"));
				$company -> company_email = ($request->input("company_email") == "" ? null : $request->input("company_email"));
				$company -> company_website = ($request->input("company_website") == "" ? null : $request->input("company_website"));

				if($request -> file('company_logo_name'))
				{
					$image = $request -> file('company_logo_name');

					$storageImageName = time()."_".str_replace(" ","_",$image->getClientOriginalName());

					$destinationImagePath = public_path('uploads/' . $storageImageName);

					$resized_image = Image::make($image)->resize(200,200);

					$company -> company_logo_name = $storageImageName;
					
					$resized_image -> save($destinationImagePath);
				}
				else
				{
					$company -> company_logo_name = null;
				}

				$company -> save();
				Session::flash('message','Company Information Saved');
				return Redirect::to('/system/company')->send();

			}

		}
	}

	public static function getRules()
	{
		return array(
			'company_name' 				=> 'required',
			'company_description' 		=> 'required',
			'company_address'	 		=> 'required',
			'company_telephone'	 		=> 'required'
		);
	}
}