<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
		//get company details
		$company = App\Company::all()->first();
	?>
	<title>@if(isset($company->company_name)) {{ $company->company_name }} @else Company @endif | {{$title}}</title>

  <link href="{{ asset('/css/normalize.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/font-awesome.min.css') }}" rel="stylesheet">

  <script src="{{ asset('/js/jquery.js') }}" rel="stylesheet"></script>
	<script src="{{ asset('/js/dash.js') }}" rel="stylesheet"></script>


	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>
<body>

  <nav id = "main-nav">
		<a href = "/dashboard">
	    <header>
	      <h2><i class="fa fa-dashcube"></i>  &nbsp; Dashboard</h2>
	    </header>
		</a>

		<!-- check if user has permissions -->
		<?php
			//variables for permissions

			$permissions = \DB::table("permissions")->where("role_id",Auth::user()->role_id)->get();
			$configParentPermissions = \Config::get("Permission.parents");
			$models = App\Http\Controllers\RoleController::getModels();

			foreach($permissions as $permission)
			{

				foreach($configParentPermissions as $configPerm)
				{

					if(explode("_",$permission->permission_name)[0] == $configPerm)
					{
						${$configPerm . "Permission"} = 1;
						break;
					}

				}

				foreach($models as $model)
				{

					if(explode("_",$permission->permission_name)[1] == str_replace("app\\","",strtolower($model)))
					{
						${explode("_",$permission->permission_name)[1] . "Permission"} = 1;
						break;
					}

				}

			}
		?>

    <ul>
      <li>

				@if(isset($hrmPermission))
						<a id = "hrm" class = "main-link"><i class="fa fa-database"></i> &nbsp; HRM	</a>

						@if(isset($employeePermission))
							<a href = "/hrm/employees" class = "sub-link <?php if(isset($activeLink)) { if($activeLink == 'employee') { echo 'active-link'; } } ?>">
								<i class="fa fa-users"></i> &nbsp; Employees
							</a>
						@endif

						@if(isset($applicationPermission))
							<a href = "/hrm/applications" class = "sub-link <?php if(isset($activeLink)) { if($activeLink == 'application') { echo 'active-link'; } } ?>">
								<i class="fa fa-file-text"></i> &nbsp; Job Applications
							</a>
						@endif

						@if(isset($jobPermission))
							<a href = "/hrm/jobs" class = "sub-link <?php if(isset($activeLink)) { if($activeLink == 'job') { echo 'active-link'; } } ?>">
								<i class="fa fa-briefcase"></i> &nbsp; Jobs Positions
							</a>
						@endif

						@if(isset($terminationPermission))
							<a href = "/hrm/job_terminations" class = "sub-link <?php if(isset($activeLink)) { if($activeLink == 'termination') { echo 'active-link'; } } ?>">
								<i class="fa fa-fire"></i> &nbsp; Job Terminations
							</a>
						@endif

						@if(isset($leavePermission))
							<a href = "/hrm/leaves" class = "sub-link <?php if(isset($activeLink)) { if($activeLink == 'leave') { echo 'active-link'; } } ?>">
							<i class="fa fa-plane"></i> &nbsp; Leave Days
							</a>
						@endif

						@if(isset($orientationPermission))
							<a href = "/hrm/orientations" class = "sub-link <?php if(isset($activeLink)) { if($activeLink == 'orientation') { echo 'active-link'; } } ?>">
								<i class="fa fa-pencil-square-o"></i> &nbsp; Orientations
							</a>
						@endif


						@if(isset($paygradePermission))
							<a href = "/hrm/pay_grades" class = "sub-link <?php if(isset($activeLink)) { if($activeLink == 'paygrade') { echo 'active-link'; } } ?>">
							<i class="fa fa-money"></i> &nbsp; Pay Grades
							</a>
						@endif

						@if(isset($departmentPermission))
							<a href = "/hrm/departments" class = "sub-link <?php if(isset($activeLink)) { if($activeLink == 'department') { echo 'active-link'; } } ?>">
								<i class="fa fa-building"></i> &nbsp; Departments
							</a>
						@endif

						@if(isset($rankPermission))
							<a href = "/hrm/ranks" class = "sub-link <?php if(isset($activeLink)) { if($activeLink == 'rank') { echo 'active-link'; } } ?>">
								<i class="fa fa-star"></i> &nbsp; Ranks
							</a>
						@endif

						@if(isset($trainingPermission))
							<a href = "/hrm/training" class = "sub-link <?php if(isset($activeLink)) { if($activeLink == 'training') { echo 'active-link'; } } ?>">
								<i class="fa fa-puzzle-piece"></i> &nbsp; Training
							</a>
						@endif

				@endif

				@if(isset($systemPermission))
					<a id = "system" class = "main-link"> <i class="fa fa-cogs"></i> &nbsp; System	</a>
							@if(isset($bankPermission))
								<a href = "/system/banks" class = "sub-link <?php if(isset($activeLink)) { if($activeLink == 'bank') { echo 'active-link'; } } ?>"><i class="fa fa-university"></i> &nbsp; Banks</a>
							@endif

							@if(isset($branchPermission))
								<a href = "/system/branches" class = "sub-link <?php if(isset($activeLink)) { if($activeLink == 'branch') { echo 'active-link'; } } ?>"><i class="fa fa-code-fork"></i></i> &nbsp; Branches</a>
							@endif

							@if(isset($companyPermission))
								<a href = "/system/company" class = "sub-link <?php if(isset($activeLink)) { if($activeLink == 'company') { echo 'active-link'; } } ?>"><i class="fa fa-user"></i> &nbsp; Company Details</a>
							@endif

							@if(isset($identificationPermission))
								<a href = "/system/identification" class = "sub-link <?php if(isset($activeLink)) { if($activeLink == 'identification') { echo 'active-link'; } } ?>">
									<i class="fa fa-credit-card"></i> &nbsp; Identification
								</a>
							@endif

							@if(isset($permissionPermission))
								<a href = "/system/permissions" class = "sub-link <?php if(isset($activeLink)) { if($activeLink == 'permission') { echo 'active-link'; } } ?>"><i class="fa fa-key"></i> &nbsp; Permissions</a>
							@endif

			        @if(isset($rolePermission))
								<a href = "/system/roles" class = "sub-link <?php if(isset($activeLink)) { if($activeLink == 'role') { echo 'active-link'; } } ?>"><i class="fa fa-gavel"></i> &nbsp; Roles</a>
							@endif

			        @if(isset($userPermission))
								<a href = "/system/users" class = "sub-link <?php if(isset($activeLink)) { if($activeLink == 'user') { echo 'active-link'; } } ?>"><i class="fa fa-user"></i> &nbsp; Users</a>
							@endif
				@endif

      </li>

    </ul>

  </nav>

  <div id = "content-wrapper">
    <header>
			<div class = "float-left">
				<!-- Messages logic -->

				<?php

					$numberUnreadMessages = \DB::table("messages")->where("to_user_id",Auth::user()->id)->where("status","UNREAD")->count();

				?>

				<a href = "/dashboard/messages">
					<div class = "box-padding" id = "messages-btn" title = "Messages">
						<i class="fa fa-envelope-o"></i>
						@if($numberUnreadMessages > 0)
							<div id = "unread-msg-badge">{{$numberUnreadMessages}}</div>
						@endif
					</div>
				</a>
				<a href = "/dashboard/reminders">
					<div class = "box-padding" id = "reminders-btn" title = "Reminders">
						<i class="fa fa-bell-o"></i>
					</div>
				</a>
				<a href = "/dashboard/profile">
					<div class = "box-padding" id = "profile-btn" title = "Profile Settings">
						<i class="fa fa-cog"></i>
					</div>
				</a>
				<a href = "/auth/logout">
					<div class = "box-padding" id = "logout-btn" title = "Logout">
						<i class="fa fa-power-off"></i>
					</div>
				</a>
			</div>
			<div class = "float-right">

					@if(isset(Auth::user()->image_name))
						<div class = "box">
							<div id = "profile-pic">
								<img src = "/uploads/{{Auth::user()->image_name}}" />
							</div>
						</div>
					@else
						<div class = "box-padding">
							<i class="fa fa-user"></i>
						</div>
					@endif
				<div class = "box-padding">
					{{Auth::user()->first_name}} {{Auth::user()->last_name}}
				</div>
			</div>
    </header>
		@if(Session::has('message'))
      <div id = "session-box">
        {{ Session::get('message') }}
      </div>
    @endif

    <div id = "content">

			@if(isset($subLinks))
				@foreach($subLinks as $subLink)
				<?php

					$subLinkAccess = null;

					foreach($permissions as $permission)
					{
						if($permission->permission_name == $subLink['permission'])
						{
							$subLinkAccess = 1;
							break;

						}
					}

				?>
					@if(isset($subLinkAccess))
						<a @if(isset($subLink['route'])) href = "{{$subLink['route']}}" @endif>
							<div class = "mini-link" title = "{{$subLink['title']}}">
								{!! $subLink['icon'] !!}
							</div>
						</a>
					@endif
				@endforeach
			@endif

      @yield("content")
    </div>
  </div>

  <div class = "clear-floats"></div>

</body>

</html>
