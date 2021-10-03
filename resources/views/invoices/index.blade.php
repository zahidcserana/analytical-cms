<x-app-layout>
    <div class="min-height-200px">
        <div class="card-box mb-30">
            <div class="pd-20 clearfix">
                <h4 class="text-blue h4 pull-left">Invoice List</h4>
                <a href="{{ route('invoices.create') }}" class="btn btn-info pull-right"><i class="fa fa-plus-circle"></i> New </a>

            </div>
            <div class="pb-20">
                <table class="data-table table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th class="table-plus datatable-nosort">No</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Discount</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Status</th>
                            <th class="datatable-nosort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $row)
                        <tr>
                            <td class="table-plus">{{ $row->invoice_no }}</td>
                            <td>{{ $row->customer_id }}</td>
                            <td>{{ $row->total }}</td>
                            <td>{{ $row->discount }}</td>
                            <td>{{ $row->paid }}</td>
                            <td>{{ ($row->total - $row->discount) - $row->paid }}</td>
                            <td>{{ $row->status }}</td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                        <i class="dw dw-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                        <a class="dropdown-item" href="#"><i class="dw dw-eye"></i> View</a>
                                        <a class="dropdown-item" href="{{route('invoices.edit', ['invoice' => $row->id])}}"><i class="dw dw-edit2"></i> Edit</a>
                                        @include('layouts.utils.delete',array( 'url' => route('invoices.destroy', ['invoice' => $row->id]), 'class'=>'dropdown-item','text' => "<i class='dw dw-delete-3'></i>Delete"))
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>