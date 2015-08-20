<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model{

	protected $table = 'hrm_config';

	protected $fillable = ['ssnit_percentage','employer_welfare_contribution','employee_leave_entitlement'];

	public static function getPermissions()
	{
		return array(
			"hrm_configuration_can_edit"
		);
	}

}
