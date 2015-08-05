@extends('dashboard.layout')

@section('content')

  <div class = "card half">

    @include('errors.error_list')

    {!! Form::model($user, ['method' => 'POST','url' => ['system/users/update',$user->id], 'files'=>true ] ) !!}

      @include('dashboard.system.users.partials._form',['submitButtonText'=>'Update','roles'=>$roles,'context'=>'update'])

    {!! Form::close() !!}

  </div>

@endsection
