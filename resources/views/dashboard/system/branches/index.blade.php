@extends('dashboard.layout')

@section('content')

  @include('dashboard.partials._view_all', array
    (
      'cols' => array('Branch Name','Branch Location'),

      'data' => $branches,

      'route' => 'system/branches',

      'permission_prefix' => 'system_branch',

      'actions' => ['view','edit','delete']

    )
  )

@endsection
