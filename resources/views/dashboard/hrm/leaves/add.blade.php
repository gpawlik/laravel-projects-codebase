@extends('dashboard.layout')

@section('content')

<div class = "card half">

  @include('errors.error_list')

  {!! Form::open(['method' => 'POST','action' => 'LeaveController@create'] ) !!}

    @include('dashboard.hrm.leaves.partials._form',['submitButtonText'=>'Save','context'=>'add'])

  {!! Form::close() !!}

</div>

@endsection
