@extends('dashboard.layout')

@section('content')

    <div class = "search-wrapper">

      <input type = "text" name = "search" onkeyup="handleSearch('branch_search','system','branches')" class = "search-input"
        placeholder = "Search Branches by Branch Name or Location "/>

    </div>

    <div class = "result-wrapper">

    </div>


@endsection
