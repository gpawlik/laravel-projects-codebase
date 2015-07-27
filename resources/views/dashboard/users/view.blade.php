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
