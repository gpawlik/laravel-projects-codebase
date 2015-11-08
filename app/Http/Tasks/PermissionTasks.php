<?php namespace App\Http\Tasks;

use Illuminate\Http\Request;

class PermissionTasks{
	
	public static function insertIntoModel($model,Request $request)
	{
		$model -> permission_name = $request -> input("permission_name");
	    $model -> role_id = $request -> input("role_id");

		return $model;
	}

}