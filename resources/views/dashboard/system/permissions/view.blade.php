@extends('dashboard.layout')

@section('content')


  @include('dashboard.partials._details', array
    (
      "data" => $permission,

      "properties" => array
        (
          array(
            'name' => 'Permission Name',
            'property' => 'permission_name'
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
