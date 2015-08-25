@extends('dashboard.layout')

@section('content')

    <div class = "search-wrapper">

      <input type = "text" name = "search" onkeyup="handleSearch('training_search','hrm','training')" class = "search-input"
        placeholder = "Search Training Records by Employee Name, Training Type or enter a date between training period (YYYY-MM-DD)... "/>

    </div>

    <div class = "result-wrapper">

    </div>


@endsection
