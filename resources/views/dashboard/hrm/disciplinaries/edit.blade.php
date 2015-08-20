@extends('dashboard.layout')

@section('content')

  <div class = "card half">

    @include('errors.error_list')

    {!! Form::model($disciplinary, ['method' => 'POST','url' => ['hrm/disciplinaries/update',$disciplinary->id]] ) !!}

      @include('dashboard.hrm.disciplinaries.partials._form',['submitButtonText'=>'Update','context'=>'update'])

    {!! Form::close() !!}

  </div>

@endsection
