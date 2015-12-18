@extends('dashboard.layout')

@section('content')

    <div class = "search-wrapper">

      <input type = "text" name = "search" onkeyup="handleSearch('role_search','system','roles')" class = "form-control"
        placeholder = "Search Roles by Role Name "/>

    </div>

    <div class = "result-wrapper">

    </div>


@endsection
