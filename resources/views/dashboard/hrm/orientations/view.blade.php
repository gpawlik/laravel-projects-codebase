@extends('dashboard.layout')

@section('content')


  @include('dashboard.partials._details', array
    (
      "data" => $orientation,

      "properties" => array
        (
          array(
            'name'=>'Orientation Start Date',
            'property' => 'orientation_start_date'
          ),
          array(
            'name'=>'Orientation End Date',
            'property' => 'orientation_end_date'
          ),
          array(
            'name'=>'Outcome of Orientation',
            'property' => 'orientation_outcome'
          )
        ),

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
