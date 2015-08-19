@extends('dashboard.layout')

@section('content')

    <div class = "search-wrapper">

      <input type = "text" name = "search" onkeyup="handleSearch('leave_search','hrm','leaves')" class = "search-input"
        placeholder = "Search Leave Records by Employee Name or type a date between leave period (YYYY-MM-DD)... "/>

    </div>

    <div class = "result-wrapper">

    </div>


@endsection
