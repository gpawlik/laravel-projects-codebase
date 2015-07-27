@extends('dashboard.layout')

@section('content')

  <div class = "card half">

    @include('errors.error_list')

    {!! Form::model($user, ['method' => 'PATCH','action' => ['UserController@update',$user->id] ] ) !!}

      @include('dashboard.users.partials._form',['submitButtonText'=>'Update','roles'=>$roles,'context'=>'update'])

    {!! Form::close() !!}

  </div>

@endsection
