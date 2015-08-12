@extends('dashboard.layout')

@section('content')


  @include('dashboard.partials._details', array
    (
      "data" => $leave,

      "properties" => array
        (
          array(
            'name'=>'Leave Start Date',
            'property' => 'leave_start_date'
          ),
          array(
            'name'=>'Leave End Date',
            'property' => 'leave_end_date'
          ),
          array(
            'name'=>'Reason For Leave',
            'property' => 'reason_for_leave'
          ),
          array(
            'name'=>'Saturday Inclusive',
            'property' => 'saturday_inclusive'
          ),
          array(
            'name'=>'Sunday Inclusive',
            'property' => 'sunday_inclusive'
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
