@extends('dashboard.layout')

@section('content')

<a href="/dashboard/reminders" >
  <div class = "mini-link" title = "Back">
    <i class="fa fa-angle-left"></i>
  </div>
</a>

<div class = "card half">

    @include('errors.error_list')

    {!! Form::model($reminder, ['method' => 'POST','url' => ['dashboard/reminders/update',$reminder->id]] ) !!}

      @include('dashboard.reminders.partials._form',['submitButtonText'=>'Update','context'=>'update'])

    {!! Form::close() !!}

</div>

@endsection
