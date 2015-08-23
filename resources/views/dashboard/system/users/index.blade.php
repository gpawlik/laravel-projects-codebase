@extends('dashboard.layout')

@section('content')

  @include('dashboard.partials._view_all', array
    (
      'cols' => array('First Name','Last Name'),

      'data' => $users,

      'route' => 'system/users',

      'permission_prefix' => 'system_user',

      'foreign' => array
        (
          array(
          'name'=>'Role',
          'model'=> 'App\Role',
          'key'=> 'role_id',
          'property' => 'role_name'
          )
        ),

        'actions' => ['view','edit','delete'],

        'extraActions' => array(
          array(
            "route" => "system/users/reset_password",
            "title" => "Reset-Password",
            "icon" => "<i class='fa fa-refresh'></i>",
            "permission" => "system_user_can_reset-password"
          )
        )

    )
  )

@endsection
