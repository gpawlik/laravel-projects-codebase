<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayGrade extends Model
{
    protected $table = 'pay_grades';

    protected $fillable = ['description','minimum_salary','maximum_salary','job_id'];

    public static function getPermissions()
    {
      return array(
        "hrm_paygrade_can_add",
        "hrm_paygrade_can_edit",
        "hrm_paygrade_can_view",
        "hrm_paygrade_can_delete",
        "hrm_paygrade_can_search"
      );
    }
}
