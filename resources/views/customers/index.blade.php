<x-app-layout>
    <div class="min-height-200px">
        <div class="card-box mb-30">
            <div class="pd-20 clearfix">
                <h4 class="text-title h4 pull-left">Customer List</h4>
                <a href="{{ route('customers.create') }}" class="btn btn-info pull-right"><i class="fa fa-plus-circle"></i> New </a>

            </div>
            <div class="pb-20 search-table">
                <form class="form-inline" method="GET" action="{{ route('customers.index') }}">
                    <div class="form-group mb-2 mr-sm-2">
                        <input type="text" class="form-control" name="name" placeholder="Name" value="{{ $query['name'] ?? '' }}">
                    </div>
                    <div class="form-group mb-2 mr-sm-2">
                        <input type="text" class="form-control" name="mobile" placeholder="Mobile" value="{{ $query['mobile'] ?? '' }}">
                    </div>
                    <div class="form-group mb-2 mr-sm-2">
                        <input type="text" class="form-control" name="email" placeholder="Email" value="{{ $query['email'] ?? '' }}">
                    </div>
                    <button type="submit" class="btn mb-2 mr-sm-2" data-bgcolor="#c32361" data-color="#ffffff"><i class="fa fa-search"></i> {{ __('Search') }}</button>
                    <a href="{{ route('customers.index') }}" class="btn mb-2" data-bgcolor="#f46f30" data-color="#ffffff"><i class="fa fa-refresh"></i> {{ __('Reset') }}</a>
                </form>
                <table class="table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th style="width: 20%">Name</th>
                            <th>Mobile</th>
                            <th>Phone</th>
                            <th style="width: 15%">Email</th>
                            <th>Balance</th>
                            <th>Status</th>
                            <th>Address</th>
                            <th class="datatable-nosort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $row)
                        <tr>
                            <td>
                                <a class="link-a" href="{{route('customers.edit', ['customer' => $row->id])}}"><i class="fa fa-edit"></i> {{ $row->name }}</a>
                            </td>
                            <td>{{ $row->mobile }}</td>
                            <td>{{ $row->phone }}</td>
                            <td>{{ $row->email }}</td>
                            <td>{{ $row->balance }}</td>
                            <td><span class="badge {{ status_class($row->status) }}">{{ status($row->status) }}</span></td>
                            <td>{{ $row->address }}</td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                        <i class="dw dw-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                        <a class="dropdown-item" href="{{route('customers.edit', ['customer' => $row->id])}}"><i class="dw dw-edit2"></i> Edit</a>
                                        @include('layouts.utils.delete',array( 'url' => route('customers.destroy', ['customer' => $row->id]), 'class'=>'dropdown-item','text' => "<i class='dw dw-delete-3'></i>Delete"))
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="my-pagination">
                    {!! $customers->links() !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
