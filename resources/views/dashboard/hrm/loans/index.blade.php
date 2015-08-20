@extends('dashboard.layout')

@section('content')

  @include('dashboard.partials._view_all', array
    (
      'cols' => array('Loan Type','Amount','Payment Frequency'),

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

      'actions' => ['view','edit','delete']

    )
  )

@endsection
