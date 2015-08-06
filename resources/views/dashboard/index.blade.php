@extends('dashboard.layout')

@section('content')

	<div class = "card quarter inline">
		<b>Total Number of Departments : </b>{{ $departmentsCount }}
	</div>

	<div class = "card quarter inline">
		<b>Job Categories : </b>{{ $jobCount }}
	</div>

@endsection
