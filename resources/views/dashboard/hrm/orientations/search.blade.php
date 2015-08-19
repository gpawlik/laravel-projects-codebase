@extends('dashboard.layout')

@section('content')

    <div class = "search-wrapper">

      <input type = "text" name = "search" onkeyup="handleSearch('orientation_search','hrm','orientations')" class = "search-input"
        placeholder = "Search Orientation Records by Employee Name, Oritentation outcome or type a date between Orientation period (YYYY-MM-DD)... "/>

    </div>

    <div class = "result-wrapper">

    </div>


@endsection
