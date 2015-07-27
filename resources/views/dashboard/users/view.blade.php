@extends('dashboard.layout')

@section('content')


  @include('dashboard.partials._details', array
    (
      "data" => $user,

      "properties" => array
        (
          array(
            'name'=>'First Name',
            'property' => 'first_name'
          ),
          array(
            'name'=>'Last Name',
            'property' => 'last_name'
          ),
          array(
            'name'=>'Email',
            'property' => 'email'
          ),
          array(
            'name'=>'Username',
            'property' => 'username'
          )
        ),

      'foreign' => array
        (
          array(
          'name'=>'Role',
          'model'=> 'App\Role',
          'key'=> 'role_id',
          'property' => 'role_name'
          )
        )
    )
  )

@endsection
