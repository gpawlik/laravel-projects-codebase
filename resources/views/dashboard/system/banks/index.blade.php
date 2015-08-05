@extends('dashboard.layout')

@section('content')

  @include('dashboard.partials._view_all', array
    (
      'cols' => array('Bank Name','Bank Swift Code'),

      'data' => $banks,

      'route' => 'system/banks',

      'permission_prefix' => 'system_bank',

      'actions' => ['view','edit','delete']

    )
  )

@endsection
