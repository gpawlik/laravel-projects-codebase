@extends('dashboard.layout')

@section('content')

  @include('dashboard.partials._view_all', array
    (
      'cols' => array('Date of Termination'),

      'data' => $terminations,

      'route' => 'hrm/job_terminations',

      'permission_prefix' => 'hrm_termination',

      'actions' => ['view','edit','delete'],

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
        )

    )
  )

@endsection