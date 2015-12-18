@extends('dashboard.layout')

@section('content')

<div class = "well half">

  @include('errors.error_list')

  {!! Form::open(['method' => 'POST','action' => 'UserController@store','files'=>true] ) !!}

    @include('dashboard.system.users.partials._form',['submitButtonText'=>'Save','context'=>'add'])

  {!! Form::close() !!}

</div>

@endsection
