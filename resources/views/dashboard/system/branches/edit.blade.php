@extends('dashboard.layout')

@section('content')

  <div class = "card half">

    @include('errors.error_list')

    {!! Form::model($branch, ['method' => 'PATCH','url' => ['system/branches',$branch->id]] ) !!}

      @include('dashboard.system.branches.partials._form',['submitButtonText'=>'Update','context'=>'update'])

    {!! Form::close() !!}

  </div>

@endsection
