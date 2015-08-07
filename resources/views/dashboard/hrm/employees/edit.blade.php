@extends('dashboard.layout')

@section('content')

    @include('errors.error_list')

    {!! Form::model($employee, ['method' => 'POST','url' => ['hrm/employees/update',$employee->id], 'files'=>true ] ) !!}

      @include('dashboard.hrm.employees.partials._form',['submitButtonText'=>'Update','roles'=>$employee,'context'=>'update'])

    {!! Form::close() !!}

@endsection
