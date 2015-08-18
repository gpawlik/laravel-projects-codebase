@extends('dashboard.layout')

@section('content')


  @include('dashboard.partials._details', array
    (
      "data" => $job,

      "properties" => array
        (
          array(
            'name'=>'Job Title',
            'property' => 'job_title'
          ),
          array(
            'name'=>'Job Capacity',
            'property' => 'job_capacity'
          )
        ),

      'foreign' => array
        (
          array(
          'name'=>'Department',
          'model'=> 'App\Department',
          'key'=> 'department_id',
          'property' => 'department_name'
          )
        )
    )
  )

@endsection
