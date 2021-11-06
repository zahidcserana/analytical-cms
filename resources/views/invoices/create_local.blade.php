<x-app-layout>
    <div class="min-height-200px">
        <div class="card-box mb-30">
            <div class="pd-20 clearfix">
                <h4 class="text-title h4 pull-left">Invoice Local</h4>
                <a href="{{ route('invoices.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-left"></i> Back </a>
            </div>
            <div class="pd-20">
                <form method="post" action="{{ route('invoices.store') }}" autocomplete="off" novalidate>
                    @csrf
                    <input type="hidden" name="type" value="2">
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-1 col-form-label">Bill No</label>
                        <div class="col-sm-12 col-md-5">
                            <input value="{{ $invoiceNo }}" class="form-control" name="invoice_no" placeholder="Invoice No" type="text" autocomplete="off">
                        </div>
                        <label class="col-sm-12 col-md-1 col-form-label">Status</label>
                        <div class="col-sm-12 col-md-5">
                            <select class="custom-select col-12" name="status">
                                <option value="">-Select-</option>
                                <option value="pending" selected>Pending</option>
                                <option value="due">Due</option>
                                <option value="paid">Paid</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-1 col-form-label">Customer</label>
                        <div class="col-sm-12 col-md-5">
                            <select class="custom-select col-12" name="customer_id">
                                <option value="">-Select Customer-</option>
                                @foreach ($customers as $customer)
                                    <option {{ (!empty(old('customer_id')) && (old('customer_id') == $customer->id)) ? "selected='selected" : ''}} value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-sm-12 col-md-1 col-form-label">Date</label>
                        <div class="col-sm-12 col-md-5">
                            <input value="{{ date('Y-m-d') }}" class="form-control my-date-picker" name="invoice_date" placeholder="Select Date" type="text" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-1 col-form-label">Amount</label>
                        <div class="col-sm-12 col-md-5">
                            <input class="form-control" name="total" placeholder="Amount" type="text" autocomplete="off" value="{{ old('total') }}">
                        </div>
                        <label class="col-sm-12 col-md-1 col-form-label">Paid</label>
                        <div class="col-sm-12 col-md-5">
                            <input class="form-control" placeholder="Paid" type="text" name="paid" value="{{ old('paid') }}">
                        </div>
                    </div>
                    <div class="text-center">
                        <x-button class="btn btn-primary">{{ __('Save') }}</x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            new Invoice();
        </script>
    @endpush
</x-app-layout>
