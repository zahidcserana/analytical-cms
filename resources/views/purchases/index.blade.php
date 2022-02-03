<x-app-layout>
    <div class="min-height-200px">
        <div class="card-box mb-30">
            <div class="pd-20 clearfix">
                <h4 class="text-title h4 pull-left">Purchase List</h4>
                <a href="{{ route('purchases.create') }}" class="btn btn-info pull-right"><i class="fa fa-plus-circle"></i> New </a>

            </div>
            <div class="pb-20 search-table">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="card" style="border: none;">
                            <form class="card-body form-inline" method="GET" action="{{ route('purchases.index') }}">
                            <div class="form-group mb-1 mr-sm-2">
                                <input type="text" class="form-control" name="purchase_no" placeholder="Invoice No" value="{{ $query['purchase_no'] ?? '' }}">
                              </div>
                            <select class="custom-select mb-1 mr-sm-2" name="supplier_id">
                                <option value="">-- Supplier --</option>
                                @foreach ($suppliers as $supplier)
                                    <option {{ !empty($query['supplier_id']) && $query['supplier_id'] == $supplier->id ? 'selected="selected"':'' }} value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                            <select class="custom-select mb-1 mr-sm-2" name="status">
                                <option value="">-- Status --</option>
                                <option {{ (!empty($query['status']) && ($query['status'] == 'pending')) ? "selected='selected'" : '' }} value="pending">Pending</option>
                                <option {{ (!empty($query['status']) && ($query['status'] == 'paid')) ? "selected='selected'" : '' }} value="paid">Paid</option>
                                <option {{ (!empty($query['status']) && ($query['status'] == 'due')) ? "selected='selected'" : '' }} value="due">Due</option>
                            </select>
                            <div class="input-group mb-2 mr-sm-2">
                                <input value="{{ $query['daterange'] ?? '' }}" class="form-control datetimepicker-range" name="daterange" placeholder="Select Month" type="text" autocomplete="off">
                            </div>
                            <button type="submit" class="btn mb-2 mr-sm-2" data-bgcolor="#c32361" data-color="#ffffff"><i class="fa fa-search"></i></button>
                            <a href="{{ route('purchases.index') }}" class="btn mb-2 mr-sm-2" data-bgcolor="#f46f30" data-color="#ffffff"><i class="fa fa-refresh"></i></a>
                        </form>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="card" style="border: none;">
                        <table class="card-body table table-striped table-info">
                            <thead>
                                <tr>
                                    <th>Amount</th>
                                    <th>Paid</th>
                                    <th>Due</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $summary['total'] }}</td>
                                    <td>{{ $summary['paid'] }}</td>
                                    <td>{{ $summary['total'] - $summary['paid'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                      </div>
                    </div>
                </div>
                <div class="card">
                    <table class="card-body table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th class="table-plus datatable-nosort">Invoice/Bill</th>
                                <th>Date</th>
                                <th>Supplier</th>
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
                            @foreach ($purchases as $row)
                            <tr>
                                <td class="table-plus">
                                    <a href="{{route('purchases.edit', ['purchase' => $row->id])}}"><i class="dw dw-pencil"></i> {{ $row->purchase_no }}</a>
                                </td>
                                <td> {{ Carbon\Carbon::parse($row->purchase_date)->format('d/m/Y') }} </td>
                                <td>{{ $row->supplier->name }}</td>
                                <td>{{ $row->sub_total }}</td>
                                <td>{{ $row->discount }}</td>
                                <td>{{ $row->total }}</td>
                                <td>{{ $row->paid }}</td>
                                <td>{{ number_format(($row->total - $row->paid), 2, '.', ',') }}</td>
                                <td><span class="badge {{ status_class($row->status) }}">{{ $row->status }}</span></td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <a class="dropdown-item" href="{{route('purchases.edit', ['purchase' => $row->id])}}"><i class="dw dw-edit2"></i> Edit</a>
                                            @include('layouts.utils.delete',array( 'url' => route('purchases.destroy', ['purchase' => $row->id]), 'class'=>'dropdown-item','text' => "<i class='dw dw-delete-3'></i>Delete"))
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="my-pagination">
                    {!! $purchases->links() !!}
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
</x-app-layout>