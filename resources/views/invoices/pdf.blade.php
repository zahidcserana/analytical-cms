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

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>

    <style>
        .invoice-box {
            height: inherit;
        }
        .address {
            display: flex;
        }
        .customer {
            flex: 1;
        }
        .company {
            text-align: right;
        }
        .invoice-table {
            width: 100%;
        }
        .invoice-header {
            display: flex;
        }
        .logo {
            flex: 1;
        }
        .header-string {
            text-align: left;
            padding: .75rem;
        }
        .header-quantity {
            text-align: center;
        }
        .header-amount {
            text-align: right;
        }
        .amount-word {
            padding: .75rem;
        }
        .invoice-desc-footer {
            display: flex;
        }
        .history {
            flex: 1;
            padding-top: 15px;
            width: 60%;
        }
        .summary {
            width: 100%;
        }
        .summary tr td {
            padding: 2px 0px!important;
            font-size: 14px;
            line-height: 1.71em;
        }
        .amount-div {
            text-align: right;
        }
        .gross {
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="invoice-box" id="invoice-box">
        <div class="invoice-header">
            <div class="logo text-center">
                <img src="{{ asset('assets/vendors/images/analyticalj.png') }}" alt="">
            </div>
        <h3 class="text-right mb-30 weight-600">INVOICE</h3>
        </div>
        <div class="address pb-30">
            <div class="customer col-md-6">
                <p class="font-14 mb-5">Invoice No: <strong class="weight-600">{{ $invoice->invoice_no }}</strong></p>
                <p class="font-14 mb-5">Name: <strong class="weight-600">{{ $invoice->customer->name }}</strong></p>
                <p class="font-14 mb-5">Mobile: <strong class="weight-600">{{ $invoice->customer->mobile }}</strong></p>
                <p class="font-14 mb-5">Date: <strong class="weight-600">{{ \Carbon\Carbon::parse($invoice->created_at)->format('M j, Y')}}</strong></p>
                <p class="font-14 mb-5">Status: <strong class="weight-600">{{ $invoice->status }}</strong></p>
            </div>
            <div class="company col-md-6">
                <p class="font-14 mb-5">{{ Config::get('settings.company.name') }}</strong></p>
                <p class="font-14 mb-5">{{ Config::get('settings.company.email') }}</strong></p>
                <p class="font-14 mb-5">{{ Config::get('settings.company.mobile') }}</strong></p>
                <p class="font-14 mb-5">{{ Config::get('settings.company.city') }}</strong></p>
                <p class="font-14 mb-5">{{ Config::get('settings.company.address') }}</strong></p>
            </div>
        </div>

        <div class="invoice-desc pb-30">
            <table class="invoice-table table">
                <thead class="invoice-desc-head clearfix">
                    <tr>
                        <th class="header-string">Buyer</th>
                        <th class="header-string">Style</th>
                        <th class="header-string">Color</th>
                        <th class="header-quantity">Size(l*w)</th>
                        <th class="header-quantity">Sq. Ins</th>
                        <th class="header-quantity">Quantity</th>
                        <th>Rate</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody class="invoice-desc-body">
                    @foreach ($invoice->invoiceItems as $invoiceItem)
                        <tr class="clearfix">
                            <td>{{ $invoiceItem->buyer }}</td>
                            <td>{{ $invoiceItem->style }}</td>
                            <td>{{ $invoiceItem->color }}</td>
                            <td class="header-quantity">{{ $invoiceItem->length }} * {{ $invoiceItem->width }}</td>
                            <td class="header-quantity">{{ $invoiceItem->area }}</td>
                            <td class="header-quantity">{{ $invoiceItem->quantity }}</td>
                            <td class="header-amount">{{ $invoiceItem->price }}</td>
                            <td class="header-amount">{{ $invoiceItem->amount }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <thead class="invoice-desc-head clearfix">
                    <tr>
                        <th class="amount-word">In Word:</th>
                        <th colspan="7" class="gross">{{ $invoice->gross }}</th>
                    </tr>
                </thead>
            </table>

            <div class="invoice-desc-footer">
                <div class="history">
                    <p class="font-14 mb-5">Delivery Date:</p>
                    <p class="font-14 mb-5">Previouse Balance:</p>
                </div>
                <div class="invoice-desc" style="width: 40%">
                    <table class="invoice-desc-body summary text-right">
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
                            <td class="amount-div">{{ $invoice->total - $invoice->paid }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>