@extends('dashboard.layout')

@section('content')

<div class = "card half">

  @include('errors.error_list')

  {!! Form::open(['method' => 'POST','action' => 'UserController@create'] ) !!}

    @include('dashboard.users.partials._form',['submitButtonText'=>'Save'])

  {!! Form::close() !!}

</div>

@endsection
