@extends('dashboard.layout')

@section('content')

  @include('dashboard.partials._view_all', array
    (
      'cols' => array('Bank Name','Bank Swift Code'),

      'data' => $banks,

      'route' => 'employees/employees_data',

      'permission_prefix' => 'employees_employee',

      'actions' => ['view','edit','delete']

    )
  )

@endsection
