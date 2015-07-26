@extends('dashboard.layout')

@section('content')

  @include('dashboard.partials._view_all', array
    (
      'cols' => array('First Name','Last Name'),

      'data' => $users,

      'route' => 'dashboard/users',

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
