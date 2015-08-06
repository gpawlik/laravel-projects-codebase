<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model{

	protected $table = 'employees';

	protected $fillable = ['employee_name'];

	public static function getPermissions()
	{
		return array(
      "hrm_employee_can_add",
			"hrm_employee_can_edit",
      "hrm_employee_can_view",
      "hrm_employee_can_delete",
      "hrm_employee_can_search"
		);
	}

}
