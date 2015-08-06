<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model {

	protected $table = 'departments';

	protected $fillable = ['department_name'];

	public static function getPermissions()
	{
		return array(
      "hrm_department_can_add",
			"hrm_department_can_edit",
      "hrm_department_can_view",
      "hrm_department_can_delete",
      "hrm_department_can_search"
		);
	}

}
