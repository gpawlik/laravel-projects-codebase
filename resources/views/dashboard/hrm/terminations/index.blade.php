@extends('dashboard.layout')

@section('content')

  @include('dashboard.partials._view_all', array
    (
      'cols' => array('Date of Termination'),

      'data' => $terminations,

      'route' => 'hrm/job_terminations',

      'permission_prefix' => 'hrm_termination',

      'actions' => ['view'],

      'extraActions' => array(
        array(
          "route" => "hrm/job_terminations/revert_termination",
          "title" => "Revert Job Termination",
          "icon" => "<i class='fa fa-undo'></i>",
          "permission" => "hrm_termination_can_revert"
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
