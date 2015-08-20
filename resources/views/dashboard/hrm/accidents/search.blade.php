@extends('dashboard.layout')

@section('content')

    <div class = "search-wrapper">

      <input type = "text" name = "search" onkeyup="handleSearch('accident_search','hrm','accidents')" class = "search-input"
        placeholder = "Search Accident Records by Employee Name, Accident Date or Report Date or Supervisor Name... "/>

    </div>

    <div class = "result-wrapper">

    </div>


@endsection
