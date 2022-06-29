<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'AnalyticalJ - CMS') }}</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/vendors/images/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/vendors/images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/vendors/images/favicon-16x16.png') }}">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/styles/core.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/styles/icon-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/src/plugins/datatables/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/styles/style.css') }}">
    <style>
        .table thead th {
            font-weight: 600;
            font-size: 12px;
            border-bottom: 0;
            padding-left: 1rem;
        }
        .table td {
            font-size: 10px;
            font-weight: 500;
            padding: 0.5rem;
        }
    </style>
</head>
<body>
<div class="pd-ltr-20 xs-pd-20-10">
    <main>
        {{ $slot }}
    </main>
    <div class="text-center pd-20 mb-20 card-box">
        <p class="font-12"><strong>Print Date & Time:</strong> {{ Carbon\Carbon::now()->toDayDateTimeString() }},
            <strong>Powered By: </strong> {{ ENV('APP_NAME') }} ({{ Config::get('settings.company.email') }})</p>
    </div>
</div>
</body>
</html>
