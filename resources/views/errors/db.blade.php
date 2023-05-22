<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Investment System</title>
	<link href="https://fonts.googleapis.com/css?family=Nunito:400,700" rel="stylesheet">
	<link id="sys-css" rel="stylesheet" href="{{ asset('plugins/css/errorpage.css') }}" />
</head>

<body>
	<div id="notfound">
		<div class="notfound">
			<div class="notfound-404"></div>
			<h1>501</h1>
			<h2>Oops! Database Error!</h2>
			<p>Sorry There is database issue.Please contact with Network team.</p>
			<a href="#">Back to homepage</a>
			<div style="display: none;"><?php //echo $exception->getMessage(); ?></div>
		</div>
	</div>
</body>
</html>
