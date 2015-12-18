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
  	<link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/font-awesome.min.css') }}" rel="stylesheet">

  	<script src="{{ asset('/js/jquery.js') }}" rel="stylesheet"></script>
	<script src="{{ asset('/js/bootstrap.min.js') }}" rel="stylesheet"></script>
	<script src="{{ asset('/js/masonry.pkgd.min.js') }}" rel="stylesheet"></script>
	<script src="{{ asset('/js/dash.js') }}" rel="stylesheet"></script>


	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>
<body>
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

	<header id = "main-header">

		<div class = "float-left">
			<a href = "/dashboard">
				<h2>Dashboard</h2>
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
			<div class = "box-padding" id = "user-name">
				{{Auth::user()->first_name}} {{Auth::user()->last_name}}
			</div>
		</div>
		
		<div class = "float-right">
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
	</header>

  	<nav id = "main-nav">
	    <ul>
	      <li>

			@if(isset($systemPermission))
				<a id = "system" class = "main-link"> <i class="fa fa-plus"></i> &nbsp; System	</a>

				@if(isset($companyPermission))
					<a href = "/system/company" id = "company-sub-link" class = "sub-link <?php if(isset($activeLink)) { if($activeLink == 'company') { echo 'active-link'; } } ?>">
						<i class="fa fa-user"></i> &nbsp; Company Details
					</a>
				@endif

				@if(isset($permissionPermission))
					<a href = "/system/permissions" id = "permission-sub-link" class = "sub-link <?php if(isset($activeLink)) { if($activeLink == 'permission') { echo 'active-link'; } } ?>">
						<i class="fa fa-key"></i> &nbsp; Permissions
					</a>
				@endif

				@if(isset($rolePermission))
					<a href = "/system/roles" id = "role-sub-link" class = "sub-link <?php if(isset($activeLink)) { if($activeLink == 'role') { echo 'active-link'; } } ?>">
						<i class="fa fa-gavel"></i> &nbsp; Roles
					</a>
				@endif

				@if(isset($userPermission))
					<a href = "/system/users" id = "user-sub-link" class = "sub-link <?php if(isset($activeLink)) { if($activeLink == 'user') { echo 'active-link'; } } ?>">
						<i class="fa fa-user"></i> &nbsp; Users
					</a>
				@endif
			@endif

	      </li>

	    </ul>

 	</nav>

  	<div id = "content-wrapper">
    	

		@if(isset($warningMessage))
	      	<div id = "warning-box">
	        	{{ $warningMessage }}
	      	</div>
    	@endif

		@if(Session::has('message'))
			<div id = "session-box">
				{{ Session::get('message') }}
			</div>
    	@endif

		@if(isset($subTitle))
			<h3 class = "sub-title">
				{{ $subTitle }}
			</h3>
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
							<div id = "{{ str_replace(" ","_",strtolower($subLink['title'])) }}" class = "mini-link" title = "{{$subLink['title']}}">
								{!! $subLink['icon'] !!}
							</div>
						</a>
					@endif
				@endforeach
			@endif

      	@yield("content")

<!-- 		<div id = "signature">
			<span><i class="fa fa-power-off"></i> &nbsp; Powered By : <b>DB Technologies</b></span>
		</div> -->

    </div>

  </div>

  <div class = "clear-floats"></div>

</body>

</html>
