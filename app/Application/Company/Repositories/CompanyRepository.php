<?php namespace App\Application\Company\Repositories;

use App\Company;

class CompanyRepository
{
	/**
	* This class is the repository for all Company queries
	*/

	public static function count()
	{
		return Company::all()->count();
	}

	public static function getCompanyDetails()
	{
		return Company::all()->first();
	}

}