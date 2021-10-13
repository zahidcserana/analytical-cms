<x-app-layout>
    <div class="min-height-200px">
        <div class="card-box mb-30">
            <div class="pd-20 clearfix">
                <h4 class="text-blue h4 pull-left">Invoice List</h4>
                <a href="{{ route('invoices.create') }}" class="btn btn-info pull-right"><i class="fa fa-plus-circle"></i> New </a>

            </div>
            <div class="pb-20" style="padding: 0% 1%;">
                <div class="row">
                    <div class="col-7">
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
                    <div class="col-5">
                        <table class="table table-striped table-info">
                            <thead>
                                <tr>
                                    <th>Total</th>
                                    <th>Discount</th>
                                    <th>Payable</th>
                                    <th>Paid</th>
                                    <th>Due</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $summary['total'] }}</td>
                                    <td>{{ $summary['discount'] }}</td>
                                    <td>{{ $summary['payable'] }}</td>
                                    <td>{{ $summary['paid'] }}</td>
                                    <td>{{ $summary['due'] }}</td>
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
                            <th>Total</th>
                            <th>Discount</th>
                            <th>Payable</th>
                            <th>Paid</th>
                            <th>Due</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $row)
                        <tr>
                            <td>{{ $row->invoice_no }}</td>
                            <td>{{ $row->customer->name }}</td>
                            <td>{{ $row->total }}</td>
                            <td>{{ $row->discount }}</td>
                            <td>{{ $row->total - $row->discount }}</td>
                            <td>{{ $row->paid }}</td>
                            <td>{{ ($row->total - $row->discount) - $row->paid }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>