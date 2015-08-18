@extends('dashboard.layout')

@section('content')

  @include('dashboard.partials._view_all', array
    (
      'cols' => array('Job Title',"Job Capacity"),

      'data' => $jobs,

      'route' => 'hrm/jobs',

      'permission_prefix' => 'hrm_job',

      'foreign' => array
        (
          array(
          'name'=>'Department',
          'model'=> 'App\Department',
          'key'=> 'department_id',
          'property' => 'department_name'
          )
        ),

      'actions' => ['view','edit','delete']

    )
  )

@endsection
