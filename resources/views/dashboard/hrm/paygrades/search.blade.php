@extends('dashboard.layout')

@section('content')

    <div class = "search-wrapper">

      <input type = "text" name = "search" onkeyup="handleSearch('pay_grade_search','hrm','pay_grades')" class = "search-input"
        placeholder = "Search Pay Grade Records by description, Minimum 0r Maximum Salary or job title... "/>

    </div>

    <div class = "result-wrapper">

    </div>


@endsection
