<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Change Password</title>

	<link href="{{ asset('/css/login.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/font-awesome.min.css') }}" rel="stylesheet">

  </script>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>

	<body>

		<div id = "login-box">

			<h1> <i class="fa fa-lock"></i> Change Password</h1>

			@include('errors.error_list')

			<form method="POST" action="{{ url('/dashboard/password_change') }}">

				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				<input type="password" class="f-input" name="password" placeholder="New Password">

				<input type="password" class="f-input" name="confirm_password" placeholder="Confirm Password">

				<button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Change Password </button>

			</form>

		</div>

	</body>

</html>
