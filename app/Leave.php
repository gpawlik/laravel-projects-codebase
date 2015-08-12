<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model {

	protected $table = 'leaves';

	protected $fillable = ['leave_start_date','leave_end_date','reason_for_leave','employee_id'];

	public static function getPermissions()
	{
		return array(
      "hrm_leave_can_add",
			"hrm_leave_can_edit",
      "hrm_leave_can_view",
      "hrm_leave_can_delete",
      "hrm_leave_can_search"
		);
	}

}
