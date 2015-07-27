@extends('dashboard.layout')

@section('content')

  @include('dashboard.partials._view_all', array
    (
      'cols' => array('Role Name'),

      'data' => $roles,

      'route' => 'system/roles',

      'actions' => ['view','edit','delete']

    )
  )

@endsection
