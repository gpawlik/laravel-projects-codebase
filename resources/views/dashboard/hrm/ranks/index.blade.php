@extends('dashboard.layout')

@section('content')

  @include('dashboard.partials._view_all', array
    (
      'cols' => array('Rank Code','Rank Name'),

      'data' => $ranks,

      'route' => 'hrm/ranks',

      'permission_prefix' => 'hrm_rank',

      'actions' => ['view','edit','delete']

    )
  )

@endsection
