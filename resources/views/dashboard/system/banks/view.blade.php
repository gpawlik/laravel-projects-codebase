@extends('dashboard.layout')

@section('content')


  @include('dashboard.partials._details', array
    (
      "data" => $bank,

      "properties" => array
        (
          array(
            'name'=>'Bank Name',
            'property' => 'bank_name'
          ),
          array(
            'name'=>'Bank Swift Code',
            'property' => 'bank_swift_code'
          )
        )
    )
  )

@endsection
