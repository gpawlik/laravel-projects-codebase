@extends('dashboard.layout')

@section('content')

  <div class = "card half">

    @include('errors.error_list')

    {!! Form::model($loan, ['method' => 'POST','url' => ['hrm/loans/update',$loan->id]] ) !!}

      @include('dashboard.hrm.loans.partials._form',['submitButtonText'=>'Update','context'=>'update'])

    {!! Form::close() !!}

  </div>

@endsection
