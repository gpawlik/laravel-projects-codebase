@extends('dashboard.layout')

@section('content')

  @include('dashboard.partials._view_all', array
    (
      'cols' => array('Type of Warning','Action Taken'),

      'data' => $disciplinaries,

      'route' => 'hrm/disciplinaries',

      'permission_prefix' => 'hrm_disciplinary',

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
