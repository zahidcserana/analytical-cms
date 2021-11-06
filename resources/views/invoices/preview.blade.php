    <div>
        <div class="invoice-wrap">
            <div class="invoice-box" id="invoice-box">
                <div class="invoice-header">
                    <div class="row logo">
                        <img class="col-md-4" src="{{ asset('assets/vendors/images/dot1.jpg') }}" alt="Dot Design">
                        <h4 class="col-md-8 text-right weight-600 pt-10">INVOICE</h4>
                    </div>
                </div>
                <div class="row pb-30">
                    <div class="col-md-6">
                        <p class="font-14 mb-5">Invoice No: <strong class="weight-600">{{ $invoice->invoice_no }}</strong></p>
                        <p class="font-14 mb-5">Name: <strong class="weight-600">{{ $invoice->customer->name }}</strong></p>
                        <p class="font-14 mb-5">Mobile: <strong class="weight-600">{{ $invoice->customer->mobile }}</strong></p>
                        <p class="font-14 mb-5">Date: <strong class="weight-600">{{ \Carbon\Carbon::parse($invoice->created_at)->format('M j, Y')}}</strong></p>
                        <p class="font-14 mb-5">Status: <strong class="weight-600">{{ $invoice->status }}</strong></p>
                    </div>
                    <div class="col-md-6">
                        <div class="text-right">
                            <p class="font-14 mb-5">{{ Config::get('settings.company.name') }}</strong></p>
                            <p class="font-14 mb-5">{{ Config::get('settings.company.email') }}</strong></p>
                            <p class="font-14 mb-5">{{ Config::get('settings.company.mobile') }}</strong></p>
                            <p class="font-14 mb-5">{{ Config::get('settings.company.city') }}</strong></p>
                            <p class="font-14 mb-5">{{ Config::get('settings.company.address') }}</strong></p>
                        </div>
                    </div>
                </div>

                <div class="invoice-desc pb-30">
                    <table class="table stripe hover nowrap">
                        @if ($invoice->invoiceItems->count() > 0)
                            <thead class="invoice-desc-head clearfix">
                                <tr>
                                    <th>Buyer</th>
                                    <th style="width: 10%">Style</th>
                                    <th style="width: 10%">Color</th>
                                    <th style="width: 20%" class="text-center">Size</th>
                                    <th style="width: 15%" class="text-center">Sq. Ins</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-right">Rate</th>
                                    <th class="text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="invoice-desc-body">
                                @foreach ($invoice->invoiceItems as $invoiceItem)
                                    <tr class="clearfix">
                                        <td>{{ $invoiceItem->buyer }}</td>
                                        <td>{{ $invoiceItem->style }}</td>
                                        <td>{{ $invoiceItem->color }}</td>
                                        <td class="text-center size-wl">{{ $invoiceItem->width }} &times; {{ $invoiceItem->length }}</td>
                                        <td class="text-center">{{ $invoiceItem->area }}</td>
                                        <td class="text-center">{{ $invoiceItem->quantity }}</td>
                                        <td class="text-right">{{ $invoiceItem->price }}</td>
                                        <td class="text-right">{{ $invoiceItem->amount }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @endif
                        <thead class="invoice-desc-head clearfix">
                            <tr>
                                <th>In Word:</th>
                                <th colspan="7" class="gross">{{ $invoice->gross }}</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="row invoice-desc-footer">
                        <div class="col-8">
                            <p>Delivery Date: {{ Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</p>
                            <p>Previouse Balance: {{ $invoice->customer->balance }}</p>
                        </div>
                        <div class="col-4">
                            <table class="summary text-right">
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
                                    <td>{{ $invoice->total - $invoice->paid }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-10">
                        <div class="col-md-6">
                            <span>&nbsp;&nbsp;{{ $invoice->created_by }}</span><br>
                            <span>-----------------</span><br>
                            <span>&nbsp;&nbsp;Created By</span>
                        </div>
                        <div class="col-md-6">
                            <span>&nbsp;&nbsp;{{ $invoice->received_by }}</span><br>
                            <span>-----------------</span><br>
                            <span>&nbsp;&nbsp;Received By</span>
                        </div>
                    </div>
                </div>
                <a href="{{ route('invoices.print', ['invoice' => $invoice->id]) }}" target="_blank" class="btn" data-bgcolor="#3d464d" data-color="#ffffff" style="color: rgb(255, 255, 255); background-color: rgb(61, 70, 77);"><i class="fa fa-print"></i> {{ __('Print') }}</a>
                <a href="{{ route('invoices.pdf', ['invoice' => $invoice->id]) }}" class="btn" data-bgcolor="#f46f30" data-color="#ffffff" style="color: rgb(255, 255, 255); background-color: rgb(244, 111, 48);"><i class="fa fa-download"></i> {{ __('Download') }}</a>
                <a href="{{ route('invoices.emailing', ['invoice' => $invoice->id]) }}" class="btn" data-bgcolor="#db4437" data-color="#ffffff" style="color: rgb(255, 255, 255); background-color: rgb(219, 68, 55);float: right;"><i class="fa fa-plane"></i> {{ __('Email') }}</a>
            </div>
        </div>
    </div>
    @push('scripts')
        <style>
            .gross {
                padding-left: 0!important;
            }
        </style>
    @endpush
