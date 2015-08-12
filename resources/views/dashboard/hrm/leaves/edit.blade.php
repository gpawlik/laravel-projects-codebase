@extends('dashboard.layout')

@section('content')

  <div class = "card half">

    @include('errors.error_list')

    {!! Form::model($leave, ['method' => 'POST','url' => ['hrm/jobs/update',$leave->id]] ) !!}

      @include('dashboard.hrm.leaves.partials._form',['submitButtonText'=>'Update','context'=>'update'])

    {!! Form::close() !!}

  </div>

@endsection
