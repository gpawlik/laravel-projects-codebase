@extends('dashboard.layout')

@section('content')

    <div class = "search-wrapper">

      <input type = "text" name = "search" onkeyup="handleSearch('rank_search','hrm','ranks')" class = "search-input" placeholder = "Search Rank Records by code or name... "/>

    </div>

    <div class = "result-wrapper">

    </div>


@endsection
