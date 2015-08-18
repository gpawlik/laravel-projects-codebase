@extends('dashboard.layout')

@section('content')

    <div class = "search-wrapper">

      <input type = "text" name = "search" onkeyup="handleSearch('job_search','hrm','jobs')" class = "search-input"
        placeholder = "Search Job Records by job title... "/>

    </div>

    <div class = "result-wrapper">

    </div>


@endsection
