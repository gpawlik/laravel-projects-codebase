@extends('dashboard.layout')

@section('content')

  @include('dashboard.partials._view_all', array
    (
      'cols' => array('Applicant First Name','Applicant Last Name','Application Date', 'Application Status'),

      'data' => $applications,

      'route' => 'hrm/applications',

      'permission_prefix' => 'hrm_application',

      'actions' => ['view','edit','delete']

    )
  )

@endsection
