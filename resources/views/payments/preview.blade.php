<div>
    <div class="invoice-wrap font-14 mb-5">
        <div class="invoice-box" id="invoice-box" style="width: auto;">
            <div class="invoice-header">
                <div class="row logo">
                    <img class="col-md-4" src="{{ asset('assets/vendors/images/dot1.jpg') }}" alt="Dot Design">
                </div>
            </div>
            <div class="row pb-10">
                <div class="col-md-5">
                    <p class="font-14 mb-5">Receipt No: <strong class="weight-600 font-18">{{ $payment->receipt_no }}</strong></p>
                    <p class="font-14 mb-5">Name: <strong class="weight-600">{{ $payment->customer->name }}</strong></p>
                    <p class="font-14 mb-5">Mobile: <strong class="weight-600">{{ $payment->customer->mobile }}</strong></p>
                    <p class="font-14 mb-5">Date: <strong class="weight-600">{{ \Carbon\Carbon::parse($payment->created_at)->format('M j, Y')}}</strong></p>
                    <p class="font-14 mb-5">Status: <strong class="weight-600 font-18">{{ $payment->status }}</strong></p>
                </div>
                <p class="font-18 col-md-3 pt-5">Money Receipt</p>
    
                <div class="col-md-4">
                    <div class="text-right">
                        <p class="font-14 mb-5">{{ Config::get('settings.company.name') }}</strong></p>
                        <p class="font-14 mb-5">{{ Config::get('settings.company.email') }}</strong></p>
                        <p class="font-14 mb-5">{{ Config::get('settings.company.mobile') }}</strong></p>
                        <p class="font-14 mb-5">{{ Config::get('settings.company.city') }}</strong></p>
                        <p class="font-14 mb-5">{{ Config::get('settings.company.address') }}</strong></p>
                    </div>
                </div>
            </div>
    
            <div class="invoice-desc pb-10">
                <table class="table stripe hover nowrap">
                    {{-- @if (!empty($payment->log))
                        <thead class="invoice-desc-head clearfix">
                            <tr>
                                <th>Invoice No</th>
                                <th>Paid Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="invoice-desc-body">
                            @foreach ($payment->log as $i=>$log)
                                <tr class="clearfix">
                                    <td>{{ $log['invoiceNo'] }}</td>
                                    <td>{{ $log['paidAmount'] }}</td>
                                    <td>{{ $log['invoiceStatus'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    @endif --}}
                    <thead class="invoice-desc-head clearfix">
                        <tr>
                            <th>In Word:</th>
                            <th colspan="2" class="gross">{{ word_amount($payment->amount + $payment->adjust) }}</th>
                        </tr>
                    </thead>
                </table>

                <div class="card">
                    <div class="card-body row invoice-desc-footer">
                        <div class="col-8">
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
                        <div class="col-4">
                            <table class="summary text-right">
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
                </div>

                @if ($payment->method == "Bank")
                    <div class="row invoice-desc-footer pt-3">
                        <div class="col-12">
                            <table class="invoice-desc-body" style="width: 100%;">
                                <tr>
                                    <td><strong>Bank Name</strong></td>
                                    <td>: {{ $payment->bank_details['name'] }}</td>
                                    <td><strong>Check Date</strong></td>
                                    <td>: {{ $payment->bank_details['check_date'] }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Check No</strong></td>
                                    <td>: {{ $payment->bank_details['check_no'] }}</td>
                                    <td><strong>Check Amount</strong></td>
                                    <td>: {{ $payment->bank_details['check_amount'] }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @endif
                <div class="text-center font-12 pt-5">Powered By: {{ ENV('APP_NAME') }} (analyticalzahid@gmail.com)</div>
            </div>
            <a href="{{ route('payments.print', ['payment' => $payment->id]) }}" target="_blank" class="btn" data-bgcolor="#3d464d" data-color="#ffffff" style="color: rgb(255, 255, 255); background-color: rgb(61, 70, 77);"><i class="fa fa-print"></i> {{ __('Print') }}</a>
        </div>
    </div>
</div>
