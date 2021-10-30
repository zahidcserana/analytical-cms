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
            font-family: Myriad Pro;
            font-size: 13pt;
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
            width: 100%;
            text-align: right !important;
        }
        .summary tr td {
            padding: 2px 0px!important;
            font-size: 14px;
            line-height: 1.71em;
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
            <div style="flex: 1; width: 100%">
                <img style="padding-top: 2%;" src="https://scontent.fdac17-1.fna.fbcdn.net/v/t1.15752-9/243529074_385207316681142_5232001197312670516_n.jpg?_nc_cat=100&ccb=1-5&_nc_sid=ae9488&_nc_ohc=Yn0Wd5WgKjIAX_cFOpN&_nc_ht=scontent.fdac17-1.fna&oh=35e3bce0376bc1e637e3dcfe9a30f6ce&oe=619692DD" alt="Dot Design">
            </div>
            <div class="text-right" style="flex: 1; width: 100%">
                <h3 style="text-align: right;" class="weight-600">INVOICE</h3>
            </div>
        </div>
        <div style="display: flex;width: 100%;">
            <div style="flex: 1; width: 100%">
                <p class="font-14 mb-5">Invoice No: <strong class="weight-600">{{ $invoice->invoice_no }}</strong></p>
                <p class="font-14 mb-5">Name: <strong class="weight-600">{{ $invoice->customer->name }}</strong></p>
                <p class="font-14 mb-5">Mobile: <strong class="weight-600">{{ $invoice->customer->mobile }}</strong></p>
                <p class="font-14 mb-5">Date: <strong class="weight-600">{{ \Carbon\Carbon::parse($invoice->created_at)->format('M j, Y')}}</strong></p>
                <p class="font-14 mb-5">Status: <strong class="weight-600">{{ $invoice->status }}</strong></p>
            </div>
            <div style="flex: 1; width: 100%">
                <p class="font-14 mb-5" style="text-align: right">{{ Config::get('settings.company.name') }}</strong></p>
                <p class="font-14 mb-5" style="text-align: right">{{ Config::get('settings.company.email') }}</strong></p>
                <p class="font-14 mb-5" style="text-align: right">{{ Config::get('settings.company.mobile') }}</strong></p>
                <p class="font-14 mb-5" style="text-align: right">{{ Config::get('settings.company.city') }}</strong></p>
                <p class="font-14 mb-5" style="text-align: right">{{ Config::get('settings.company.address') }}</strong></p>
            </div>
        </div>

        <div class="invoice-desc" style="padding-top: -10%!important;">
            <table class="table table-bordered invoice-table">
                @if ($invoice->invoiceItems->count() > 0)
                    <thead class="">
                        <tr>
                            <th style="width: 15%">Buyer</th>
                            <th style="width: 10%">Style</th>
                            <th style="width: 10%">Color</th>
                            <th style="width: 20%">Size</th>
                            <th style="width: 15%">Sq. Ins</th>
                            <th style="width: 10%">Quantity</th>
                            <th style="width: 10%">Rate</th>
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
                    </tbody>
                @endif
                <thead class="invoice-desc-head clearfix">
                    <tr>
                        <th class="amount-word">In Word:</th>
                        <th colspan="7"  style="text-align: left !important;">{{ $invoice->gross }}</th>
                    </tr>
                </thead>
            </table>

            <div class="invoice-desc-footer" style="display: flex;width: 100%">
                <div style="flex: 1;width:100%">
                    <p class="font-14 mb-5">Delivery Date: {{ Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</p>
                    <p class="font-14 mb-5">Previouse Balance: {{ $invoice->customer->balance }}</p>
                </div>
                <div class="invoice-desc" style="flex: 1;width:100%">
                    <table class="invoice-desc-body summary">
                        <tr>
                            <td>Sub Total:</td>
                            <td class="amount-div">{{ $invoice->sub_total }}</td>
                        </tr>
                        <tr>
                            <td>Discount:</td>
                            <td class="amount-div">{{ $invoice->discount }}</td>
                        </tr>
                        <tr>
                            <td>Total:</td>
                            <td class="amount-div">{{ $invoice->total }}</td>
                        </tr>
                        <tr>
                            <td>Paid/Adv:</td>
                            <td class="amount-div">{{ $invoice->paid }}</td>
                        </tr>
                        <tr>
                            <td>Balance/Due:</td>
                            <td class="amount-div">{{ number_format(($invoice->total - $invoice->paid), 2, '.', ',') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div>
            <p style="text-align: center;font-size: 12px;">Powered by <a href="https://analyticalj.com">AnalyticalJ (analyticalzahid@gmail.com)</a></p>
        </div>
    </div>
</body>
</html>