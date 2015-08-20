@extends('dashboard.layout')

@section('content')

  @include('dashboard.partials._details', array
    (
      "data" => $training,

      "properties" => array
        (
          array(
            'name'=>'Training Start Date',
            'property' => 'training_start_date'
          ),
          array(
            'name'=>'Training End Date',
            'property' => 'training_end_date'
          ),
          array(
            'name'=>'Training Total Cost',
            'property' => 'training_total_cost'
          ),
          array(
            'name'=>'Training Cost Components',
            'property' => 'training_cost_components'
          ),
          array(
            'name'=>'Training Type',
            'property' => 'training_type'
          ),
          array(
            'name'=>'Training Facilitator',
            'property' => 'training_facilitator'
          ),
          array(
            'name'=>'Training Topic',
            'property' => 'training_topic'
          ),
          array(
            'name'=>'Training Location',
            'property' => 'training_location'
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
      &nbsp; &nbsp; <b><a class = "red-note" href = "/hrm/training/trained_employee/{{ $training->employee_id }}" >Employee Details</a></b>
    </p>

@endsection
