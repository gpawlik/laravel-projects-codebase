@extends('dashboard.layout')

@section('content')



  @include('errors.error_list')

  {!! Form::open(['method' => 'POST','action' => 'EmployeeController@create','files'=>true] ) !!}

    @include('dashboard.hrm.employees.partials._form',['submitButtonText'=>'Save','context'=>'add'])

  {!! Form::close() !!}


@endsection
