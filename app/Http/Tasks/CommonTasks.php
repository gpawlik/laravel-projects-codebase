<?php namespace App\Http\Tasks; 

use App\Role;
use Image;

class CommonTasks
{
	public static function getSelectArray($tableName,$orderByColumn,$orderByMode)
	{
		$data = \DB::table($tableName)->orderBy($orderByColumn,$orderByMode)->get();

		$dataArray = array();

		foreach($data as $d)
		{
			$dataArray[$d -> id] = $d -> {$orderByColumn};
		}

		return $dataArray;
	}

	public static function prepareImage($image,$width,$height)
	{
		$storageImageName = time()."_".str_replace(" ","_",$image->getClientOriginalName());
		$destinationImagePath = public_path('uploads/' . $storageImageName);
		$resizedImage = Image::make($image)->resize($width,$height);
		$resizedImage -> save($destinationImagePath);

		return $storageImageName;
	}

	public static function deleteImage($imageName)
	{
		if (file_exists(public_path('uploads/'.$imageName)))
		{
			unlink(public_path('uploads/'.$imageName));
		}
	}

	public static function throwUnauthorized()
	{
		abort(403,'Unauthorized');
	}
}