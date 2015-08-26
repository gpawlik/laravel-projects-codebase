@extends('dashboard.layout')

@section('content')

<h3 class = "dashboard-heading">General Information</h3>

<div class="grid">

	@if(isset($employeeCount))
		<div class = "dashboard-card short-cards green-border quarter inline grid-item">
			<div>
				<span class = "big-text green-color">{{ $employeeCount }}  &nbsp;&nbsp; <i class="fa fa-users"></i></span>
				Employees
			</div>
		</div>
	@endif

	@if(isset($departmentsCount))
		<div class = "dashboard-card short-cards blue-border quarter inline grid-item">
			<div>
				<span class = "big-text blue-color">{{ $departmentsCount }} &nbsp;&nbsp; <i class="fa fa-building"></i> </span>
				Departments
			</div>
		</div>
	@endif

	@if(isset($jobCount))
		<div class = "dashboard-card short-cards amber-border quarter inline grid-item">
			<div>
				<span class = "big-text amber-color">{{ $jobCount }} &nbsp;&nbsp; <i class="fa fa-briefcase"></i></span>
				Job Positions
			</div>
		</div>
	@endif


	@if(isset($totalSalaries))
		<div class = "dashboard-card short-cards turquise-border quarter inline grid-item">
			<div>
				<span class = "big-text turquise-color"> GHC {{ $totalSalaries }} </span>
				Total Net Salaries
			</div>
		</div>
	@endif

	@if(isset($totalAllowance))
		<div class = "dashboard-card short-cards alizarin-border quarter inline grid-item">
			<div>
				 <span class = "big-text alizarin-color">GHC {{ $totalAllowance }} </span>
				Total Allowances
			</div>
		</div>
	@endif

	@if(isset($totalSSNIT))
		<div class = "dashboard-card short-cards brown-border quarter inline grid-item">
			<div>
				<span class = "big-text brown-color">GHC {{ $totalSSNIT }}</span>
				SSNIT Contribitions
			</div>
		</div>
	@endif

	@if(isset($totalTax))
		<div class = "dashboard-card short-cards green-sea-border quarter inline grid-item">
			<div>
				<span class = "big-text green-sea-color">GHC {{ $totalTax }}</span>
				Total Employee Tax
			</div>
		</div>
	@endif

</div>
<br/>


<h3 class = "dashboard-heading">Notices & Reminders</h3>

<div class="grid">

	@if(isset($vacant_jobs))
		<div id = "leaves" class = "dashboard-card quarter green-border inline grid-item">
			<h3 class = "title green-color"><i class="fa fa-plus-circle"></i> &nbsp;&nbsp; Vacancies</h3>

			<div class = "content">
				<p>Vacant Job Positions : {{ count($vacant_jobs) }}</p>

				<b>Job Positions Vacant</b>

				<div id = "pending-reminders">
					@if(count($vacant_jobs) > 0)
						@foreach($vacant_jobs as $vacant_job)

							<p>
								{{ $vacant_job -> job_title }} <span class = "red-note" >( {{ App\Department::find($vacant_job->department_id)->department_name }} )</span><br/>
								<span class = "red-note" >Employees Needed : {{ ($vacant_job -> job_capacity - \DB::table("employees")->where("employment_status","ACTIVE")->where("job_id",$vacant_job->id)->count()) }}</span>
							</p>

						@endforeach
					@else
						<div>No Job Vacancies</div>
					@endif
				</div>
			</div>
		</div>
	@endif

	@if(isset($applications))
		<div class = "dashboard-card quarter blue-border inline grid-item">
			<h3 class = "title blue-color"><i class="fa fa-file-text"></i> &nbsp;&nbsp; Job Applications</h3>

			<div class = "content">

				<p>No. of Pending Applications : {{ $applicationCount }}</p>

				<b>Scheduled Interviews</b>

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
		<div id = "leaves" class = "dashboard-card pumpkin-border quarter inline grid-item">
			<h3 class = "title pumpkin-color"><i class="fa fa-plane"></i> &nbsp;&nbsp; Leave Days</h3>

				<div class = "content">

					<p>No. of Employees on Leave : {{ count($leaves) }}</p>

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
		<div id = "reminders" class = "dashboard-card red-border quarter inline grid-item">
			<h3 class = "title red-color"><i class="fa fa-bell-o"></i> &nbsp;&nbsp; Reminders</h3>

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

</div>
<br/>

<h3 class = "dashboard-heading">Statistics</h3>

<div class="grid">

	@if(isset($genderDistro))
		<div id = "gender-chart-wrapper" class = "dashboard-card green-sea-border quarter inline grid-item">
			<h3 class = "title green-sea-color"><i class="fa fa-male"></i><i class="fa fa-female"></i> &nbsp;&nbsp; Gender Distribution</h3>

			<div class = "content">

					<canvas id="gender-chart" width="400" height="200"></canvas>

			</div>

		</div>
	@endif

	@if(isset($jobDistro))
		<div id = "job-chart-wrapper" class = "dashboard-card green-border quarter inline grid-item">
			<h3 class = "title green-color"><i class="fa fa-pie-chart"></i> &nbsp;&nbsp; Employee Distribution</h3>

			<div class = "content">

					<canvas id="job-chart" width="400" height="200"></canvas>

			</div>

		</div>
	@endif

</div>



@endsection
