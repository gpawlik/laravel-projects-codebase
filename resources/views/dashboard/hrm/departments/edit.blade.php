@extends('dashboard.layout')

@section('content')

  <div class = "card half">

    @include('errors.error_list')

    {!! Form::model($department, ['method' => 'POST','url' => ['hrm/departments/update',$department->id]] ) !!}

      @include('dashboard.hrm.departments.partials._form',['submitButtonText'=>'Update','context'=>'update'])

    {!! Form::close() !!}

  </div>

@endsection
