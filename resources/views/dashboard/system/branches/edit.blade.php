@extends('dashboard.layout')

@section('content')

  <div class = "card half">

    @include('errors.error_list')

    {!! Form::model($branch, ['method' => 'POST','url' => ['system/branches/update',$branch->id]] ) !!}

      @include('dashboard.system.branches.partials._form',['submitButtonText'=>'Update','context'=>'update'])

    {!! Form::close() !!}

  </div>

@endsection
