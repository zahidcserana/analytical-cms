<x-app-layout>
    <div class="min-height-200px">
        <div class="card-box mb-30">
            <div class="pd-20 clearfix">
                <h4 class="text-blue h4 pull-left">Customer List</h4>
                <a href="{{ route('customers.create') }}" class="btn btn-info pull-right"><i class="fa fa-plus-circle"></i> New </a>

            </div>
            <div class="pb-20" style="padding: 0% 1%;">
                <div class="row">
                    <div class="col-7">
                    </div>
                    <div class="col-5">
                        <table class="table table-striped table-info">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Due</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $customers->count() }}</td>
                                    <td>{{ $summary['balance'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <table class="table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th class="table-plus datatable-nosort">Name</th>
                            <th>Mobile</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Balance</th>
                            <th>Status</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $row)
                        <tr>
                            <td class="table-plus">{{ $row->name }}</td>
                            <td>{{ $row->mobile }}</td>
                            <td>{{ $row->phone }}</td>
                            <td>{{ $row->email }}</td>
                            <td>{{ $row->balance }}</td>
                            <td>{{ $row->status }}</td>
                            <td>{{ $row->address }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>