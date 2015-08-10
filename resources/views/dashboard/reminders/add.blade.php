@extends('dashboard.layout')

@section('content')

<a href="/dashboard/reminders" >
  <div class = "mini-link" title = "Back">
    <i class="fa fa-angle-left"></i>
  </div>
</a>

<div class = "card half">

  @include('errors.error_list')

  {!! Form::open(['method' => 'POST','action' => 'ReminderController@create'] ) !!}

    @include('dashboard.reminders.partials._form',['submitButtonText'=>'Save','context'=>'add'])

  {!! Form::close() !!}

</div>

@endsection
