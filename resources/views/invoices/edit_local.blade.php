<x-app-layout>
    <div class="min-height-200px">
        <div class="card-box mb-30">
            <div class="pd-20 clearfix">
                <h4 class="text-blue h4 pull-left">Invoice Due: &nbsp;{{ $invoice->total - $invoice->paid }}, &nbsp; Status: {{ $invoice->status }}</h4>
                <a href="{{ route('invoices.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-left"></i> Back </a>
            </div>
            <div class="pd-20">
                @include("layouts.alert")
                <form method="post" action="{{ route('invoices.update', ['invoice' => $invoice]) }}" autocomplete="off" novalidate>
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $invoice->id }}">
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-1 col-form-label">Bill No</label>
                        <div class="col-sm-12 col-md-5">
                            <span class="form-control">{{ $invoice->invoice_no }}</span>
                        </div>
                        <label class="col-sm-12 col-md-1 col-form-label">Status</label>
                        <div class="col-sm-12 col-md-5">
                            <select class="custom-select col-12" name="status">
                                <option value="">-Select-</option>
                                <option {{ $invoice->status == 'pending' ? "selected='selected'" : "" }} value="pending">Pending</option>
                                <option {{ $invoice->status == 'due' ? "selected='selected'" : "" }} value="due">Due</option>
                                <option {{ $invoice->status == 'paid' ? "selected='selected'" : "" }} value="paid">Paid</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-1 col-form-label">Customer</label>
                        <div class="col-sm-12 col-md-5">
                            <span class="form-control">{{ $invoice->customer->name }}</span>
                        </div>
                        <label class="col-sm-12 col-md-1 col-form-label">Date</label>
                        <div class="col-sm-12 col-md-5">
                            <input value="{{ $invoice->invoice_date }}" class="form-control my-date-picker" name="invoice_date" placeholder="Select Date" type="text" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-1 col-form-label">Amount</label>
                        <div class="col-sm-12 col-md-5">
                            <input class="form-control" placeholder="Amount" type="text" name="total" value="{{ $invoice->total }}">
                        </div>
                        <label class="col-sm-12 col-md-1 col-form-label">Paid</label>
                        <div class="col-sm-12 col-md-5">
                            <input class="form-control" placeholder="Paid" type="text" name="paid" value="{{ $invoice->paid }}">
                        </div>
                    </div>
                    <div class="text-center">
                        <x-button class="btn btn-primary">{{ __('Save') }}</x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
