@extends('dashboard.layout')

@section('content')

  @include('dashboard.partials._view_all', array
    (
      'cols' => array('Identification Name'),

      'data' => $banks,

      'route' => 'system/identification',

      'permission_prefix' => 'system_user',

      'actions' => ['view','edit','delete']

    )
  )

@endsection
