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
            font-family: Myriad Pro;
            font-size: 13pt;
            padding: 0%!important;
        }
        .invoice-box {
            width: 80%;
            padding-bottom: 0%!important;
            padding-right: 5% !important;
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
        .summary td {
            font-weight: bold !important;
        }
        .amount-div {
            text-align: right;
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
    </style>
</head>
<body>
    <div class="invoice-box" id="invoice-box">
        <div style="display: flex;width: 100%;padding-bottom: -5%!important;">
            <div style="flex: 1; width: 100%;padding-top: 2%">
                <img src="{{ asset('assets/vendors/images/dot1.jpg') }}" alt="Dot Design">
            </div>
            <div class="text-right" style="flex: 1; width: 100%">
                <h3 style="text-align: right;" class="weight-600">DUE INVOICE</h3>
            </div>
        </div>
        <div style="display: flex;width: 100%;margin-bottom: 10px;">
            <div style="flex: 1; width: 100%">
                <p class="font-14 mb-5">Name: <strong class="weight-600">{{ $customer->name }}</strong></p>
                <p class="font-14 mb-5">Mobile: <strong class="weight-600">{{ $customer->mobile }}</strong></p>
            </div>
            <div style="flex: 1; width: 100%; text-align: right">
                <p class="font-14 mb-5" style="text-align: right">{{ Config::get('settings.company.name') }}</strong></p>
                <p class="font-14 mb-5" style="text-align: right">{{ Config::get('settings.company.email') }}</strong></p>
                <p class="font-14 mb-5" style="text-align: right">{{ Config::get('settings.company.mobile') }}</strong></p>
                <p class="font-14 mb-5" style="text-align: right">{{ Config::get('settings.company.city') }}</strong></p>
                <p class="font-14 mb-5" style="text-align: right">{{ Config::get('settings.company.address') }}</strong></p>
            </div>
        </div>

        <div class="invoice-desc">
            @if ($invoices->count() > 0)
                <table class="table table-bordered invoice-table">
                    <thead>
                        <tr>
                            <th># No</th>
                            <th>Date</th>
                            <th>Subtotal</th>
                            <th>Discount</th>
                            <th>Amount</th>
                            <th>Paid</th>
                            <th>Due</th>
                        </tr>
                    </thead>
                    <tbody class="my-body">
                        @foreach ($invoices as $row)
                            <tr>
                                <td>{{ $row->invoice_no }}</td>
                                <td> {{ Carbon\Carbon::parse($row->invoice_date)->format('d/m/Y') }} </td>
                                <td>{{ $row->sub_total }}</td>
                                <td>{{ $row->discount }}</td>
                                <td>{{ $row->total }}</td>
                                <td>{{ $row->paid }}</td>
                                <td>{{ number_format(($row->total - $row->paid), 2, '.', ',') }}</td>
                            </tr>
                        @endforeach
                        <tr class="amount-word summary">
                            <td colspan="2"><strong>Total</strong></td>
                            <td>{{ $summary['sub_total'] }}</td>
                            <td>{{ $summary['discount'] }}</td>
                            <td>{{ $summary['total'] }}</td>
                            <td>{{ $summary['paid'] }}</td>
                            <td>{{ $summary['total'] - $summary['paid'] }}</td>
                        </tr>
                    </tbody>
                    <thead class="invoice-desc-head">
                        <tr>
                            <th>Total Due:</th>
                            <th colspan="6"  style="text-align: left !important;">{{ word_amount($summary['total'] - $summary['paid']) }}</th>
                        </tr>
                    </thead>
                </table>
            @endif
        </div>
        <div>
            <p style="text-align: center;font-size: 12px;">Powered by <a href="{{ Config::get('settings.website') }}">AnalyticalJ (analyticalzahid@gmail.com)</a></p>
        </div>
    </div>
</body>
</html>
