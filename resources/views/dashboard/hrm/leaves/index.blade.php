@extends('dashboard.layout')

@section('content')

  @include('dashboard.partials._view_all', array
    (
      'cols' => array('Leave From Date','Leave To Date'),

      'data' => $leaves,

      'route' => 'hrm/leaves',

      'permission_prefix' => 'hrm_leave',

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

      'actions' => ['edit','delete']

    )
  )

@endsection
