@extends('dashboard.layout')

@section('content')


  @include('dashboard.partials._details', array
    (
      "data" => $accident,

      "properties" => array
        (
          array(
            'name'=>'Date of Accident',
            'property' => 'accident_date'
          ),
          array(
            'name'=>'Time of Accident',
            'property' => 'accident_time'
          ),
          array(
            'name'=>'Date of Report of Accident',
            'property' => 'accident_report_date'
          ),
          array(
            'name'=>'Time of Report of Accident',
            'property' => 'accident_report_time'
          ),
          array(
            'name'=>'Description of Accident',
            'property' => 'accident_description'
          ),
          array(
            'name'=>'Location of Accident',
            'property' => 'accident_location'
          ),
          array(
            'name'=>'Name of First Witness',
            'property' => 'witness_1_name'
          ),
          array(
            'name'=>'Name of Second Witness',
            'property' => 'witness_2_name'
          ),
          array(
            'name'=>'Injury Type',
            'property' => 'injury_type'
          ),
          array(
            'name'=>'Supervisor',
            'property' => 'supervisor'
          ),
          array(
            'name'=>'Management Decision',
            'property' => 'management_decision'
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
