<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Company | {{$title}}</title>

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

				@if(isset($systemPermission))
					<a id = "system" class = "main-link"> <i class="fa fa-cogs"></i> &nbsp; System	</a>
							@if(isset($permissionPermission))<a href = "/system/permissions" class = "sub-link"><i class="fa fa-key"></i></i> &nbsp; Permissions</a>@endif
			        @if(isset($rolePermission))<a href = "/system/roles" class = "sub-link"><i class="fa fa-gavel"></i> &nbsp; Roles</a>@endif
			        @if(isset($userPermission))<a href = "/system/users" class = "sub-link"><i class="fa fa-user"></i> &nbsp; Users</a>@endif
				@endif
      </li>

    </ul>

  </nav>

  <div id = "content-wrapper">
    <header>
			<div class = "float-left">
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