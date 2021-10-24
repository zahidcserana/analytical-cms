<x-app-layout>
    <div class="min-height-200px">
        <div class="card-box mb-30">
            <div class="pd-20 clearfix">
                <h4 class="text-title h4 pull-left">Payment List</h4>
                <a href="{{ route('payments.create') }}" class="btn btn-info pull-right"><i class="fa fa-plus-circle"></i> New </a>

            </div>
            <div class="pb-20 search-table">
                <form class="form-inline" method="GET" action="{{ route('payments.index') }}">
                    <select class="form-control mb-2 mr-sm-2" name="customer_id">
                        <option value="">-- Select Customer --</option>
                        @foreach ($customers as $customer)
                            <option {{ !empty($query['customer_id']) && $query['customer_id'] == $customer->id ? 'selected="selected"':'' }} value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                    <select class="form-control mb-2 mr-sm-2" name="method">
                        <option value="">-Select Method-</option>
                        @foreach (Config::get('settings.paymentMethod') as $key => $value)
                            <option {{ (!empty($query['method']) && ($query['method'] == $key)) ? "selected='selected'" : '' }} value="{{ $key }}">{{ $key }}</option>
                        @endforeach
                    </select>
                    <select class="custom-select mb-2 mr-sm-2" name="status">
                        <option value="">-- Select Status --</option>
                        <option {{ (!empty($query['status']) && ($query['status'] == 'pending')) ? "selected='selected'" : '' }} value="pending">Pending</option>
                        <option {{ (!empty($query['status']) && ($query['status'] == 'adjusted')) ? "selected='selected'" : '' }} value="adjusted">Adjusted</option>
                        <option {{ (!empty($query['status']) && ($query['status'] == 'advanced')) ? "selected='selected'" : '' }} value="advanced">Advanced</option>
                    </select>
                    <div class="input-group mb-2 mr-sm-2">
                        <input value="{{ $query['daterange'] ?? '' }}" class="form-control datetimepicker-range" name="daterange" placeholder="Select Month" type="text" autocomplete="off">
                    </div>
                    <button type="submit" class="btn mb-2 mr-sm-2" data-bgcolor="#c32361" data-color="#ffffff"><i class="fa fa-search"></i> {{ __('Search') }}</button>
                    <a href="{{ route('payments.index') }}" class="btn mb-2" data-bgcolor="#f46f30" data-color="#ffffff"><i class="fa fa-refresh"></i> {{ __('Reset') }}</a>
                </form>
                <table class="table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th class="table-plus datatable-nosort">Sl</th>
                            <th>Customer</th>
                            <th>Method</th>
                            <th>Paid</th>
                            <th>Adjust</th>
                            <th>Remaining</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th class="datatable-nosort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $i=>$row)
                        <tr>
                            <td class="table-plus">{{ $i + 1 }}</td>
                            <td>{{ $row->customer->name }}</td>
                            <td>{{ $row->method }}</td>
                            <td>{{ $row->amount + $row->adjust }}</td>
                            <td>{{ (int)$row->adjust }}</td>
                            <td>{{ (int)$row->amount }}</td>
                            <td><span class="badge {{ status_class($row->status) }}">{{ $row->status }}</span></td>
                            <td>{{ $row->payload }}</td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                        <i class="dw dw-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                        <a class="dropdown-item" href="{{route('payments.edit', ['payment' => $row->id])}}"><i class="dw dw-edit2"></i> Edit</a>
                                        @if ($row->status != 'adjusted')
                                            <a class="dropdown-item" href="{{route('payments.adjust', ['payment' => $row->id])}}"><i class="dw dw-analytics1"></i> Adjust</a>
                                        @endif
                                        @include('layouts.utils.delete',array( 'url' => route('payments.destroy', ['payment' => $row->id]), 'class'=>'dropdown-item','text' => "<i class='dw dw-delete-3'></i>Delete"))
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="my-pagination">
                    {!! $payments->links() !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>