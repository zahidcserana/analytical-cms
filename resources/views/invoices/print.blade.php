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
        .amount-word {
            text-align: center;
            font-size: 11px !important;
        }
        .table-bordered th,
        .table-bordered td {
            border: 1px solid black !important;
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
                        <td>Invoice No</td>
                        <td>: <strong style="font-size: 11px">{{ $invoice->invoice_no }}</strong></td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td>: <strong>{{ $invoice->customer->name }}</strong></td>
                    </tr>
                    <tr>
                        <td>Mobile</td>
                        <td>: {{ $invoice->customer->mobile }}</td>
                    </tr>
                    <tr>
                        <td>Date</td>
                        <td>: {{ \Carbon\Carbon::parse($invoice->created_at)->format('M j, Y')}}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>: <strong style="text-transform:uppercase">{{ $invoice->status }}</strong></td>
                    </tr>
                </table>
            </div>
            <span class="weight-600 font-20" style="padding-top: 30px"><u>INVOICE/BILL</u></span>

            <div style="flex: 1; width: 100%; text-align: right">
                <span class="font-10" style="text-align: right">{{ Config::get('settings.company.name') }}</strong></span><br>
                <span class="font-10" style="text-align: right">{{ Config::get('settings.company.email') }}</strong></span><br>
                <span class="font-10" style="text-align: right">{{ Config::get('settings.company.mobile') }}</strong></span><br>
                <span class="font-10" style="text-align: right">{{ Config::get('settings.company.city') }}</strong></span><br>
                <span class="font-10" style="text-align: right">{{ Config::get('settings.company.address') }}</strong></span>
            </div>
        </div>

        <div class="invoice-desc">
            <table class="table table-bordered invoice-table">
                @if ($invoice->invoiceItems->count() > 0)
                    <thead>
                        <tr>
                            <th style="width: 15%">Buyer</th>
                            <th style="width: 25%">Style</th>
                            <th style="width: 5%">Color</th>
                            <th style="width: 20%">Size</th>
                            <th style="width: 15%">Sq. Ins</th>
                            <th style="width: 5%">Qty</th>
                            <th style="width: 5%">Rate</th>
                            <th style="width: 10%">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="my-body">
                        @foreach ($invoice->invoiceItems as $invoiceItem)
                            <tr>
                                <td>{{ $invoiceItem->buyer }}</td>
                                <td>{{ $invoiceItem->style }}</td>
                                <td>{{ $invoiceItem->color }}</td>
                                <td>{{ $invoiceItem->width }} &times; {{ $invoiceItem->length }}</td>
                                <td>{{ $invoiceItem->area }}</td>
                                <td>{{ $invoiceItem->quantity }}</td>
                                <td>{{ $invoiceItem->price }}</td>
                                <td>{{ $invoiceItem->amount }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="amount-word"><strong>In Word:</strong></td>
                            <td colspan="7"  style="text-align: left !important;font-size: 11px">{{ $invoice->gross }}</td>
                        </tr>
                    </tbody>
                @endif
            </table>
        </div>

        <div class="row" style="display: flex">
            <div class="col-md-8" style="flex: 1">
                <table class="invoice-desc-body" style="width: 100%">
                    <tr>
                        <td>Delivery Date</td>
                        <td>: {{ Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td>Previouse Balance</td>
                        <td>: {{ format_amount($invoice->customer->balance) }}</td>
                    </tr>
                    <tr>
                        <td>Created By</td>
                        <td>: {{ $invoice->created_by }}</td>
                    </tr>
                    <tr>
                        <td>Received By</td>
                        <td>: {{ $invoice->received_by }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-4" style="flex: 1">
                <table class="invoice-desc-body summary">
                    <tr>
                        <td>Sub Total:</td>
                        <td>{{ $invoice->sub_total }}</td>
                    </tr>
                    <tr>
                        <td>Discount:</td>
                        <td>{{ $invoice->discount }}</td>
                    </tr>
                    <tr>
                        <td>Total:</td>
                        <td>{{ $invoice->total }}</td>
                    </tr>
                    <tr>
                        <td>Paid/Adv:</td>
                        <td>{{ $invoice->paid }}</td>
                    </tr>
                    <tr>
                        <td>Balance/Due:</td>
                        <td>{{ $invoice->due }}</td>
                    </tr>
                </table>
            </div>
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