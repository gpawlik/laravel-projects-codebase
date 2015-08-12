@extends('dashboard.layout')

@section('content')

  <div class = "card half">

    @include('errors.error_list')

    {!! Form::model($job, ['method' => 'POST','url' => ['hrm/jobs/update',$job->id]] ) !!}

      @include('dashboard.hrm.jobs.partials._form',['submitButtonText'=>'Update','departments'=>$departments,'context'=>'update'])

    {!! Form::close() !!}

  </div>

@endsection
