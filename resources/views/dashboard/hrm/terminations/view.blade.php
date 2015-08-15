@extends('dashboard.layout')

@section('content')

  @include('dashboard.partials._details', array
    (
      "data" => $termination,

      "properties" => array
        (
          array(
            'name'=>'Date of Termination',
            'property' => 'date_of_termination'
          ),
          array(
            'name'=>'Reason for Termination',
            'property' => 'reason_for_termination'
          ),
          array(
            'name'=>'Details of Termination',
            'property' => 'details_of_termination'
          ),
          array(
            'name'=>'Resignation List',
            'property' => 'resignation_list'
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

    <p>
      &nbsp; &nbsp; <b><a class = "red-note" href = "/hrm/job_terminations/terminated_employee/{{ $termination->employee_id }}" >More</a></b>
    </p>

@endsection
