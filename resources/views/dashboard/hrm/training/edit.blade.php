@extends('dashboard.layout')

@section('content')

  <div class = "card half">

    @include('errors.error_list')

    {!! Form::model($training, ['method' => 'POST','url' => ['hrm/training/update',$training->id]] ) !!}

      @include('dashboard.hrm.training.partials._form',['submitButtonText'=>'Update','context'=>'update'])

    {!! Form::close() !!}

  </div>

@endsection
