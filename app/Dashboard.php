<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model {

	public static function getPermissions()
	{
		return array(
      "dashboard_employee_can_view",
      "dashboard_job_can_view",
      "dashboard_department_can_view",
			"dashboard_application_can_view",
		);
	}

}
