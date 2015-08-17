@extends('dashboard.layout')

@section('content')

    <div class = "search-wrapper">

      <input type = "text" name = "search" id = "employee" class = "search-input" placeholder = "Search Employee Records ... "/>
      <select name = "search-parameter" class = "search-select">
        <option value="first_name">First Name</option>
        <option value="last_name">Last Name</option>
      </select>

    </div>

    <div class = "result-wrapper">

    </div>


@endsection
