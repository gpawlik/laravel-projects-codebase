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
			"dashboard_leave_can_view",
			"dashboard_vacancy_can_view",
			"dashboard_salaries_can_view",
			"dashboard_ssnit_can_view",
			"dashboard_tax_can_view"
		);
	}

}
