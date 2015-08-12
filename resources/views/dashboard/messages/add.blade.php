@extends('dashboard.layout')

@section('content')

<a href="/dashboard/messages" >
  <div class = "mini-link" title = "Back">
    <i class="fa fa-angle-left"></i>
  </div>
</a>

<div class = "card half">

  @include('errors.error_list')

  {!! Form::open(['method' => 'POST','action' => 'MessageController@create'] ) !!}

  <table class = "form-element full">

    <tr>
      <td>{!! Form::label("subject","Subject*") !!}</td>
      <td>{!! Form::text("subject", null , ['placeholder' => 'Subject','class'=>'text-input']) !!}</td>
    </tr>

    <tr>
      <td>{!! Form::label("message","Message*") !!}</td>
      <td>{!! Form::textarea("message", null , ['placeholder' => 'Message','class'=>'text-input']) !!}</td>
    </tr>


    <tr>
      <td>{!! Form::label("to_user","To User*") !!}</td>
      <td>
        {!! Form::text('to_user', null , ['class'=>'text-input','id'=>'to-user-field','autocomplete'=>'off','placeholder'=>'Search User First / Last Name']) !!}
        <div id = "users-list">

        </div>
      </td>
    </tr>


    <tr>
      <td colspan="2" align="right">{!! Form::submit("Send", array('class' => 'submit-button')) !!}</td>
    </tr>

  </table>


  {!! Form::close() !!}

</div>

@endsection
