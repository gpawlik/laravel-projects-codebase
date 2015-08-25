@extends('dashboard.layout')

@section('content')

    <div class = "search-wrapper">

      <input type = "text" name = "search" onkeyup="handleSearch('termination_search','hrm','job_terminations')" class = "search-input"
        placeholder = "Search job termination records by termination date, Employee Name or reason for termination..."/>

    </div>

    <div class = "result-wrapper">

    </div>


@endsection
