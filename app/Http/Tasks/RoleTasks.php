<?php namespace App\Http\Tasks;

use Illuminate\Http\Request;

class RoleTasks{

	public static function insertIntoModel($model,Request $request)
	{	
		
		$model -> role_name = $request -> input("role_name");

		return $model;
	}

}