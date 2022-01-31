<x-app-layout>
    <div class="min-height-200px">
        <div class="card-box mb-30">
            <div class="pd-20 clearfix">
                <h4 class="text-title h4 pull-left">Expense List</h4>
                <a href="{{ route('expenses.create') }}" class="btn btn-info pull-right"><i class="fa fa-plus-circle"></i> New </a>

            </div>
            <div class="pb-20 search-table">
                <form class="form-inline" method="GET" action="{{ route('expenses.index') }}">
                    <div class="form-group mb-2 mr-sm-2">
                        <input type="text" class="form-control" name="bill_no" placeholder="Bill No" value="{{ $query['bill_no'] ?? '' }}">
                    </div>
                    <select class="custom-select mb-2 mr-sm-2" name="expense_type">
                        <option value="">-Select Type-</option>
                        @foreach (Config::get('settings.expenseType') as $key => $value)
                            <option {{ (!empty($query['expense_type']) && ($query['expense_type'] == $key)) ? "selected='selected'" : '' }} value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <div class="form-group mb-2 mr-sm-2">
                        <input value="{{ $query['daterange'] ?? '' }}" class="form-control datetimepicker-range" name="daterange" placeholder="Select Month" type="text" autocomplete="off">
                    </div>
                    <button type="submit" class="btn mb-2 mr-sm-2" data-bgcolor="#c32361" data-color="#ffffff"><i class="fa fa-search"></i> {{ __('Search') }}</button>
                    <a href="{{ route('expenses.index') }}" class="btn mb-2" data-bgcolor="#f46f30" data-color="#ffffff"><i class="fa fa-refresh"></i> {{ __('Reset') }}</a>
                </form>
                <div>
                    <p><strong>Total:</strong> {{ $expenses->sum('amount') }}</p>
                </div>
                <table class="table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th class="table-plus datatable-nosort">Type</th>
                            <th>Bill No</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th class="datatable-nosort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expenses as $row)
                        <tr>
                            <td class="table-plus">
                                <a href="{{route('expenses.edit', ['expense' => $row->id])}}"><i class="dw dw-pencil"></i> {{ get_expense_type($row->expense_type) }}</a>
                            </td>
                            <td>{{ $row->bill_no }}</td>
                            <td>{{ $row->amount }}</td>
                            <td> {{ Carbon\Carbon::parse($row->expense_date)->format('d/m/Y') }} </td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                        <i class="dw dw-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                        <a class="dropdown-item" href="{{route('expenses.edit', ['expense' => $row->id])}}"><i class="dw dw-edit2"></i> Edit</a>
                                        @include('layouts.utils.delete',array( 'url' => route('expenses.destroy', ['expense' => $row->id]), 'class'=>'dropdown-item','text' => "<i class='dw dw-delete-3'></i>Delete"))
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="my-pagination">
                    {!! $expenses->links() !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>