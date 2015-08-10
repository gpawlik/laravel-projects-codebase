@extends('dashboard.layout')

@section('content')

<div class = "card half">

    @include('errors.error_list')

    {!! Form::model($application, ['method' => 'POST','url' => ['hrm/applications/update',$application->id], 'files'=>true ] ) !!}

      @include('dashboard.hrm.applications.partials._form',['submitButtonText'=>'Update','context'=>'update'])

    {!! Form::close() !!}

</div>

@endsection
