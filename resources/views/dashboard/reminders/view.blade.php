@extends('dashboard.layout')

@section('content')

<a href="/dashboard/reminders" >
  <div class = "mini-link" title = "Back">
    <i class="fa fa-angle-left"></i>
  </div>
</a>


<div class = "card half">

  <h3>Reminder</h3>

  <p>
    {{ $reminder -> note }}
  </p>

  <p class = "red-note">
    {{ $reminder -> description }}
  </p>

  <p>
    <i class="fa fa-bell-o"></i> {{ $reminder -> due_date }}
  </p>

</div>

@endsection
