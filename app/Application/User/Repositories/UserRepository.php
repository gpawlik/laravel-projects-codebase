<?php namespace App\Application\User\Repositories;

use Illuminate\Http\Request;
use App\User;

class UserRepository
{
	/**
	* This class is the repository for all user queries
	*/

	public static function getAllUsers()
	{
		return User::all();
	}

	public static function getAllUsersPaginated($pages)
	{
		return User::orderBy("updated_at","DESC")->paginate($pages);
	}

	public static function getUser($id)
	{
		return User::find($id);
	}

	public static function getAffiliatedToCount($fieldName,$id)
	{
		return User::where($fieldName,$id)->count();
	}

}