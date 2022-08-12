<x-app-layout>
    <div class="min-height-200px">
        <div class="card-box mb-30">
            <div class="pd-20 clearfix">
                <h4 class="text-title h4 pull-left">Payment List</h4>
                <form class="pull-right" method="GET" action="{{ route('reports.payments', ['print' => 'print']) }}">
                    <input type="hidden" name="status" value="{{ $query['status'] ?? '' }}">
                    <input type="hidden" name="customer_id" value="{{ $query['customer_id'] ?? '' }}">
                    <input type="hidden" name="method" value="{{ $query['method'] ?? '' }}">
                    <input type="hidden" name="daterange" value="{{ $query['daterange'] ?? '' }}">
                    <button type="submit" class="btn btn-success mb-2 mr-sm-2"><i class="fa fa-file-pdf-o"></i> {{ __('Print') }}</button>
                </form>
            </div>
            <div class="pb-20" style="padding: 0% 1%;">
                <div class="row">
                    <div class="col-md-8">
                        <form class="form-inline" method="GET" action="{{ route('reports.payments') }}">
                            <input type="hidden" name="status" value="{{ $query['status'] ?? '' }}">
                            <select class="customer-select2 custom-select mb-2 mr-sm-2" name="customer_id" data-customer-id="{{ $_GET['customer_id'] ?? '' }}"></select>
                            <select class="custom-select mb-2 mr-sm-2" name="method" style="margin-left: 7px;">
                                <option value="">-- Method --</option>
                                @foreach (Config::get('settings.paymentMethod') as $key => $value)
                                <option {{ !empty($query['method']) && $query['method'] == $key ? "selected='selected'" : '' }} value="{{ $key }}">{{ $key }}</option>
                                @endforeach
                            </select>
                            <div class="input-group mb-2 mr-sm-2">
                                <input value="{{ $query['daterange'] ?? '' }}" class="form-control datetimepicker-range" name="daterange" placeholder="Select Month" type="text" autocomplete="off">
                            </div>
                            <button type="submit" class="btn mb-2 mr-sm-2" data-bgcolor="#c32361" data-color="#ffffff"><i class="fa fa-search"></i> {{ __('Search') }}</button>
                            <a href="{{ route('reports.payments') }}" class="btn mb-2" data-bgcolor="#f46f30" data-color="#ffffff"><i class="fa fa-refresh"></i> {{ __('Reset') }}</a>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <table class="table table-striped table-info">
                            <thead>
                                <tr>
                                    <th>Total Payment</th>
                                    <th>Collected</th>
                                    <th>Adjust</th>
                                    <th>Remaining</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $payments->count() }}</td>
                                    <td>{{ $summary['amount'] + $summary['adjust'] }}</td>
                                    <td>{{ $summary['adjust'] }}</td>
                                    <td>{{ $summary['amount'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Receipt No</th>
                            <th>Customer</th>
                            <th>Method</th>
                            <th>Collected</th>
                            <th>Adjust</th>
                            <th>Remaining</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $i => $row)
                        <tr>
                            <td>{{ $row->receipt_no }}</td>
                            <td>{{ $row->customer->name }}</td>
                            <td>{{ $row->method }}</td>
                            <td>{{ $row->amount + $row->adjust }}</td>
                            <td>{{ (int) $row->adjust }}</td>
                            <td>{{ (int) $row->amount }}</td>
                            <td><span class="badge {{ status_class($row->status) }}">{{ status($row->status) }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        new Payment();

    </script>
    @endpush
</x-app-layout>

<style>
    .select2-container {
        box-sizing: border-box;
        display: inline-block;
        margin: 0;
        position: relative;
        vertical-align: middle;
        width: 20% !important;
    }

</style>
