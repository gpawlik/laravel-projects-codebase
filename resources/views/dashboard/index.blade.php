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

	@if(isset($applications))
		<div class = "card quarter">
			<h3>Job Applications</h3>
			<p>Total Number of Applications : {{ $applicationCount }}</p>

			<p><b>Scheduled Interviews</b></p>

			@if(isset($interviewsCount))
				@foreach($applications as $application)

					@if(isset($application -> applicant_interview_date))
						<div>{{ $application -> applicant_first_name }} {{ $application -> applicant_last_name }} - {{ date('F jS, Y',strtotime($application -> applicant_interview_date)) }}</div>
					@endif

				@endforeach
			@else
				<div>No interviews scheduled</div>
			@endif

		</div>
	@endif

@endsection
