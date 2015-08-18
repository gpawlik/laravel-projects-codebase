<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model{

	protected $table = 'applications';

	protected $fillable = ['applicant_first_name','applicant_last_name','applicant_email','applicant_contact_number','applicant_application_status','applicantion_date'.'applicant_interview_date',
		'applicant_cv_file_name','applicant_letter_file_name'];

	public static function getPermissions()
	{
		return array(
			"hrm_application_can_add",
      "hrm_application_can_edit",
      "hrm_application_can_delete",
      "hrm_application_can_view",
      "hrm_application_can_search",
			"hrm_application_can_accept",
			"hrm_application_can_decline"
		);
	}

}
