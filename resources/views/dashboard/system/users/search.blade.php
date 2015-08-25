@extends('dashboard.layout')

@section('content')

    <div class = "search-wrapper">

      <input type = "text" name = "search" onkeyup="handleSearch('user_search','system','users')" class = "search-input"
        placeholder = "Search Users by Name, email, username or role "/>

    </div>

    <div class = "result-wrapper">

    </div>


@endsection
