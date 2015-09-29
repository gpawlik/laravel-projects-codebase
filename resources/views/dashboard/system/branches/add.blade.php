@extends('dashboard.layout')

@section('content')

<div class = "card half">

  @include('errors.error_list')

  {!! Form::open(['method' => 'POST','action' => 'BranchController@store'] ) !!}

    @include('dashboard.system.branches.partials._form',['submitButtonText'=>'Save','context'=>'add'])

  {!! Form::close() !!}

</div>

@endsection
