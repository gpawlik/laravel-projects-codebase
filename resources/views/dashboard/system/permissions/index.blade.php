@extends('dashboard.layout')

@section('content')

  @include('dashboard.partials._view_all', array
    (
      'cols' => array('Permission Name'),

      'data' => $permissions,

      'route' => 'system/permissions',

      'permission_prefix' => 'system_permission',

      'foreign' => array
        (
          array(
          'name'=>'Role',
          'model'=> 'App\Role',
          'key'=> 'role_id',
          'property' => 'role_name'
          )
        ),

        'actions' => ['view','edit','delete']

    )
  )

@endsection
