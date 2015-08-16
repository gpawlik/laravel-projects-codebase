@extends('dashboard.layout')

@section('content')

  @include('dashboard.partials._view_all', array
    (
      'cols' => array('Training Start Date','Training End Date','Training Type'),

      'data' => $training,

      'route' => 'hrm/training',

      'permission_prefix' => 'hrm_training',

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
