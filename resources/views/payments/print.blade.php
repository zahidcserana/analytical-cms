<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'AnalyticalJ - AMS') }}</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/vendors/images/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/vendors/images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/vendors/images/favicon-16x16.png') }}">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/styles/style.css') }}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>

    <style>
        body{
            font-family: Helvetica;
            font-size: 11px;
            line-height: 1.7em;
        }
        .invoice-box {
            width: 100%;
            padding-bottom: 0%!important;
        }
        .logo {
            flex: 1;
        }
        .invoice-desc-footer {
            display: flex;
        }
        .summary {
            width: 50%;
            float: right;
            text-align: right !important;
            font-size: 10px;
        }
        .invoice-table {
            width: 100% !important;
        }
        .my-body tr td {
            text-align: center;
        }
        .invoice-table th {
            text-align: center !important;
        }
        .table thead th {
            font-weight: 500;
            font-size: 12px;
        }
        .table td {
            font-size: 10px;
            font-weight: 400;
        }
        .font-10 {
            font-size: 10px;
        }
        .bank-details {
            padding-top: 5px;
            padding-bottom: 5px;
        }
        .invoice-desc-body {
            line-height: 20px;
        }
        .amount-word {
            font-size: 14px;
        }
        .bank-info {
            border: 1px solid black;
            padding-left: 1%;
            margin-left: 1px;
            margin-right: 1px;
        }
        .page-footer>table>tbody>tr>td {
            padding: 8px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #000;
        }
    </style>
</head>
<body onload="window.print()">
    <div class="invoice-box" id="invoice-box">
        <div style="display: flex;width: 100%">
            <div style="flex: 1; width: 100%;">
                <img src="{{ asset('assets/vendors/images/dot1.jpg') }}" alt="Dot Design">
            </div>
        </div>
        <div style="display: flex;width: 100%;margin-bottom: 10px;">
            <div style="flex: 1; width: 100%">
                <table class="invoice-desc-body" style="width: 100%">
                    <tr>
                        <td>Receipt No</td>
                        <td>: <strong style="font-size: 11px">{{ $payment->receipt_no }}</strong></td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td>: <strong>{{ $payment->customer->name }}</strong></td>
                    </tr>
                    <tr>
                        <td>Mobile</td>
                        <td>: {{ $payment->customer->mobile }}</td>
                    </tr>
                    <tr>
                        <td>Date</td>
                        <td>: {{ \Carbon\Carbon::parse($payment->created_at)->format('M j, Y')}}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>: <strong style="text-transform:uppercase">{{ $payment->status }}</strong></td>
                    </tr>
                </table>
            </div>
            <span class="weight-600 font-20" style="padding-top: 30px"><u>MONEY RECEIPT</u></span>
            <div style="flex: 1; width: 100%; text-align: right">
                <span class="font-10" style="text-align: right">{{ Config::get('settings.company.name') }}</strong></span><br>
                <span class="font-10" style="text-align: right">{{ Config::get('settings.company.email') }}</strong></span><br>
                <span class="font-10" style="text-align: right">{{ Config::get('settings.company.mobile') }}</strong></span><br>
                <span class="font-10" style="text-align: right">{{ Config::get('settings.company.city') }}</strong></span><br>
                <span class="font-10" style="text-align: right">{{ Config::get('settings.company.address') }}</strong></span>
            </div>
        </div>

        <div class="invoice-desc" style="padding-top: -12%!important;text-align: center">
            <p class="amount-word"><u><strong>In Word: &nbsp; {{ word_amount($payment->amount + $payment->adjust) }}</strong></u></p>
        </div>

        <div class="row mb-20" style="display: flex; border: 1px solid black;margin-left:1px;margin-right:1px">
            <div class="col-md-8" style="flex: 1">
                <table class="invoice-desc-body" style="width: 100%">
                    <tr>
                        <td>Payment Date</td>
                        <td>: {{ Carbon\Carbon::parse($payment->created_at)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td>Payment Method</td>
                        <td>: {{ $payment->method }}</td>
                    </tr>
                    <tr>
                        <td>Remarks</td>
                        <td>: {{ $payment->payload }}</td>
                    </tr>
                </table>
            </div>
            <hr>
            <div class="col-md-4" style="flex: 1;border-left: 1px solid black;">
                <table class="invoice-desc-body summary">
                    <tr>
                        <td>Total Dues:</td>
                        <td>{{ amount_with_symbol($payment->dues) }}</td>
                    </tr>
                    <tr>
                        <td>Collected:</td>
                        <td>{{ amount_with_symbol($payment->amount + $payment->adjust) }}</td>
                    </tr>
                    <tr>
                        <td>Net Dues:</td>
                        <td>{{ amount_with_symbol($payment->customer->balance) }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="bank-info">
            @if ($payment->method == "Bank")
                <div class="bank-details">
                    <table style="width: 100%">
                        <tr>
                            <td style="width: 50%"><strong>Bank Name: </strong>{{ $payment->bank_details['name'] }}</td>
                            <td style="width: 50%"><strong>Check Date: </strong>{{ $payment->bank_details['check_date'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>Check No: </strong>{{ $payment->bank_details['check_no'] }}</td>
                            <td><strong>Check Amount: </strong>{{ $payment->bank_details['check_amount'] }}</td>
                        </tr>
                    </table>
                </div>
            @endif
            <table style="width: 100%">
                <tr>
                    <td style="width: 50%">Created By: {{ $payment->created_by }}</td>
                    <td style="width: 50%">Received By: {{ $payment->received_by }}</td>
                </tr>
            </table>
        </div>

        <div style="position: relative" class="pt-30 page-footer">
            <table style="position: fixed; width:95%;" class="table table-responsive">
                <tr>
                    <td><strong>Print Date & Time:</strong> {{ Carbon\Carbon::now()->toDayDateTimeString() }}</td>
                    <td><strong>Powered By: </strong> {{ ENV('APP_NAME') }} (analyticalzahid@gmail.com)</td>
                    <td><strong>Page No: </strong>Page 1 of 1</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>