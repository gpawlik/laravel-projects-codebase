@extends('dashboard.layout')

@section('content')

  <div class = "well half">

    @include('errors.error_list')

    {!! Form::model($permission, ['method' => 'PATCH','url' => ['system/permissions',$permission->id]] ) !!}

      @include('dashboard.system.permissions.partials._form',['submitButtonText'=>'Update','roles'=>$roles,'context'=>'update'])

    {!! Form::close() !!}

  </div>

@endsection
