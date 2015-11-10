<?php namespace App\Http\Tasks;

use Illuminate\Http\Request;

use Image;
use Hash;

use App\Role;

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

	public static function executeUpdate($model,Request $request)
	{
		//DEAL WITH IMAGE FILE
  		if($request -> file(('image_name')))
  		{
      		if($model->image_name != null)
      		{
            	if (file_exists(public_path('uploads/'.$model -> image_name)))
        		{
              		unlink(public_path('uploads/'.$model -> image_name));
        		}
      		}

      		$image = $request -> file('image_name');

      		$storageImageName = time()."_".str_replace(" ","_",$image->getClientOriginalName());

     		$destinationImagePath = public_path('uploads/' . $storageImageName);

			$resizedImage = Image::make($image)->resize(200,200);

			$model -> image_name = $storageImageName;

			$resizedImage -> save($destinationImagePath);
  		}
  		else
  		{
			if($request -> input("clear_check") == 'yes')
    		{
				if(file_exists(public_path('uploads/'.$model -> image_name)))
				{
					unlink(public_path('uploads/'.$model -> image_name));
				}

				$model->image_name = null;
    		}
		}

		$model -> first_name = $request -> input("first_name");
		$model -> last_name = $request -> input("last_name");
		$model -> email = $request -> input("email");
		$model -> username = $request -> input("username");
		$model -> role_id = $request -> input("role_id");

		return $model;
	}

	public static function setUpRolesArray()
	{
		//Obtain list of roles
		$roles = Role::orderBy("role_name","ASC")->get();
		$rolesArray = array();

		foreach ($roles as $role) 
		{
			$rolesArray[$role->id] = $role->role_name;
  		}

  		return $rolesArray;
	}

}