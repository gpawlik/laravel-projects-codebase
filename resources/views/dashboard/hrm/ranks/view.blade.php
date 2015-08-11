@extends('dashboard.layout')

@section('content')

  @include('dashboard.partials._details', array
    (
      "data" => $rank,

      "properties" => array
        (
          array(
            'name'=>'Rank Code',
            'property' => 'rank_code'
          ),
          array(
            'name'=>'Rank Name',
            'property' => 'rank_name'
          ),
          array(
            'name'=>'Allowed No. of Leave Days',
            'property' => 'allowed_number_of_leave_days'
          )
        )
        )
    )

@endsection
