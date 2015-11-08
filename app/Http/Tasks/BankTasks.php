<?php namespace App\Http\Tasks;

use Illuminate\Http\Request;

class BankTasks{

	public static function insertIntoModel($model,Request $request)
	{	
		$model -> bank_name = $request -> input("bank_name");
		$model -> bank_swift_code = $request -> input("bank_swift_code");
		return $model;
	}

}