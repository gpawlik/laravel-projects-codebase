@extends('dashboard.layout')

@section('content')

  <div class = "well half">

    @include('errors.error_list')

    {!! Form::model($user, ['method' => 'PATCH','url' => ['system/users',$user->id], 'files'=>true ] ) !!}

      @include('dashboard.system.users.partials._form',['submitButtonText'=>'Update','roles'=>$roles,'context'=>'update'])

    {!! Form::close() !!}

  </div>

@endsection
