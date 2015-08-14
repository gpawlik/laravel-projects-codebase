@extends('dashboard.layout')

@section('content')

  <div class = "card half">

    @include('errors.error_list')

    {!! Form::model($orientation, ['method' => 'POST','url' => ['hrm/orientations/update',$orientation->id]] ) !!}

      @include('dashboard.hrm.orientations.partials._form',['submitButtonText'=>'Update','context'=>'update'])

    {!! Form::close() !!}

  </div>

@endsection
