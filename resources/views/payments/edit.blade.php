<x-app-layout>
    <div class="min-height-200px">
        <div class="card-box mb-30">
            <div class="pd-20 clearfix">
                <h4 class="text-blue h4 pull-left">Payment Update</h4>
                <a href="{{ route('payments.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-left"></i> Back </a>
            </div>
            <div class="pd-20">
                @include("layouts.alert")
                <form method="post" action="{{ route('payments.update', ['payment' => $payment]) }}" autocomplete="off" novalidate>
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $payment->id }}">
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Customer</label>
                        <div class="col-sm-12 col-md-4">
                            <select class="custom-select col-12" name="customer_id">
                                <option value="">-Select-</option>
                                @foreach ($customers as $customer)
                                    <option {{ $payment->customer_id == $customer->id ? "selected='selected'" : '' }} value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-sm-12 col-md-2 col-form-label">Amount</label>
                        <div class="col-sm-12 col-md-4">
                            <input class="form-control" placeholder="Amount" type="text" name="amount" value="{{ $payment->amount }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Payment Method</label>
                        <div class="col-sm-12 col-md-4">
                            <select class="custom-select col-12" name="method">
                                <option value="">-Select-</option>
                                @foreach (Config::get('settings.paymentMethod') as $key => $value)
                                    <option {{ $payment->method == $key ? "selected='selected'" : '' }} value="{{ $key }}">{{ $key }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-sm-12 col-md-2 col-form-label">Status</label>
                        <div class="col-sm-12 col-md-4">
                            <select class="custom-select col-12" name="status">
                                <option value="">-Select-</option>
                                <option {{ $payment->status == 'pending' ? "selected='selected'" : '' }} value="pending">Pending</option>
                                <option {{ $payment->status == 'adjust' ? "selected='selected'" : '' }} value="adjust">Adjust</option>
                                <option {{ $payment->status == 'advanced' ? "selected='selected'" : '' }} value="advanced">Advanced</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Remarks</label>
                        <div class="col-sm-12 col-md-10">
                            <textarea class="form-control" name="payload" placeholder="Payload" value="{{ $payment->payload }}">{{ $payment->payload }}</textarea>
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
</x-app-layout>
