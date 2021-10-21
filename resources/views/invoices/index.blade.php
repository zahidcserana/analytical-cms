<x-app-layout>
    <div class="min-height-200px">
        <div class="card-box mb-30">
            <div class="pd-20 clearfix">
                <h4 class="text-blue h4 pull-left">Invoice List</h4>
                <a href="{{ route('invoices.create') }}" class="btn btn-info pull-right"><i class="fa fa-plus-circle"></i> New </a>

            </div>
            <div class="pb-20 search-table">
                <form class="form-inline" method="GET" action="{{ route('invoices.index') }}">
                    <div class="form-group mb-2 mr-sm-2">
                        <input type="text" class="form-control" name="invoice_no" placeholder="Invoice No" value="{{ $query['invoice_no'] ?? '' }}">
                      </div>
                    <select class="form-control mb-2 mr-sm-2" name="customer_id">
                        <option value="">-- Select Customer --</option>
                        @foreach ($customers as $customer)
                            <option {{ !empty($query['customer_id']) && $query['customer_id'] == $customer->id ? 'selected="selected"':'' }} value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                    <select class="custom-select mb-2 mr-sm-2" name="status">
                        <option value="">-- Select Status --</option>
                        <option {{ (!empty($query['status']) && ($query['status'] == 'pending')) ? "selected='selected'" : '' }} value="pending">Pending</option>
                        <option {{ (!empty($query['status']) && ($query['status'] == 'paid')) ? "selected='selected'" : '' }} value="paid">Paid</option>
                        <option {{ (!empty($query['status']) && ($query['status'] == 'due')) ? "selected='selected'" : '' }} value="due">Due</option>
                    </select>
                    <div class="input-group mb-2 mr-sm-2">
                        <input value="{{ $query['daterange'] ?? '' }}" class="form-control datetimepicker-range" name="daterange" placeholder="Select Month" type="text" autocomplete="off">
                    </div>
                    <button type="submit" class="btn mb-2 mr-sm-2" data-bgcolor="#c32361" data-color="#ffffff"><i class="fa fa-search"></i> {{ __('Search') }}</button>
                    <a href="{{ route('invoices.index') }}" class="btn mb-2" data-bgcolor="#f46f30" data-color="#ffffff"><i class="fa fa-refresh"></i> {{ __('Reset') }}</a>
                </form>
                @include("layouts.alert")

                <table class="table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th class="table-plus datatable-nosort">Invoice/Bill</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Subtotal</th>
                            <th>Discount</th>
                            <th>Amount</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Status</th>
                            <th class="datatable-nosort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $row)
                        <tr>
                            <td class="table-plus">
                                <a href="{{route('invoices.edit', ['invoice' => $row->id])}}">{{ $row->invoice_no }}</a>
                            </td>
                            <td> {{ Carbon\Carbon::parse($row->invoice_date)->format('d/m/Y') }} </td>
                            <td>{{ $row->customer->name }}</td>
                            <td>{{ $row->sub_total }}</td>
                            <td>{{ $row->discount }}</td>
                            <td>{{ $row->total }}</td>
                            <td>{{ $row->paid }}</td>
                            <td>{{ $row->total - $row->paid }}</td>
                            <td><span class="badge {{ status_class($row->status) }}">{{ $row->status }}</span></td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                        <i class="dw dw-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="preview({{ $row->id }})"><i class="dw dw-eye"></i> Preview</a>
                                        <a class="dropdown-item" href="{{route('invoices.pdf', ['invoice' => $row->id])}}" target="_blank"><i class="dw dw-print"></i> Print</a>
                                        <a class="dropdown-item" href="{{route('invoices.emailing', ['invoice' => $row->id])}}"><i class="dw dw-email"></i> Email</a>
                                        <a class="dropdown-item" href="{{route('invoices.edit', ['invoice' => $row->id])}}"><i class="dw dw-edit2"></i> Edit</a>
                                        @include('layouts.utils.delete',array( 'url' => route('invoices.destroy', ['invoice' => $row->id]), 'class'=>'dropdown-item','text' => "<i class='dw dw-delete-3'></i>Delete"))
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="my-pagination">
                    {!! $invoices->links() !!}
                </div>
            </div>
        </div>
        <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
       <script>
            function preview(invoiceId) {
                $.ajax({
                    url: '/invoices/' + invoiceId + '/preview',
                    type: "GET",
                    success: function(response) {
                        $(".modal-body").html(response);
                        $("#bd-example-modal-lg").modal("show");
                    }
                });
            }
       </script>
       <style>
           .modal-lg, .modal-xl {
                max-width: 845px;
            }
       </style>
    @endpush
</x-app-layout>