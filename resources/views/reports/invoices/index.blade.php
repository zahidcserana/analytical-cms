<x-app-layout>
    <div class="min-height-200px">
        <div class="card-box mb-30">
            <div class="pd-20 clearfix">
                <h4 class="text-title h4 pull-left">Invoice List</h4>
                <a href="{{ route('invoices.create') }}" class="btn btn-info pull-right"><i class="fa fa-plus-circle"></i> New </a>
            </div>
            <div class="pb-20" style="padding: 0% 1%;">
                <div class="row">
                    <div class="col-md-7">
                        <form class="form-inline" method="GET" action="{{ route('reports.invoices') }}">
                            <input type="hidden" name="status" value="{{ $query['status'] ?? '' }}">
                            <select class="form-control mb-2 mr-sm-2" name="customer_id">
                                <option value="">-- Select Customer --</option>
                                @foreach ($customers as $customer)
                                    <option {{ !empty($query['customer_id']) && $query['customer_id'] == $customer->id ? 'selected="selected"':'' }} value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                            <div class="input-group mb-2 mr-sm-2">
                                <input value="{{ $query['daterange'] ?? '' }}" class="form-control datetimepicker-range" name="daterange" placeholder="Select Month" type="text" autocomplete="off">
                            </div>
                            <button type="submit" class="btn mb-2 mr-sm-2" data-bgcolor="#c32361" data-color="#ffffff"><i class="fa fa-search"></i> {{ __('Search') }}</button>
                            <a href="{{ route('reports.invoices', ['status' => $query['status'] ?? '']) }}" class="btn mb-2" data-bgcolor="#f46f30" data-color="#ffffff"><i class="fa fa-refresh"></i> {{ __('Reset') }}</a>
                        </form>
                    </div>
                    <div class="col-1">
                        <a href="#" class="btn" data-toggle="modal" data-target="#invoices-modal" data-bgcolor="#f46f30" data-color="#ffffff"><i class="fa fa-download"></i> {{ __('Preview') }}</a>
                    </div>
                    <div class="col-md-4">
                        <table class="table table-striped table-info">
                            <thead>
                                <tr>
                                    <th>Subtotal</th>
                                    <th>Discount</th>
                                    <th>Amount</th>
                                    <th>Paid</th>
                                    <th>Due</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $summary['sub_total'] }}</td>
                                    <td>{{ $summary['discount'] }}</td>
                                    <td>{{ $summary['total'] }}</td>
                                    <td>{{ $summary['paid'] }}</td>
                                    <td>{{ $summary['total'] - $summary['paid'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <table class="table stripe hover nowrap">
                    <thead class="my-table-header">
                        <tr>
                            <th>Invoice No</th>
                            <th>Customer</th>
                            <th>Subtotal</th>
                            <th>Discount</th>
                            <th>Amount</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $row)
                        <tr>
                            <td>{{ $row->invoice_no }}</td>
                            <td>{{ $row->customer->name }}</td>
                            <td>{{ $row->sub_total }}</td>
                            <td>{{ $row->discount }}</td>
                            <td>{{ $row->total }}</td>
                            <td>{{ $row->paid }}</td>
                            <td>{{ number_format(($row->total - $row->paid), 2, '.', ',') }}</td>
                            <td><span class="badge {{ status_class($row->status) }}">{{ $row->status }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-lg" id="invoices-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Due Invoices</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <table class="table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th>Invoice No</th>
                                <th>Customer</th>
                                <th>Subtotal</th>
                                <th>Discount</th>
                                <th>Amount</th>
                                <th>Paid</th>
                                <th>Due</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $row)
                            <tr>
                                <td>{{ $row->invoice_no }}</td>
                                <td>{{ $row->customer->name }}</td>
                                <td>{{ $row->sub_total }}</td>
                                <td>{{ $row->discount }}</td>
                                <td>{{ $row->total }}</td>
                                <td>{{ $row->paid }}</td>
                                <td>{{ number_format(($row->total - $row->paid), 2, '.', ',') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('customers.invoices', ['customer' => $customer->id]) }}" class="btn" data-bgcolor="#db4437" data-color="#ffffff" style="color: rgb(255, 255, 255); background-color: rgb(219, 68, 55);float: right;"><i class="fa fa-plane"></i> {{ __('Email') }}</a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <style>
        .table td {
            font-size: 14px;
            font-weight: 500;
            padding: .5rem 1rem!important;
        }
        </style>
    @endpush
</x-app-layout>