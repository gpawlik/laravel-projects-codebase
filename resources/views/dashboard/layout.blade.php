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
    <header>
      <h2><i class="fa fa-dashcube"></i>  &nbsp; Dashboard</h2>
    </header>

    <ul>
      <li><a class = "main-link"><i class="fa fa-cogs"></i> &nbsp; System</a>
        <li><a href = "#" class = "sub-link"><i class="fa fa-gavel"></i> &nbsp; Roles</a></li>
        <li><a href = "/dashboard/users" class = "sub-link"><i class="fa fa-user"></i> &nbsp; Users</a></li>
      </li>

    </ul>

  </nav>

  <div id = "content-wrapper">
    <header>
			<div class = "float-left">
				<div class = "box" id = "logout-btn" title = "Logout">
					<i class="fa fa-power-off"></i>
				</div>
			</div>
			<div class = "float-right">
				<div class = "box">
					{{Auth::user()->first_name}} {{Auth::user()->last_name}}
				</div>
				<div class = "box">

				</div>
			</div>
    </header>

    <div id = "content">
      @yield("content")
    </div>
  </div>

  <div class = "clear-floats"></div>

</body>

</html>
