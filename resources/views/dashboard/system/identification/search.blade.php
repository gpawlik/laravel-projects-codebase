@extends('dashboard.layout')

@section('content')

    <div class = "search-wrapper">

      <input type = "text" name = "search" onkeyup="handleSearch('identification_search','system','identification')" class = "search-input"
        placeholder = "Search Identifications by Name.."/>

    </div>

    <div class = "result-wrapper">

    </div>


@endsection
