<!DOCTYPE html>
<html lang="en">
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

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/styles/style.css') }}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>

    <style>
        body{
            font-family: Helvetica;
            font-size: 12px;
        }
        .invoice-box {
            width: 100%;
            padding-bottom: 0%!important;
        }
        .logo {
            flex: 1;
        }
        .amount-word {
            padding: .75rem;
        }
        .invoice-desc-footer {
            display: flex;
        }
        .summary {
            width: 50%;
            float: right;
            text-align: right !important;
        }
        .summary tr td {
            padding: 2px 0px!important;
            font-size: 12px;
            line-height: 1.71em;
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
            font-weight: 600;
            font-size: 12px;
        }
        .table td {
            font-size: 12px;
            font-weight: 500;
        }
    </style>
</head>
<body onload="window.print()">
    <div class="invoice-box" id="invoice-box">
        <div style="display: flex;width: 100%;margin-bottom: -1%">
            <div style="flex: 1; width: 100%;">
                <img src="{{ asset('assets/vendors/images/dot1.jpg') }}" alt="Dot Design">
            </div>
            <h4 style="float: right;" class="weight-600">Money Receipt</h4>
        </div>
        <div style="display: flex;width: 100%;">
            <div style="flex: 1; width: 100%">
                <p class="font-14 mb-5">Receipt No: <strong class="weight-600 font-18">{{ $payment->receipt_no }}</strong></p>
                <p class="font-14 mb-5">Name: <strong class="weight-600">{{ $payment->customer->name }}</strong></p>
                <p class="font-14 mb-5">Mobile: <strong class="weight-600">{{ $payment->customer->mobile }}</strong></p>
                <p class="font-14 mb-5">Date: <strong class="weight-600">{{ \Carbon\Carbon::parse($payment->created_at)->format('M j, Y')}}</strong></p>
                <p class="font-14 mb-5">Status: <strong class="weight-600 font-18">{{ $payment->status }}</strong></p>
            </div>
            <div style="flex: 1; width: 100%">
                <p class="font-12 mb-5" style="text-align: right">{{ Config::get('settings.company.name') }}</strong></p>
                <p class="font-12 mb-5" style="text-align: right">{{ Config::get('settings.company.email') }}</strong></p>
                <p class="font-12 mb-5" style="text-align: right">{{ Config::get('settings.company.mobile') }}</strong></p>
                <p class="font-12 mb-5" style="text-align: right">{{ Config::get('settings.company.city') }}</strong></p>
                <p class="font-12 mb-5" style="text-align: right">{{ Config::get('settings.company.address') }}</strong></p>
            </div>
        </div>

        <div class="invoice-desc" style="padding-top: -12%!important;">
            <table class="table table-bordered invoice-table">
                @if (!empty($payment->log))
                <thead>
                    <tr>
                        <th>Invoice No</th>
                        <th>Paid Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody class="my-body">
                    @foreach ($payment->log as $i=>$log)
                        <tr>
                            <td>{{ $log['invoiceNo'] }}</td>
                            <td>{{ $log['paidAmount'] }}</td>
                            <td>{{ $log['invoiceStatus'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
                @endif
                <thead class="invoice-desc-head clearfix">
                    <tr>
                        <th class="amount-word">In Word:</th>
                        <th colspan="2">{{ word_amount($payment->amount + $payment->adjust) }}</th>
                    </tr>
                </thead>
            </table>
        </div>

        @if ($payment->method == "Bank")
            <div class="row">
                <div class="col-md-12">
                    <table class="invoice-desc-body" style="width: 100%">
                        <tr>
                            <td>Bank Name</td>
                            <td>: {{ $payment->bank_details['name'] }}</td>
                            <td>Check Date</td>
                            <td>: {{ $payment->bank_details['check_date'] }}</td>
                        </tr>
                        <tr>
                            <td>Check No</td>
                            <td>: {{ $payment->bank_details['check_no'] }}</td>
                            <td>Check Amount</td>
                            <td>: {{ $payment->bank_details['check_amount'] }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        @endif

        <div class="row" style="display: flex">
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
                        <td>Created By</td>
                        <td>: {{ $payment->created_by }}</td>
                    </tr>
                    <tr>
                        <td>Received By</td>
                        <td>: {{ $payment->received_by }}</td>
                    </tr>
                    <tr>
                        <td>Remarks</td>
                        <td>: {{ $payment->payload }}</td>
                    </tr>
                </table>
            </div>
            <hr>
            <div class="col-md-4" style="flex: 1">
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
        <div style="position: relative">
            <p style="position: fixed; width:100%; text-align: center"> Powered By: AnalyticalJ (analyticalzahid@gmail.com)
            </p>
        </div>
    </div>
</body>
</html>