@extends('dashboard.layout')

@section('content')


  @include('dashboard.partials._details', array
    (
      "data" => $disciplinary,

      "properties" => array
        (
          array(
            'name'=>'Type of Warning',
            'property' => 'type_of_warning'
          ),
          array(
            'name'=>'Disciplinary action Taken',
            'property' => 'action_taken'
          ),
          array(
            'name'=>'Offense',
            'property' => 'offense'
          ),
          array(
            'name'=>'Number of Days on Suspension',
            'property' => 'suspension_number_of_days'
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
