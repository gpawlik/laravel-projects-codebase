<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $table = 'staff_loans';

    protected $fillable = ['loan_type','payment_frequency','amount','start_date','end_date','employee_id'];

    public static function getPermissions()
    {
      return array(
        "hrm_loan_can_add",
        "hrm_loan_can_edit",
        "hrm_loan_can_view",
        "hrm_loan_can_delete",
        "hrm_loan_can_search",
        "hrm_loan_can_complete",
        "hrm_loan_can_revert"
      );
    }
}
