<x-print-layout>
    <div class="min-height-200px">
        <div class="card-box mb-30">
            <div class="pd-20 clearfix">
                <h5 class="font-18 text-center h5">Payment List</h5>
                <p class="text-center">
                    <span>Total: {{ $payments->count() }}, </span>
                    <span>Collected: {{ $summary['amount'] + $summary['adjust'] }} Tk, </span>
                    <span>Adjust: {{ $summary['adjust'] }} Tk, </span>
                    <span>Remaining: {{ $summary['amount'] }} Tk</span>
                </p>
            </div>
            <div class="pb-20" style="padding: 0% 1%;">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Receipt No</th>
                            <th>Customer</th>
                            <th class="text-center">Method</th>
                            <th class="text-right">Collected</th>
                            <th class="text-right">Adjust</th>
                            <th class="text-right">Remaining</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $i=>$row)
                            <tr>
                                <td>{{ $row->receipt_no }}</td>
                                <td>{{ $row->customer->name }}</td>
                                <td class="text-center">{{ $row->method }}</td>
                                <td class="text-right">{{ $row->amount + $row->adjust }}</td>
                                <td class="text-right">{{ (int)$row->adjust }}</td>
                                <td class="text-right">{{ (int)$row->amount }}</td>
                                <td class="text-center">{{ $row->status }}</td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-print-layout>
