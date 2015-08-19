<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Accident extends Model{

	protected $table = 'accidents';

	//protected $fillable = ['applicant_first_name','applicant_last_name'];

	public static function getPermissions()
	{
		return array(
			"hrm_accident_can_add",
      "hrm_accident_can_edit",
      "hrm_accident_can_delete",
      "hrm_accident_can_view",
      "hrm_accident_can_search",
		);
	}

}
