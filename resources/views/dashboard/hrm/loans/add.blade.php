@extends('dashboard.layout')

@section('content')

<div class = "card half">

  @include('errors.error_list')

  {!! Form::open(['method' => 'POST','action' => 'LoanController@create'] ) !!}

    @include('dashboard.hrm.loans.partials._form',['submitButtonText'=>'Save','context'=>'add'])

  {!! Form::close() !!}

</div>

@endsection
