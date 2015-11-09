<?php namespace App\Http\Tasks;

use Illuminate\Http\Request;
use Image;
use Hash;

class UserTasks{

	public static function insertIntoModel($model,Request $request)
	{	
		if($request -> file(('image_name')))
  		{

	      $image = $request -> file('image_name');

	      $storageImageName = time()."_".str_replace(" ","_",$image->getClientOriginalName());

	      $destinationImagePath = public_path('uploads/' . $storageImageName);

	      $resizedImage = Image::make($image)->resize(200,200);

	      $model -> image_name = $storageImageName;

	      $resizedImage -> save($destinationImagePath);
  		}
		else
  		{
    		$model -> image_name = null;
  		}

		$model -> first_name = $request -> input("first_name");
		$model -> last_name = $request -> input("last_name");
		$model -> email = $request -> input("email");
		$model -> username = $request -> input("username");
		$model -> role_id = $request -> input("role_id");
		$model -> status = 2;
		$model -> password = Hash::make("password");

		return $model;
	}

}