<x-app-layout>
    <div class="min-height-200px">
        <div class="card-box mb-30">
            <div class="pd-20 clearfix">
                <h4 class="text-blue h4 pull-left">Payment Adjust: <span style="color: black">Amount: {{ $payment->amount }}, Due: {{ $summary['total'] - $summary['paid'] }}</span></h4>
                <a href="{{ route('payments.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-left"></i> Back </a>
            </div>
            <div class="pb-20">
                @if ($invoices->count() > 0)
                <table class="table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Amount</th>
                            <th>Paid</th>
                            <th>Due</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $row)
                        <tr>
                            <td>
                                <a href="javascript:void(0);" onclick="preview({{ $row->id }})"><i class="dw dw-eye"></i> {{ $row->invoice_no }}</a>
                            </td>
                            <td>{{ $row->total }}</td>
                            <td>{{ $row->paid }}</td>
                            <td>{{ $row->total - $row->paid }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td>Total</td>
                            <td>{{ $summary['total'] }}</td>
                            <td>{{ $summary['paid'] }}</td>
                            <td><strong>{{ $summary['total'] - $summary['paid'] }}</strong></td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center">
                    @include('layouts.utils.adjust',array( 'url' => route('payments.adjust', ['payment' => $payment->id]), 'class'=>'btn btn-warning','text' => "Proceed"))
                </div>
                @else
                    <div style="margin: 0 23%; text-align: center;">
                        No  data found
                    </div>
                @endif
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