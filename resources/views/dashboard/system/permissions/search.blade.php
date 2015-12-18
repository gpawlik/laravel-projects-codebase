@extends('dashboard.layout')

@section('content')

    <div class = "search-wrapper">

      <input type = "text" name = "search" onkeyup="handleSearch('permission_search','system','permissions')" class = "form-control"
        placeholder = "Search Permissions by Name"/>

    </div>

    <div class = "result-wrapper">

    </div>


@endsection
