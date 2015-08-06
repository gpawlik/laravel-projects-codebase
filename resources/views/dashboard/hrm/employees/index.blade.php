@extends('dashboard.layout')

@section('content')

  @include('dashboard.partials._view_all', array
    (
      'cols' => array('Bank Name','Bank Swift Code'),

      'data' => $banks,

      'route' => 'hrm/employees',

      'permission_prefix' => 'hrm_employee',

      'actions' => ['view','edit','delete']

    )
  )

@endsection
