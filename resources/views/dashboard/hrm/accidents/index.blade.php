@extends('dashboard.layout')

@section('content')

  @include('dashboard.partials._view_all', array
    (
      'cols' => array('Accident Date','Accident Time','Accident Report Date', 'Accident Report Time'),

      'data' => $accidents,

      'route' => 'hrm/accidents',

      'permission_prefix' => 'hrm_accident',

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
