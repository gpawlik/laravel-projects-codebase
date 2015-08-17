@extends('dashboard.layout')

@section('content')


  @include('dashboard.partials._details', array
    (
      "data" => $department,

      "properties" => array
        (
          array(
            'name'=>'Department Name',
            'property' => 'department_name'
        )
      )
    )
  )

@endsection