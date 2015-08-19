@extends('dashboard.layout')

@section('content')

	@if(isset($employeeCount))
		<div class = "dashboard-card quarter inline">
			<div class = "content white-text turquise">
				<b> <i class="fa fa-users"></i> Total Number of Employees : {{ $employeeCount }}</b>
			</div>
		</div>
	@endif

	@if(isset($departmentsCount))
		<div class = "dashboard-card quarter inline">
			<div class = "content white-text alizarin">
				<b> <i class="fa fa-building"></i> Total Number of Departments : </b>{{ $departmentsCount }}
			</div>
		</div>
	@endif

	@if(isset($jobCount))
		<div class = "dashboard-card quarter inline">
			<div class = "content white-text brown">
				<b> <i class="fa fa-briefcase"></i> Job Categories : </b>{{ $jobCount }}
			</div>
		</div>
	@endif

	<br/>

	@if(isset($vacant_jobs))
		<div id = "leaves" class = "dashboard-card quarter inline">
			<h3 class = "title green"><i class="fa fa-plus-circle"></i> Vacancies</h3>

			<div class = "content">
				<p>Vacant Job Positions : {{ count($vacant_jobs) }}</p>

				<b>Job Positions Vacant</b>

				<div id = "pending-reminders">
					@foreach($vacant_jobs as $vacant_job)

						<p>
							{{ $vacant_job -> job_title }} <span class = "red-note" >( {{ App\Department::find($vacant_job->department_id)->department_name }} )</span><br/>
							<span class = "red-note" >Employees Needed : {{ ($vacant_job -> job_capacity - \DB::table("employees")->where("employment_status","ACTIVE")->where("job_id",$vacant_job->id)->count()) }}</span>
						</p>

					@endforeach
				</div>
			</div>
		</div>
	@endif

	@if(isset($applications))
		<div class = "dashboard-card quarter inline">
			<h3 class = "title blue"><i class="fa fa-file-text"></i> Job Applications</h3>

			<div class = "content">

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

		</div>
	@endif

	@if(isset($leaves))
		<div id = "leaves" class = "dashboard-card quarter inline">
			<h3 class = "title pumpkin"><i class="fa fa-plane"></i> Employees on Leave</h3>

				<div class = "content">

					<p>Number of Employees on Leave : {{ count($leaves) }}</p>

					<b>Employees Currently on Leave</b>

					@if(count($leaves) > 0)
					<div id = "pending-reminders">
						@foreach($leaves as $leave)

							<p>
								{{ App\Employee::find($leave->employee_id)->first_name }} {{ App\Employee::find($leave->employee_id)->last_name }}<br/>
								<span class = "red-note">{{ date('F jS, Y',strtotime($leave -> leave_start_date)) }} - {{ date('F jS, Y',strtotime($leave -> leave_end_date)) }}</span>
							</p>

						@endforeach
					</div>
					@else
						<div>No Employee on Leave</div>
					@endif
			</div>

		</div>
	@endif

	@if(isset($reminders))
		<div id = "reminders" class = "dashboard-card quarter inline">
			<h3 class = "title amber"><i class="fa fa-bell-o"></i> Reminders</h3>

			<div class = "content">

					<p>All Reminders : {{ $reminders->count() }}</p>

					<b>Pending Reminders</b>

					@if(isset($pendingReminders))
					<div id = "pending-reminders">
						@foreach($pendingReminders as $reminder)

							@if(isset($reminder))

							<p>
								{{ $reminder -> note }} @if(isset($reminder -> due_date))<span class = "red-note">( {{ date('F jS, Y',strtotime($reminder -> due_date)) }} )</span>@endif
							</p>

							@endif

						@endforeach
					</div>
					@else
						<div>No Pending Reminders </div>
					@endif
			</div>

		</div>
	@endif





@endsection
