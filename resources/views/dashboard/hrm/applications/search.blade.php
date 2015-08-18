@extends('dashboard.layout')

@section('content')

    <div class = "search-wrapper">

      <input type = "text" name = "search" onkeyup="handleSearch('application_search','hrm','applications')" class = "search-input"
        placeholder = "Search Application Records by Applicant Name, Applicant Email or application status... "/>

    </div>

    <div class = "result-wrapper">

    </div>


@endsection
