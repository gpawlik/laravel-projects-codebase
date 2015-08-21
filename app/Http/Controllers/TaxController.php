<?php namespace App\Http\Controllers;

use App\Tax;
use App\User;
use App\Permission;
use Validator;
use Image;
use Hash;
use Session;
use Input;
use Redirect;
use Response;
use Auth;


class TaxController extends Controller {

	public function index()
	{
		if(self::checkUserPermissions("hrm_tax_can_add"))
		{
      $data['title'] = "Tax Model";
			$data['activeLink'] = "tax_model";

      $taxModelDataCount = Tax::all()->count();

      if($taxModelDataCount > 0)
      {
          $data['taxModel'] = Tax::all();
      }

			return view('dashboard.hrm.tax.index',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
  }

  public function saveTaxModel()
  {
    if(self::checkUserPermissions("hrm_tax_can_add"))
		{
      $dataDivision = 3;

      $taxModelData = Input::all();

      //remove token
      array_shift($taxModelData);


      $chunkedTaxModelData = array_chunk($taxModelData, $dataDivision);

      //delete old model
      Tax::truncate();

      foreach($chunkedTaxModelData as $key => $modelData)
      {
        if($modelData[0] == "" || $modelData[1] == "" || $modelData[2] == "")
        {
          return Redirect::to('/hrm/tax_model')
  	        		->withErrors("No model data entered")
  	        		->withInput();
        }

        if(!is_numeric($modelData[1]) || !is_numeric($modelData[2]))
        {
          return Redirect::to('/hrm/tax_model')
  	        		->withErrors("amount and rate data must be numeric")
  	        		->withInput();
        }

        $taxModel = new Tax;

        //key values will change if number of columns in tax model table changes
        $taxModel -> step = $modelData[0];
        $taxModel -> amount_limit = $modelData[1];
        $taxModel -> rate = $modelData[2];

        $taxModel -> save();

      }

			EmployeeController::calculateEmployeesNetSalary();

      Session::flash('message', 'Tax Model Saved');
      return Redirect::to("/hrm/tax_model");

		}
		else
		{
			return "You are not authorized";die();
		}
  }

}
