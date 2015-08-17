@extends('dashboard.layout')

@section('content')

    <div class = "search-wrapper">

      <input type = "text" name = "search" onkeyup="handleSearch('department_search','hrm','departments')" class = "search-input" placeholder = "Search Department by name... "/>

    </div>

    <div class = "result-wrapper">

    </div>


@endsection
