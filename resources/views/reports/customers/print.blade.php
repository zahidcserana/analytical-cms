<x-print-layout>
    <div class="min-height-200px">
        <div class="card-box mb-30">
            <div class="pd-20 clearfix">
                <h5 class="font-18 text-center h5">Customer List</h5>
                <p class="text-center">
                <span>Total: {{ $customers->count() }}, </span>
                <span>Due: {{ $summary['balance'] }} Tk</span>
                </p>
            </div>
            <div class="pb-20" style="padding: 0% 1%;">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Name</th>
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
</x-print-layout>
