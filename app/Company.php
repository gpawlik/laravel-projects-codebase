<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model{

	protected $table = 'company';

	public static function getPermissions()
	{
		return array(
			"system_company_can_edit"
		);
	}

}
