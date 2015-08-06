@extends('dashboard.layout')

@section('content')

  @include('dashboard.partials._view_all', array
    (
      'cols' => array('Description','Minimum Salary','Maximum Salary'),

      'data' => $paygrades,

      'route' => 'hrm/pay_grades',

      'permission_prefix' => 'hrm_paygrade',

      'foreign' => array
        (
          array(
          'name'=>'Job',
          'model'=> 'App\Job',
          'key'=> 'job_id',
          'property' => 'job_title'
          )
        ),

      'actions' => ['view','edit','delete']

    )
  )

@endsection
