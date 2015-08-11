@extends('dashboard.layout')

@section('content')

  <div class = "card half">

    @include('errors.error_list')

    {!! Form::model($rank, ['method' => 'POST','url' => ['hrm/ranks/update',$rank->id]] ) !!}

      @include('dashboard.hrm.ranks.partials._form',['submitButtonText'=>'Update','context'=>'update'])

    {!! Form::close() !!}

  </div>

@endsection
