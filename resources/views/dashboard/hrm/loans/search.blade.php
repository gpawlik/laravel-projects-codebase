@extends('dashboard.layout')

@section('content')

    <div class = "search-wrapper">

      <input type = "text" name = "search" onkeyup="handleSearch('loan_search','hrm','loans')" class = "search-input"
        placeholder = "Search Loan Records by Employee Name, Loan Type, Payment Status or type a date between Loan period (YYYY-MM-DD)... "/>

    </div>

    <div class = "result-wrapper">

    </div>


@endsection
