@extends('dashboard.layout')

@section('content')

    <div class = "search-wrapper">

      <input type = "text" name = "search" onkeyup="handleSearch('bank_search','system','banks')" class = "search-input"
        placeholder = "Search Banks by Bank Name or Swift Code "/>

    </div>

    <div class = "result-wrapper">

    </div>


@endsection
