@extends('dashboard.layout')

@section('content')


  @include('dashboard.partials._details', array
    (
      "data" => $branch,

      "properties" => array
        (
          array(
            'name'=>'Branch Name',
            'property' => 'branch_name'
          ),
          array(
            'name'=>'Branch Location',
            'property' => 'branch_location'
          )
        )
    )
  )

@endsection
