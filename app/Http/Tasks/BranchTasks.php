<?php namespace App\Http\Tasks;

use Illuminate\Http\Request;

class BranchTasks{

	public static function insertIntoModel($model,Request $request)
	{	
		
		$model -> branch_name = $request -> input("branch_name");
		$model -> branch_location = ($request -> input("branch_location") == "" ? null : $request -> input("branch_location"));

		return $model;
	}

}