@extends('dashboard.layout')

@section('content')

    <div class = "search-wrapper">

      <input type = "text" name = "search" onkeyup="handleSearch('employee_search','hrm','employees')" class = "search-input" placeholder = "Search Employee Records by first name, last name or email... "/>

    </div>

    <div class = "result-wrapper">

    </div>


@endsection
