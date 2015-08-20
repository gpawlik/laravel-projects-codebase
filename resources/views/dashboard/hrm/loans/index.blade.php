@extends('dashboard.layout')

@section('content')

  @include('dashboard.partials._view_all', array
    (
      'cols' => array('Loan Type','Amount','Payment Status'),

      'data' => $loans,

      'route' => 'hrm/loans',

      'permission_prefix' => 'hrm_loan',

      'foreign' => array
        (
          array(
          'name'=>'Employee First Name',
          'model'=> 'App\Employee',
          'key'=> 'employee_id',
          'property' => 'first_name'
          ),
          array(
          'name'=>'Employee Last Name',
          'model'=> 'App\Employee',
          'key'=> 'employee_id',
          'property' => 'last_name'
          )
        ),

      'actions' => ['view','edit','delete'],

      'extraActions' => array(
        array(
          "route" => "hrm/loans/payment_finished",
          "title" => "Paid",
          "icon" => "<i class='fa fa-check-circle'></i>",
          "permission" => "hrm_loan_can_complete"
        ),
        array(
          "route" => "hrm/loans/revert_payment",
          "title" => "Revert",
          "icon" => "<i class='fa fa-undo'></i>",
          "permission" => "hrm_loan_can_revert"
        )
      )

    )
  )

@endsection
