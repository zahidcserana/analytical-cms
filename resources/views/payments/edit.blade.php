<x-app-layout>
    <div class="min-height-200px">
        <div class="card-box mb-30">
            <div class="pd-20 clearfix">
                <h4 class="text-title h4 pull-left">Payment Update</h4>
                <a href="{{ route('payments.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-left"></i> Back </a>
            </div>
            <div class="pd-20">
                <form method="post" action="{{ route('payments.update', ['payment' => $payment]) }}" autocomplete="off" novalidate>
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $payment->id }}">
                    <input type="hidden" name="customer_id" value="{{ $payment->customer_id }}">
                    <input type="hidden" name="method" value="{{ $payment->method }}">
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Customer</label>
                        <div class="col-sm-12 col-md-4">
                            <p class="form-control-plaintext">{{ $payment->customer->name }}</p>
                        </div>
                        <label class="col-sm-12 col-md-2 col-form-label">Status</label>
                        <div class="col-sm-12 col-md-4">
                            <p class="form-control-plaintext">{{ $payment->status }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Payment Method</label>
                        <div class="col-sm-12 col-md-4">
                            <p class="form-control-plaintext">{{ $payment->method }}</p>
                        </div>
                        <label class="col-sm-12 col-md-2 col-form-label">Amount</label>
                        <div class="col-sm-12 col-md-4">
                            <input class="form-control" placeholder="Amount" type="text" name="amount" value="{{ $payment->amount }}">
                        </div>
                    </div>
                    @if ($payment->method == "Bank")
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Bank Details</label>
                            <div class="col-sm-12 col-md-3">
                                <input class="form-control" placeholder="Bank Name" type="text" name="bank_details[name]" value="{{ $payment->bank_details['name'] }}">
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <input class="form-control" placeholder="Check No" type="text" name="bank_details[check_no]" value="{{ $payment->bank_details['check_no'] }}">
                            </div>
                            <div class="col-sm-12 col-md-2">
                                <input class="form-control" placeholder="Check Date" type="text" name="bank_details[check_date]" value="{{ $payment->bank_details['check_date'] }}">
                            </div>
                            <div class="col-sm-12 col-md-2">
                                <input class="form-control" placeholder="Check Amount" type="text" name="bank_details[check_amount]" value="{{ $payment->bank_details['check_amount'] }}">
                            </div>
                        </div>
                    @endif
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Created By</label>
                        <div class="col-sm-12 col-md-4">
                            <input class="form-control" placeholder="Created By" type="text" name="created_by" value="{{ $payment->created_by }}">
                        </div>
                        <label class="col-sm-12 col-md-2 col-form-label">Received By</label>
                        <div class="col-sm-12 col-md-4">
                            <input class="form-control" placeholder="Received By" type="text" name="received_by" value="{{ $payment->received_by }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Remarks</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" placeholder="Remarks" type="text" name="payload" value="{{ $payment->payload }}">
                        </div>
                    </div>
                    <div class="text-center">
                        <x-button class="btn btn-primary">{{ __('Save') }}</x-button>
                    </div>
                </form>
            </div>
            @if (!empty($payment->log))
                <div class="payment-log">
                    <table class="table stripe hover nowrap">
                        <caption style="text-align: center;caption-side: top">
                            <h5 class="pb-2">Payment log</h5>
                        </caption>
                        <thead>
                            <tr>
                                <th class="table-plus datatable-nosort">Sl</th>
                                <th>Invoice No</th>
                                <th>Paid Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payment->log as $i=>$log)
                            <tr>
                                <td class="table-plus">{{ $i + 1 }}</td>
                                <td>{{ $log['invoiceNo'] }}</td>
                                <td>{{ $log['paidAmount'] }}</td>
                                <td>{{ $log['invoiceStatus'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    @push('scripts')
        <script>
            new Payment();
        </script>
    @endpush
</x-app-layout>
