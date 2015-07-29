@extends('dashboard.layout')

@section('content')

  @include('dashboard.partials._view_all', array
    (
      'cols' => array('Permission Name'),

      'data' => $permissions,

      'route' => 'system/permissions',

      'foreign' => array
        (
          array(
          'name'=>'Role',
          'model'=> 'App\Role',
          'key'=> 'role_id',
          'property' => 'role_name'
          )
        ),

        'actions' => ['edit','delete']

    )
  )

@endsection
