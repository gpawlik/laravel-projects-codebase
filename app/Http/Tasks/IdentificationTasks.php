<?php namespace App\Http\Tasks;

use Illuminate\Http\Request;

class IdentificationTasks{
	
	public static function insertIntoModel($model,Request $request)
	{
		$model -> identification_name = $request -> input("identification_name");

		return $model;
	}

}