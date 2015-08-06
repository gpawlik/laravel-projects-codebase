@extends('dashboard.layout')

@section('content')

  @include('dashboard.partials._view_all', array
    (
      'cols' => array('Staff Number','First Name','Last Name', 'Other Names','Telephone Number'),

      'data' => $employees,

      'route' => 'hrm/employees',

      'permission_prefix' => 'hrm_employee',

      'actions' => ['view','edit','delete']

    )
  )

@endsection
