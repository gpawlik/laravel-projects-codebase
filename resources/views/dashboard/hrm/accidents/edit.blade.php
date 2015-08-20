@extends('dashboard.layout')

@section('content')

<div class = "card half">

    @include('errors.error_list')

    {!! Form::model($accident, ['method' => 'POST','url' => ['hrm/accidents/update',$accident->id]] ) !!}

      @include('dashboard.hrm.accidents.partials._form',['submitButtonText'=>'Update','context'=>'update'])

    {!! Form::close() !!}

</div>

@endsection
