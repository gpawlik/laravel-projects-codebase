@extends('dashboard.layout')

@section('content')

    <div class = "search-wrapper">

      <input type = "text" name = "search" onkeyup="handleSearch('disciplinary_search','hrm','disciplinaries')" class = "search-input"
        placeholder = "Search Disciplinary Records by Employee Name, Warning type or Disciplinary Action... "/>

    </div>

    <div class = "result-wrapper">

    </div>


@endsection
