@extends('dashboard.layout')

@section('content')

  @include('dashboard.partials._view_all', array
    (
      'cols' => array('Department Name'),

      'data' => $departments,

      'route' => 'hrm/departments',

      'permission_prefix' => 'hrm_department',

      'actions' => ['edit','delete']

    )
  )

@endsection
