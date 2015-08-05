@extends('dashboard.layout')

@section('content')

  @include('dashboard.partials._details', array
    (
      "data" => $role,

      "properties" => array
        (
          array(
            'name'=>'Role Name',
            'property' => 'role_name'
          )
        )
        )
    )

@endsection
