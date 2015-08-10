@extends('dashboard.layout')

@section('content')

  @include('dashboard.partials._view_all', array
    (
      'cols' => array('Applicant First Name','Applicant Last Name','Application Date', 'Application Status'),

      'data' => $applications,

      'route' => 'hrm/applications',

      'permission_prefix' => 'hrm_application',

      'actions' => ['view','edit','delete'],

      'extraActions' => array(
        array(
          "route" => "hrm/applications/accept_application",
          "title" => "Accept Application",
          "icon" => "<i class='fa fa-check-circle'></i>",
          "permission" => "hrm_application_can_accept"
        ),
        array(
          "route" => "hrm/applications/decline_application",
          "title" => "Decline Application",
          "icon" => "<i class='fa fa-undo'></i>",
          "permission" => "hrm_application_can_decline"
        )
      )

    )
  )

@endsection
