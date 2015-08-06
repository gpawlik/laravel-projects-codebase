<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model{

	protected $table = 'employees';

	protected $fillable = ['staff_number','first_name','last_name','other_names','date_of_birth','marital_status','spouse_name','gender','social_security_number','email','telephone_number','mailing_address',
												'residential_address','emergency_contact_name','emergency_contact_number','next_of_kin','alergies','fathers_name','mothers_name','bank_id','bank_account_number','picture_name',
												'qualifications','date_of_hire','basic_salary','job_id'];

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
