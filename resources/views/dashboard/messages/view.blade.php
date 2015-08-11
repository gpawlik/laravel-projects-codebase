@extends('dashboard.layout')

@section('content')

<a href="/dashboard/messages" >
  <div class = "mini-link" title = "Back">
    <i class="fa fa-angle-left"></i>
  </div>
</a>


<div class = "card half">

  <h3>{{ $message -> subject }}</h3>

  <p>
    {!! str_replace("\r","<br/>",$message -> message) !!}
  </p>

  <p class = "red-note">
    From : {{ App\User::find($message -> from_user_id)->first_name }} {{ App\User::find($message -> from_user_id)->last_name }}
  </p>

  <p class = "red-note">
    To : {{ App\User::find($message -> to_user_id)->first_name }} {{ App\User::find($message -> to_user_id)->last_name }}
  </p>

</div>

@endsection
