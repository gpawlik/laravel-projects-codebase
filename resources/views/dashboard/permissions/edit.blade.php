@extends('dashboard.layout')

@section('content')

  <div class = "card half">

    @include('errors.error_list')

    {!! Form::model($permission, ['method' => 'POST','url' => ['system/permissions/update',$permission->id]] ) !!}

      @include('dashboard.permissions.partials._form',['submitButtonText'=>'Update','roles'=>$roles,'context'=>'update'])

    {!! Form::close() !!}

  </div>

@endsection
