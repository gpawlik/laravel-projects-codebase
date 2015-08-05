<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model{

	protected $table = 'employees';

	protected $fillable = ['employee_name'];

	public static function getPermissions()
	{
		return array(
      "employees_employee_can_add",
			"employees_employee_can_edit",
      "employees_employee_can_view",
      "employees_employee_can_delete",
      "employees_employee_can_search"
		);
	}

}
