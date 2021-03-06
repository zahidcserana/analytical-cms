<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'AnalyticalJ - CMS') }}</title>

	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="assets/vendors/images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="assets/vendors/images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="assets/vendors/images/favicon-16x16.png">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="assets/vendors/styles/core.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/styles/style.css">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-119386393-1');
	</script>
</head>
<body class="login-page">
	<div class="login-header box-shadow">
		<div class="container-fluid d-flex justify-content-between align-items-center">
			<div class="brand-logo">
				<a href="{{ route('dashboard') }}">
					<img src="{{ asset(Config::get('settings.company.images.header')) }}" alt="">
				</a>
			</div>
		</div>
	</div>
	<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
		{{ $slot }}
	</div>
	<!-- js -->
	<script src="assets/vendors/scripts/core.js"></script>
	<script src="assets/vendors/scripts/script.min.js"></script>
	<script src="assets/vendors/scripts/process.js"></script>
	<script src="assets/vendors/scripts/layout-settings.js"></script>
</body>
</html>
