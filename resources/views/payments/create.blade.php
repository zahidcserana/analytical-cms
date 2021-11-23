<x-app-layout>
    <div class="min-height-200px">
        <div class="card-box mb-30">
            <div class="pd-20 clearfix">
                <h4 class="text-title h4 pull-left">Payment Create</h4>
                <a href="{{ route('payments.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-left"></i> Back </a>
            </div>
            <div class="pd-20">
                <form method="POST" action="{{ route('payments.store') }}">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Customer</label>
                        <div class="col-sm-12 col-md-4">
                            <select class="custom-select col-12 customer-select" name="customer_id">
                                <option value="">-Select-</option>
                                @foreach ($customers as $customer)
                                    <option {{ old('customer_id') == $customer->id ? "selected='selected'" : '' }} value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-sm-12 col-md-2 col-form-label">Amount</label>
                        <div class="col-sm-12 col-md-4">
                            <input class="form-control" placeholder="Amount" type="number" name="amount" value="{{ old('amount') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Payment Method</label>
                        <div class="col-sm-12 col-md-4">
                            <select class="custom-select col-12 payment-method" name="method">
                                <option value="">-Select-</option>
                                @foreach (Config::get('settings.paymentMethod') as $key => $value)
                                    <option {{ old('method') == $key ? "selected='selected'" : '' }} value="{{ $key }}">{{ $key }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-sm-12 col-md-2 col-form-label">Dues</label>
                        <div class="col-sm-12 col-md-4">
                            <input class="form-control" placeholder="Dues" type="number" id="dues" name="dues" value="{{ old('dues') }}">
                        </div>
                    </div>
                    <div class="form-group row bank-details" {{ (!empty(old('method')) && old('method')=='Bank')?"":"style=display:none" }}>
                        <label class="col-sm-12 col-md-2 col-form-label">Bank Details</label>
                        <div class="col-sm-12 col-md-3">
                            <input class="form-control" placeholder="Bank Name" type="text" name="bank_details[name]" value="{{ old('bank_details.name') }}">
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <input class="form-control" placeholder="Check No" type="text" name="bank_details[check_no]" value="{{ old("bank_details.check_no") }}">
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <input value="{{ old("bank_details.check_date") ?? date('Y-m-d') }}" class="form-control my-date-picker" name="bank_details[check_date]" placeholder="Check Date" type="text" autocomplete="off">
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <input class="form-control" placeholder="Check Amount" type="text" name="bank_details[check_amount]" value="{{ old("bank_details.check_amount") }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Created By</label>
                        <div class="col-sm-12 col-md-4">
                            <input class="form-control" placeholder="Created By" type="text" name="created_by" value="{{ old('created_by') }}">
                        </div>
                        <label class="col-sm-12 col-md-2 col-form-label">Received By</label>
                        <div class="col-sm-12 col-md-4">
                            <input class="form-control" placeholder="Received By" type="text" name="received_by" value="{{ old("received_by") }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Remarks</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" placeholder="Remarks" type="text" name="payload" value="{{ old('payload') }}">
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
            new Payment();
        </script>
    @endpush
</x-app-layout>
