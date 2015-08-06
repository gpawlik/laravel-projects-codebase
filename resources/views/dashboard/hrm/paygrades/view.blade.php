@extends('dashboard.layout')

@section('content')


  @include('dashboard.partials._details', array
    (
      "data" => $payGrade,

      "properties" => array
        (
          array(
            'name'=>'Description',
            'property' => 'description'
          ),
          array(
            'name'=>'Minimum Salary',
            'property' => 'minimum_salary'
          ),
          array(
            'name'=>'Maximum Salary',
            'property' => 'maximum_salary'
          )
        ),

      'foreign' => array
        (
          array(
          'name'=>'Job',
          'model'=> 'App\Job',
          'key'=> 'job_id',
          'property' => 'job_title'
          )
        )
    )
  )

@endsection
