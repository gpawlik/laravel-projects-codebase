<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model{

	protected $table = 'company';

	protected $fillable = ['company_name','company_description','company_logo_name'];

	public static function getPermissions()
	{
		return array(
			"system_company_can_edit"
		);
	}

}
