@extends('dashboard.layout')

@section('content')

	@if(isset($employeeCount))
		<div class = "card quarter inline">
			<b>Total Number of Employees : </b>{{ $employeeCount }}
		</div>
	@endif

	@if(isset($departmentsCount))
		<div class = "card quarter inline">
			<b>Total Number of Departments : </b>{{ $departmentsCount }}
		</div>
	@endif

	@if(isset($jobCount))
		<div class = "card quarter inline">
			<b>Job Categories : </b>{{ $jobCount }}
		</div>
	@endif

@endsection
