@extends('dashboard.layout')

@section('content')


  @include('dashboard.partials._details', array
    (
      "data" => $identification,

      "properties" => array
        (
          array(
            'name'=>'Identification Name',
            'property' => 'identification_name'
          )
        )
    )
  )

@endsection
