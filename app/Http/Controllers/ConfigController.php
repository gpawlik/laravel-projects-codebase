<?php namespace App\Http\Controllers;

use App\Role;
use App\Permission;
use App\Configuration;
use Validator;
use Image;
use Hash;
use Session;
use Input;
use Redirect;
use Response;
use Auth;


class ConfigController extends Controller {

	public function index()
	{
		if(self::checkUserPermissions("hrm_configuration_can_edit"))
		{
      $data['title'] = "HRM Configurations";
			$data['activeLink'] = "config";

			$configDetails = Configuration::all()->count();

			if($configDetails > 0)
			{
				$data['configDetails'] =  Configuration::all()->first();
			}

			return view('dashboard.hrm.config.index',$data);
    }

    else
    {
        return "You are not authorized";die();
    }
  }

  public function save()
  {
    if(self::checkUserPermissions("hrm_configuration_can_edit"))
		{
      $rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/hrm/configurations')
							->withErrors($validator)
							->withInput();
			}
			else
			{
        $configDetailsCount = Configuration::all()->count();

				if($configDetailsCount > 0)
				{
          $configDetails = Configuration::all()->first();

          $configDetails -> ssnit_percentage = Input::get("ssnit_percentage");
          $configDetails -> employer_welfare_contribution = Input::get("employer_welfare_contribution");
          $configDetails -> employee_leave_entitlement = Input::get("employee_leave_entitlement");

          $configDetails -> push();

					EmployeeController::calculateEmployeesNetSalary();

					Session::flash('message','Configuration Details Saved');
					return Redirect::to('/hrm/configurations');
        }
        else
        {
          $configuration = new Configuration;

          $configuration -> ssnit_percentage = Input::get("ssnit_percentage");
          $configuration -> employer_welfare_contribution = Input::get("employer_welfare_contribution");
          $configuration -> employee_leave_entitlement = Input::get("employee_leave_entitlement");

          $configuration -> save();

					EmployeeController::calculateEmployeesNetSalary();

					Session::flash('message','Configuration Details Saved');
					return Redirect::to('/hrm/configurations');

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
      'ssnit_percentage' 				=> 'required',
      'employer_welfare_contribution' => 'required',
      'employee_leave_entitlement' => 'required'
    );
  }

}
