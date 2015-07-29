@extends('dashboard.layout')

@section('content')

  @include('dashboard.partials._view_all', array
    (
      'cols' => array('Role Name'),

      'data' => $roles,

      'route' => 'system/roles',

      'actions' => ['view','edit','delete'],

      'extraActions' => array(
        array(
          "route" => "system/roles/permissions",
          "title" => "Permissions",
          "icon" => "<i class='fa fa-key'></i>"
        )
      )

    )
  )

@endsection
